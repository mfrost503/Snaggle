<?php
namespace Snaggle\OAuth1\Client\Signature;
/**
 * Class to facilitate the creation of the Authorization header that needs to
 * to be sent for the request
 */
class HmacSha1
{
    /**
     * Value for the nonce
     *
     * @var string $nonce
     */
    private $nonce = '';

    /**
     * Value for the OAuth Version
     *
     * @var string $version
     */
    private $version = '1.0';

    /**
     * Value for the callback
     *
     * @var string $callback
     */
    private $callback = '';

    /**
     * Value for the timestamp
     *
     * @var int $timestamp
     */
    private $timestamp;

    /**
     * Value for the signature method
     *
     * @var string $signature_method
     */
    private $signature_method = 'HMAC-SHA1';

    /**
     * Instance of consumer credential
     *
     * @var \Snaggle\OAuth1\Client\Credential $consumerCredential
     */
    private $consumerCredential;

    /**
     * Instance of user credentials
     *
     * @var \Snaggle\OAuth1\Client\Credential $userCredential
     */
    private $userCredential;

    /**
     * Value of the HTTP Method 
     *
     * @var string
     */
    private $httpMethod;

    /**
     * Resource URL attempting to be accessed
     *
     * @var string
     */
    private $resourceURL;
    
    /**
     * Constructor
     *
     * @param string $resourceURL
     * @param \Snaggle\OAuth1\Client\Credential $consumerCredential
     * @param \Snaggle\OAuth1\Client\Credential $userCredential
     * @param string $httpMethod
     */
    public function __construct(
        $resourceURL,
        \Snaggle\OAuth1\Client\Credential $consumerCredential,
        \Snaggle\OAuth1\Client\Credential $userCredential,
        $httpMethod = 'GET'
    )
    {
        $this->resourceURL = $resourceURL;
        $this->consumerCredential = $consumerCredential;
        $this->userCredential = $userCredential;
        $this->httpMethod = $httpMethod;
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
    }

    /**
     * Method to set the nonce
     *
     * @param string $nonce
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
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
        return md5(uniqid(rand(), true));
    }

    /**
     * Method to set the callback
     *
     * @param string $callback
     */
    public function setCallback($callback)
    {
        $this->callback = $callback
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
     * Method to generate timestamp
     *
     * @return int
     */
    public function getTimestamp()
    {
        return time();
    }

