<?php
namespace Snaggle\Client\Signatures;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * Class to facilitate the creation of the Authorization header that needs to
 * to be sent for the request
 */
class HmacSha1 extends Signature implements SignatureInterface
{
    /**
     * Value for the signature method
     *
     * @var string $signature_method
     */
    protected $signatureMethod = 'HMAC-SHA1';

    /**
     * Boolean for whether to include an empty token parameter
     *
     * @var boolean $include_empty_token
     */
    protected $include_empty_token = true;

    /**
     * Create the base string for the signature
     */
    public function createBaseString()
    {
        if ($this->timestamp === 0) {
            $this->setTimestamp();
        }

        $paramArray = array(
            'oauth_nonce' => $this->getNonce(),
            'oauth_callback' => $this->callback,
            'oauth_signature_method' => $this->signatureMethod,
            'oauth_timestamp' => $this->getTimestamp(),
            'oauth_consumer_key' => $this->consumerCredential->getIdentifier(),
            'oauth_token' => $this->userCredential->getIdentifier(),
            'oauth_version' => $this->version,
            'oauth_verifier' => $this->getVerifier()
        );

        return $this->buildBaseString($paramArray);
    }

    /**
     * Build the base string based off the values that are passed in
     *
     * @param array $oauthParams
     * @return string
     */
    public function buildBaseString(array $oauthParams)
    {
        $tempArray = array();
        ksort($oauthParams);

        if ($oauthParams['oauth_callback'] === '') {
            unset($oauthParams['oauth_callback']);
        }

        if ($oauthParams['oauth_verifier'] === '') {
            unset($oauthParams['oauth_verifier']);
        }

        array_walk($oauthParams, function($value, $key) use (&$tempArray) {
            $tempArray[] = $key . '=' . rawurlencode($value);
        });

        $parsedUrl = parse_url($this->resourceURL);
        $baseString = $this->httpMethod .'&';
        $baseString .= rawurlencode($parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path']);
        $baseString .= (isset($parsedUrl['query'])) ? '&' . rawurlencode($parsedUrl['query']) . '%26' : '&';
        $baseString .= rawurlencode(implode('&', $tempArray));

        array_walk($this->postFields, function($value, $key) use (&$baseString) {
            $baseString .= '%26' . $key . rawurlencode('=' . $value);
        });

        return $baseString;
    }

    /**
     * Method to generate the composite key
     */
    private function createCompositeKey()
    {
        $key = rawurlencode($this->consumerCredential->getSecret()) . '&';
        if (($userSecret = $this->userCredential->getSecret()) !== '') {
            $key .=  rawurlencode($userSecret);
        }
        return $key;
    }

    /**
     * Method to create the signature
     */
    public function sign()
    {
        return base64_encode(hash_hmac('sha1', $this->createBaseString(), $this->createCompositeKey(), true));
    }

    /**
     * Method to check the empty token property
     *
     * @return boolean
     */
    public function getEmptyToken()
    {
        return $this->include_empty_token;
    }

    /**
     * method to set the empty token property
     *
     * @param boolean $value
     */
    public function setEmptyToken($value)
    {
        if (!is_boolean($value)) {
            throw new \InvalidArgumentException("Value must been a boolean");
        }
        $this->include_empty_token = $value;
    }
}
