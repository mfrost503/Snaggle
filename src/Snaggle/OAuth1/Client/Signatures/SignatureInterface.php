<?php
namespace Snaggle\OAuth1\Client\Signatures;
/**
 * Interface for the OAuth Signature
 */
interface SignatureInterface
{
    /**
     * Method to create the signature
     */
    public function sign();
}
