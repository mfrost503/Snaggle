<?php
namespace Snaggle\Client\Header;

use \Snaggle\Client\Signatures\SignatureInterface;

/**
 * @author Matt Frost <mfrost.design@gmail.com
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage Client
 *
 * This will generate the Authorization header that is required to make a valid OAuth1 Request
 */
class Header
{
    /**
     * The signature that is going to bring most of the components in
     *
     * @var \Snaggle\Client\Signatures\SignatureInterface $signature
     */
    private $signature;

    /**
     * Build the authorization header
     *
     * @return string
     */
    public function createAuthorizationHeader($includePrefix = false)
    {
        $headerParams = array(
            'oauth_signature' => $this->signature->sign(),
            'oauth_nonce' => $this->signature->getNonce(),
            'oauth_signature_method' => $this->signature->getSignatureMethod(),
            'oauth_timestamp' => $this->signature->getTimestamp(),
            'oauth_consumer_key' => $this->signature->getConsumer()->getIdentifier(),
            'oauth_token' => $this->signature->getUser()->getIdentifier(),
            'oauth_version' => $this->signature->getVersion()
        );
        if (($callback = $this->signature->getCallback()) !== '') {
            $headerParams['oauth_callback'] = $callback;
        }

        if (($verifier = $this->signature->getVerifier()) !== '') {
            $headerParams['oauth_verifier'] = $verifier;
        }

        $tempArray = array();
        ksort($headerParams);

        foreach ($headerParams as $key => $value) {
            $tempArray[] = $key . '="' . rawurlencode($value) . '"';
        }

        $prefix = "Authorization: ";
        $headerString = 'OAuth ' . implode(', ', $tempArray);
        return ($includePrefix) ? $prefix . $headerString : $headerString;
    }

    /**
     * @param \Snaggle\Client\Signatures\SignatureInterface $signature
     *
     * Set the signature object
     */
    public function setSignature(SignatureInterface $signature)
    {
        $this->signature = $signature;
    }
}
