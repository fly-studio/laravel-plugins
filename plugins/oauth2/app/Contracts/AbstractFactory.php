<?php

namespace Plugins\OAuth2\App\Contracts;

use League\OAuth2\Server\CryptTrait;
use Laravel\Passport\Bridge\ScopeRepository;
use Laravel\Passport\Bridge\ClientRepository;
use League\OAuth2\Server\Exception\OAuthServerException;

abstract class AbstractFactory {

	use CryptTrait;

	const MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS = 10;

	protected $clientRepository;
	protected $scopeTokenRepository;


	public function __construct($encryptionKey)
	{
		$this->setEncryptionKey($encryptionKey);
		$this->clientRepository = app(ClientRepository::class);
		$this->scopeTokenRepository = app(ScopeRepository::class);
	}

	abstract public function getIdentifier();

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
