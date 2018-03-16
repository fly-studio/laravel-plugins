<?php

namespace Plugins\OAuth2\App;

use Laravel\Passport\Bridge\User;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\CryptTrait;
use Laravel\Passport\Bridge\ScopeRepository;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class AccessTokenFactory
{
	use CryptTrait;

	const MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS = 10;

	/**
	 * @var \DateInterval
	 */
	private $accessTokenTTL;
	private $refreshTokenTTL;

	/**
	 * @var \League\OAuth2\Server\CryptKey
	 */
	protected $privateKey;

	protected $clientRepository;
	protected $scopeTokenRepository;
	protected $accessTokenRepository;
	protected $refreshTokenRepository;

	public function __construct(\DateInterval $accessTokenTTL, \DateInterval $refreshTokenTTL, $privateKey, $encryptionKey)
	{
		$this->setAccessTokenTTL($accessTokenTTL);
		$this->setRefreshTokenTTL($refreshTokenTTL);
		$this->setPrivateKey($privateKey);
		$this->setEncryptionKey($encryptionKey);
		$this->clientRepository = app(ClientRepository::class);
		$this->accessTokenRepository = app(AccessTokenRepository::class);
		$this->refreshTokenRepository = app(RefreshTokenRepository::class);
		$this->scopeTokenRepository = app(ScopeRepository::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setAccessTokenTTL(\DateInterval $accessTokenTTL)
	{
		$this->accessTokenTTL = $accessTokenTTL;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setRefreshTokenTTL(\DateInterval $refreshTokenTTL)
	{
		$this->refreshTokenTTL = $refreshTokenTTL;
	}

	/**
	 * Set the private key
	 *
	 * @param \League\OAuth2\Server\CryptKey $key
	 */
	public function setPrivateKey(CryptKey $key)
	{
		$this->privateKey = $key;
		return $this;
	}

	/**
	 * Return the grant identifier that can be used in matching up requests.
	 *
	 * @return string
	 */
	public function getIdentifier()
	{
		return 'instant';
	}

	public function make($client_id, $user_id, array $scopes = [], bool $withRefreshToken = true)
	{
		$client = $this->clientRepository->getClientEntity(
			$client_id,
			$this->getIdentifier(),
			null,
			false
		);

		$user = new User($user_id);
		$accessToken = $this->issueAccessToken(
			$this->accessTokenTTL,
			$client,
			$user->getIdentifier(),
			$scopes
		);

		$refreshTokenStr = '';
		if ($withRefreshToken)
		{
			$refreshToken = $this->issueRefreshToken($accessToken);

			$refreshTokenStr = $this->encrypt(
				json_encode(
					[
						'client_id'        => $accessToken->getClient()->getIdentifier(),
						'refresh_token_id' => $refreshToken->getIdentifier(),
						'access_token_id'  => $accessToken->getIdentifier(),
						'scopes'           => $accessToken->getScopes(),
						'user_id'          => $accessToken->getUserIdentifier(),
						'expire_time'      => $refreshToken->getExpiryDateTime()->getTimestamp(),
					]
				)
			);
		}


		return [
			'access_token' => (string) $accessToken->convertToJWT($this->privateKey),
			'token_type'   => 'Bearer',
			'expires_in'   => $accessToken->getExpiryDateTime()->getTimestamp() - (new \DateTime())->getTimestamp(),
		] + ($withRefreshToken ? ['refresh_token' => $refreshTokenStr] : []);
	}

	/**
	 * Issue an access token.
	 *
	 * @param \DateInterval          $accessTokenTTL
	 * @param ClientEntityInterface  $client
	 * @param string                 $userIdentifier
	 * @param ScopeEntityInterface[] $scopes
	 *
	 * @throws OAuthServerException
	 * @throws UniqueTokenIdentifierConstraintViolationException
	 *
	 * @return AccessTokenEntityInterface
	 */
	protected function issueAccessToken(
		\DateInterval $accessTokenTTL,
		ClientEntityInterface $client,
		$userIdentifier,
		array $scopes = []
	) {
		$maxGenerationAttempts = self::MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS;

		$accessToken = $this->accessTokenRepository->getNewToken($client, $scopes, $userIdentifier);
		$accessToken->setClient($client);
		$accessToken->setUserIdentifier($userIdentifier);
		$accessToken->setExpiryDateTime((new \DateTime())->add($accessTokenTTL));

		foreach ($scopes as $scope) {
			$accessToken->addScope($scope);
		}

		while ($maxGenerationAttempts-- > 0) {
			$accessToken->setIdentifier($this->generateUniqueIdentifier());
			try {
				$this->accessTokenRepository->persistNewAccessToken($accessToken);

				return $accessToken;
			} catch (UniqueTokenIdentifierConstraintViolationException $e) {
				if ($maxGenerationAttempts === 0) {
					throw $e;
				}
			}
		}
	}

	/**
	 * @param AccessTokenEntityInterface $accessToken
	 *
	 * @throws OAuthServerException
	 * @throws UniqueTokenIdentifierConstraintViolationException
	 *
	 * @return RefreshTokenEntityInterface
	 */
	protected function issueRefreshToken(AccessTokenEntityInterface $accessToken)
	{
		$maxGenerationAttempts = self::MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS;

		$refreshToken = $this->refreshTokenRepository->getNewRefreshToken();
		$refreshToken->setExpiryDateTime((new \DateTime())->add($this->refreshTokenTTL));
		$refreshToken->setAccessToken($accessToken);

		while ($maxGenerationAttempts-- > 0) {
			$refreshToken->setIdentifier($this->generateUniqueIdentifier());
			try {
				$this->refreshTokenRepository->persistNewRefreshToken($refreshToken);

				return $refreshToken;
			} catch (UniqueTokenIdentifierConstraintViolationException $e) {
				if ($maxGenerationAttempts === 0) {
					throw $e;
				}
			}
		}
	}

	/**
	 * Generate a new unique identifier.
	 *
	 * @param int $length
	 *
	 * @throws OAuthServerException
	 *
	 * @return string
	 */
	protected function generateUniqueIdentifier($length = 40)
	{
		try {
			return bin2hex(random_bytes($length));
			// @codeCoverageIgnoreStart
		} catch (\TypeError $e) {
			throw OAuthServerException::serverError('An unexpected error has occurred');
		} catch (\Error $e) {
			throw OAuthServerException::serverError('An unexpected error has occurred');
		} catch (\Exception $e) {
			// If you get this message, the CSPRNG failed hard.
			throw OAuthServerException::serverError('Could not generate a random string');
		}
		// @codeCoverageIgnoreEnd
	}
}
