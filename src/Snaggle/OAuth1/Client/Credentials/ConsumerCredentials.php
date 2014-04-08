<?php
namespace Snaggle\OAuth1\Client\Credentials;
/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage OAuth1
 * @license http://opensource.org/licenses/MIT MIT
 *
 * A class to represent the credentials of the consuming service provider,
 * these are the credentials that are assigned when an API application 
 * is created
 */
class ConsumerCredentials implements Credential
{
    /**
     * The public API key that is assigned at the creation of the application
     *
     * @var $key string
     */
    private $key = '';

    /**
     * The API secret that is assigned at the creation of the application
     *
     * @var $secret string
     */
    private $secret = '';

    /**
     * Method to retrieve the identifying property from the credential
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->key;
    }

    /**
     * Method to set the identifying property from the credential
     *
     * @param string $key
     */
    public function setIdentifier($key)
    {
        $this->key = $key;
    }

    /**
     * Method to retrieve the secret from the credential
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Method to set the secret for this credential
     *
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }
}
