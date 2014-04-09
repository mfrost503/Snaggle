<?php
namespace Snaggle\OAuth1\Client\Signatures;
/**
 * Class to facilitate the creation of the Authorization header that needs to
 * to be sent for the request
 */
class HmacSha1 extends Signature implements SignatureInterface
{
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
            'oauth_version' => $this->version
        );

        if ($this->callback === '') {
            unset($paramArray['oauth_callback']);
        }
       
        $tempArray = array();
        ksort($paramArray);

        foreach($paramArray as $key => $value) {
            $tempArray[] = $key . '=' . rawurlencode($value);
        }
        return $this->httpMethod . '&' . rawurlencode($this->resourceURL) . '&' . rawurlencode(implode('&', $tempArray));
    }

    /**
     * Method to generate the composite key
     */
    public function createCompositeKey()
    {
        $key = rawurlencode($this->consumerCredential->getSecret());
        if (($userSecret = $this->userCredential->getSecret()) !== '') {
            $key .= '&' . rawurlencode($userSecret);
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
}

