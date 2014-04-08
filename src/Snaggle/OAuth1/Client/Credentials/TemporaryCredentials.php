<?php
namespace Snaggle\OAuth1\Client\Credential;
/**
 * Representation of the temporary credentials that are sent back after the
 * authorization step is complete on the third party site
 */
class TemporaryCredentials
{
    /**
     * The OAuth token that is provided after authorization
     * 
     * @var string $token
     */
    private $token = '';

    /**
     * The OAuth Verifier that is sent back confirming authorization
     *
     * @var string $verifier
     */
    private $verifier = '';

    /**
     * Method to set the temporary token
     *
     * @param string $token
     */
    public function setIdentifier($token)
    {
        $this->token = $token;
    }

    /**
     * Method to retrieve the temporary token
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->token;
    }

    /**
     * Method to set the verifier
     *
     * @param string $verifier
     */
    public function setVerifier($verifier)
    {
        $this->verifier = $verifier;
    }

    /**
     * Method to return the verifier value
     *
     * @return string
     */
    public function getVerifier()
    {
        return $this->verifier;
    }
}
