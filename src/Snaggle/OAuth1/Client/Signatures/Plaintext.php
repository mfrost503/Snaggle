<?php
namespace Snaggle\OAuth1\Client\Signatures;
/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014
 * @package Snaggle
 * @subpackage OAuth1
 *
 * Plaintext signature method for OAuth 1 clients, important to note
 * this should only be used when there is no other way to authenticate
 * and only in a secure setting with SSL (https for those scoring at home)
 */
class Plaintext extends Signature implements SignatureInterface
{
    /**
     * Value for the signature method
     *
     * @var string $signature_method
     */
    protected $signatureMethod = 'PLAINTEXT';

    /**
     * Method to sign an OAuth Plaintext request
     */
    public function sign()
    {
        return rawurlencode($this->getConsumer()->getSecret()) . '&'. rawurlencode($this->getUser()->getSecret());
    }

}
