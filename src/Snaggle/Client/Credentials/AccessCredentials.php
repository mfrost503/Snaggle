<?php
namespace Snaggle\Client\Credentials;

class AccessCredentials implements CredentialInterface
{
    /**
     * Property for the identifying token
     */
    private $identifier;

    /**
     * Property for the secret
     */
    private $secret;

    /**
     * Method to set the identifier
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
