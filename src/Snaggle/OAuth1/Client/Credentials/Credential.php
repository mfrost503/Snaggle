<?php
namespace Snaggle\OAuth1\Client\Credentials;
/**
 * Credential interface defines the contract for a Credential clas
 */

interface Credential
{
    /**
     * getIdentifier method to return the identifying value of the credential
     *
     * @return string 
     */
    public function getIdentifier();

    /**
     * getSecret method to return the secret token for the credential
     *
     * @return string
     */
    public function getSecret();
}
