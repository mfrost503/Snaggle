<?php
namespace Snaggle\OAuth1\Client\Signatures;
/**
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
        $baseString = $this->buildBaseString($paramArray);
        return $baseString;
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

        foreach($oauthParams as $key => $value) {
            $tempArray[] = $key . '=' . rawurlencode($value);
        }
        $parsedResource = parse_url($this->resourceURL);
        $baseString = $this->httpMethod .'&';
        $baseString .= rawurlencode($parsedResource['scheme'] . '://' . $parsedResource['host'] . $parsedResource['path']);
        $baseString .= (isset($parsedResource['query'])) ? '&' . rawurlencode($parsedResource['query']) . '%26' : '&';
        $baseString .= rawurlencode(implode('&', $tempArray));
        if (!empty($this->postFields)) {
            foreach ($this->postFields as $key => $value) {
                $baseString .= '%26' . $key .rawurlencode('=') . rawurlencode($value);
            }
        }
        //return $this->httpMethod . '&' . rawurlencode($this->resourceURL) . '&' . rawurlencode(implode('&', $tempArray));
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
}

