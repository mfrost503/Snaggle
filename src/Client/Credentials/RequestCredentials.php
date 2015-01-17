<?php
namespace Snaggle\Client\Credentials;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * This will store the temporary credentials that are sent back in the first
 * step of the token exchange. These are short-lived credentials and will
 * expire if they aren't exchanged for Access Credentials
 */
class RequestCredentials implements CredentialInterface
{
    /**
     * The identifier for the Request Credential
     *
     * @var string $identifier
     */
    private $identifier = '';

    /**
     * The secret for the Request Credential
     *
     * @var string $secret
     */
    private $secret = '';

    /**
     * @param string $identifier
     * @param string $secret
     */
    public function __construct($identifier = '', $secret = '')
    {
        $this->identifier = $identifier;
        $this->secret = $secret;
    }

    /**
     * Method to retrieve the identifier associated with the request
     * credentials
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Method to set the identifier for the request credential
     *
     * @deprecated Will be removed with 1.0.0, set values with constructor instead.
     *
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Method to retrieve the secret from the request credential
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Method to set the secret for the request credential
     *
     * @deprecated Will be removed with 1.0.0, set values with constructor instead.
     *
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }
}
