<?php
namespace Snaggle\Client\Credentials;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * A class to represent the credentials of the resource owner,
 * these are the credentials that are assigned when a successful
 * token retrieval has been made
 */
class AccessCredentials implements CredentialInterface
{
    /**
     * Property for the identifying token
     */
    private $identifier = '';

    /**
     * Property for the secret
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
     * Method to set the identifier
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
     * Method to retrieve the identifier
     *
     * @return string identifier for this credential
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Method to set the secret for this identifier
     *
     * @deprecated Will be removed with 1.0.0, set values with constructor instead.
     *
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * Method to retrieve the secret
     *
     * @return string $secret
     */
    public function getSecret()
    {
        return $this->secret;
    }
}
