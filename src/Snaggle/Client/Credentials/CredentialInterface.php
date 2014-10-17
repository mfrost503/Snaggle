<?php
namespace Snaggle\Client\Credentials;
/**
 * Credential interface defines the contract for a Credential clas
 */

interface CredentialInterface
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
