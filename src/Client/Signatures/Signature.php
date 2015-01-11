<?php
namespace Snaggle\Client\Signatures;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright (c) 2014
 * @license http://opensource.org/licenses/MIT MIT
 * @package Snaggle
 * @subpackage Client
 *
 * Base functionality for the signatures, including all the 
 * properties and accessor methods
 */
class Signature
{
    /**
     * Value for the nonce
     *                   
     * @var string $nonce
     */
    protected $nonce = '';

    /**
     * Value for the OAuth Version
     *
     * @var string $version
     */
    protected $version = '1.0';

    /**
     * Value for the callback
     *
     * @var string $callback
     */
    protected $callback = '';

    /**
     * Value for the timestamp
     *
     * @var int $timestamp
     */
    protected $timestamp = 0;

    /**
     * Value for the signature method
     *
     * @var string $signature_method
     */
    protected $signatureMethod = 'HMAC-SHA1';

    /**
     * Instance of consumer credential
     *
     * @var \Snaggle\Client\Credentials\CredentialInterface $consumerCredential
     */
    protected $consumerCredential;

    /**
     * Instance of user credentials
     *
     * @var \Snaggle\Client\Credentials\CredentialInterface $userCredential
     */
    protected $userCredential;

    /**
     * Value of the HTTP Method
     *
     * @var string
     */
    protected $httpMethod;

    /**
     * Resource URL attempting to be accessed
     *
     * @var string
     */
    protected $resourceURL;

    /**
     * Post fields that may be sent and may be required in the base string
     *
     * @var array
     */
    protected $postFields = array();

    /**
     * OAuth Verifier value used in the access token request
     */
    protected $verifier = '';

    /**
     * Constructor
     *
     * @param \Snaggle\Client\Credentials\CredentialInterface $consumerCredential
     * @param \Snaggle\Client\Credentials\CredentialInterface $userCredential
     */
    public function __construct(
        \Snaggle\Client\Credentials\CredentialInterface $consumerCredential,
        \Snaggle\Client\Credentials\CredentialInterface $userCredential
    )
    {
        $this->consumerCredential = $consumerCredential;
        $this->userCredential = $userCredential;
    }

   /**
    * Method for retrieving HTTP Verb
    *
    * @return string
    */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }
    
    /**
     * Method to set the HTTP verb for the request
     *
     * @param string $method
     */
    public function setHttpMethod($method)
    {
        $allowedMethods = array(
             'POST',
             'PUT',
             'GET',
             'DELETE',
             'PATCH'
        );
        if (!in_array(strtoupper($method), $allowedMethods)) {
            throw new \InvalidArgumentException('Provided method not allowed');
        }
        $this->httpMethod = strtoupper($method);
		return $this;
    }

    /**
     * Method to retrieve resourceURL
     *
     * @return string
     */
    public function getResourceURL()
    {
        return $this->resourceURL;
    }

    /**
     * Method to set the ResourceURL, should allow for the generation of a new
     * signature without needing a new HmacSha1 instance
     *
     * @param string $resourceURL
     */
    public function setResourceURL($resourceURL)
    {
        $this->resourceURL = $resourceURL;
        return $this;
    }

    /**
     * Method to set the nonce
     *
     * @param string $nonce
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
        return $this;
    }

    /**
     * Method to retrieve the nonce
     *
     * @return string
     */
    public function getNonce()
    {
        if ($this->nonce !== '') {
            return $this->nonce;
        }
        $this->nonce = md5(uniqid(rand(), true));
        return $this->nonce;
    }

    /**
     * Method to set the callback
     *
     * @param string $callback
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * Method to retrieve the callback
     *
     * @return string
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Method to get the version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Generate the timestamp
     */
    public function generateTimestamp()
    {
        return time();
    }

    /**
     * Method to generate timestamp
     *
     * @return int
     */
    public function getTimestamp()
    {
        if ($this->timestamp === 0) {
            return $this->generateTimestamp();
        }
        return $this->timestamp;
    }

    /**
     * Method to set the timestamp parameter for the signature
     *
     * @param int $timestamp
     */
    public function setTimestamp($timestamp = 0)
    {
        $this->timestamp = $timestamp;
        if ($timestamp === 0) {
            $this->timestamp = $this->generateTimestamp();
        }
        return $this;
    }

    /**
     * Method to retrieve the signature method
     *
     * @return string
     */
    public function getSignatureMethod()
    {
        return $this->signatureMethod;
    }

    /**
     * Method for retrieving the consumer
     *
     * @return \Snaggle\Client\Credentials\CredentialInterface
     */
    public function getConsumer()
    {
        return $this->consumerCredential;
    }

    /**
     * Method for retrieving the user credentials
     *
     * @return \Snaggle\Client\Credentials\CredentialInterface
     */
    public function getUser()
    {
        return $this->userCredential;
    }

    /**
     * Method to set the POST FIELDS or data of a post request, this may be required in your 
     * base string
     *
     * @param array $postFields
     */
    public function setPostFields(array $postFields)
    {
        $this->postFields = $postFields;
        return $this;
    }

    /**
     * Method to retrieve any set postFields you've included
     *
     * @return array
     */
    public function getPostFields()
    {
        return $this->postFields;
    }

    /**
     * Method to set the verifier
     *
     * @param string $verifier
     */
    public function setVerifier($verifier)
    {
        $this->verifier = $verifier;
        return $this;
    }

    /**
     * Method to retrieve the verifier
     *
     * @return string
     */
    public function getVerifier()
    {
        return $this->verifier;
    }
}
