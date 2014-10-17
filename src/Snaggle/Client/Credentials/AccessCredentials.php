<?php
namespace Snaggle\Client\Credentials;

class AccessCredentials implements Credential
{
    /**
     * Property for the identifying token
     */
    private $token;

    /**
     * Property for the secret
     */
    private $secret;

    /**
     * Method to set the identifier
     *
     * @param string $token
     */
    public function setIdentifier($token)
    {
        $this->token = $token;
    }

    /**
     * Method to retrieve the identifier
     *
     * @return string identifier for this credential
     */
    public function getIdentifier()
    {
        return $this->token;
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
