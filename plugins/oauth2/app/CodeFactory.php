<?php

namespace Plugins\OAuth2\App;

use Laravel\Passport\Bridge\User;
use Laravel\Passport\Bridge\AuthCodeRepository;
use Plugins\OAuth2\App\Contracts\AbstractFactory;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class CodeFactory extends AbstractFactory
{
	protected $authCodeTTL = null;

	public function __construct(\DateInterval $authCodeTTL, $encryptionKey)
	{
		parent::__construct($encryptionKey);

		$this->setAuthCodeTTL($authCodeTTL);

		$this->authCodeRepository = app(AuthCodeRepository::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setAuthCodeTTL(\DateInterval $authCodeTTL)
	{
		$this->authCodeTTL = $authCodeTTL;
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

	/**
	 * [make description]
	 * @param  [type] $client_id
	 * @param  [type] $user_id
	 * @param  ScopeEntityInterface[]  $scopes
	 * @return [type]
	 */
	public function make($client_id, $user_id, array $scopes = [], $codeChallenge = null, $codeChallengeMethod = 'plain')
	{
		$client = $this->clientRepository->getClientEntity(
			$client_id,
			$this->getIdentifier(),
			null,
			false
		);
		$user = new User($user_id);

		if (!empty($codeChallenge))
		{
			if (preg_match('/^[A-Za-z0-9-._~]{43,128}$/', $codeChallenge) !== 1) {
				throw OAuthServerException::invalidRequest(
					'code_challenge',
					'The code_challenge must be between 43 and 128 characters'
				);
			}

			if (in_array($codeChallengeMethod, ['plain', 'S256']) === false) {
				throw OAuthServerException::invalidRequest(
					'code_challenge_method',
					'Code challenge method must be `plain` or `S256`'
				);
			}
		}

		$authCode = $this->issueAuthCode(
			$this->authCodeTTL,
			$client,
			$user->getIdentifier(),
			$scopes
		);

		$payload = [
			'client_id'             => $authCode->getClient()->getIdentifier(),
			'auth_code_id'          => $authCode->getIdentifier(),
			'scopes'                => $authCode->getScopes(),
			'user_id'               => $authCode->getUserIdentifier(),
			'expire_time'           => (new \DateTime())->add($this->authCodeTTL)->format('U'),
			'code_challenge'        => !empty($codeChallenge) ? $codeChallenge : null,
			'code_challenge_method' => !empty($codeChallenge) ? $codeChallengeMethod : null,
		];

		return $this->encrypt(json_encode($payload));
	}

	/**
	 * Issue an auth code.
	 *
	 * @param \DateInterval          $authCodeTTL
	 * @param ClientEntityInterface  $client
	 * @param string                 $userIdentifier
	 * @param string                 $redirectUri
	 * @param ScopeEntityInterface[] $scopes
	 *
	 * @throws OAuthServerException
	 * @throws UniqueTokenIdentifierConstraintViolationException
	 *
	 * @return AuthCodeEntityInterface
	 */
	protected function issueAuthCode(
		\DateInterval $authCodeTTL,
		ClientEntityInterface $client,
		$userIdentifier,
		array $scopes = []
	) {
		$maxGenerationAttempts = self::MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS;

		$authCode = $this->authCodeRepository->getNewAuthCode();
		$authCode->setExpiryDateTime((new \DateTime())->add($authCodeTTL));
		$authCode->setClient($client);
		$authCode->setUserIdentifier($userIdentifier);

		foreach ($scopes as $scope) {
			$authCode->addScope($scope);
		}

		while ($maxGenerationAttempts-- > 0) {
			$authCode->setIdentifier($this->generateUniqueIdentifier());
			try {
				$this->authCodeRepository->persistNewAuthCode($authCode);

				return $authCode;
			} catch (UniqueTokenIdentifierConstraintViolationException $e) {
				if ($maxGenerationAttempts === 0) {
					throw $e;
				}
			}
		}
	}
}
