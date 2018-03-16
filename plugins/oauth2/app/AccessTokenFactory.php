<?php

namespace Plugins\OAuth2\App;

use Laravel\Passport\Bridge\User;
use League\OAuth2\Server\CryptKey;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Bridge\AccessTokenRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class AccessTokenFactory
{
	const MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS = 10;

	/**
	 * @var \DateInterval
	 */
	private $accessTokenTTL;

	/**
	 * @var \League\OAuth2\Server\CryptKey
	 */
	protected $privateKey;

	protected $clientRepository;

	public function __construct(\DateInterval $accessTokenTTL, $privateKey)
	{
		$this->setAccessTokenTTL($accessTokenTTL);
		$this->setPrivateKey($privateKey);
		$this->clientRepository = app(ClientRepository::class);
		$this->accessTokenRepository = app(AccessTokenRepository::class);
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

	public function make($client_id, $user_id, array $scopes = [])
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
		return [
			'access_token' => (string) $accessToken->convertToJWT($this->privateKey),
			'token_type'   => 'Bearer',
			'expires_in'   => $accessToken->getExpiryDateTime()->getTimestamp() - (new \DateTime())->getTimestamp(),
		];


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
