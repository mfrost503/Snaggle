<?php
namespace Snaggle\Client\Header;
use Snaggle\Client\Signatures\HmacSha1;
use Snaggle\Client\Signatures\Plaintext;
use Snaggle\Client\Credentials\ConsumerCredentials;
use Snaggle\Client\Credentials\AccessCredentials;


/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package tests
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * Tests for the header functionality
 */
Class HeaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConsumerCredentials
     */
    private $consumer;

    /**
     * @var AccessCredentials
     */
    private $user;

    /**
     * @var HmacSha1
     */
    private $signature;

    /**
     * @var Plaintext
     */
    private $plaintext;

    /**
     * Set up - runs prior to each test
     */
    public function setUp()
    {
        $this->consumer = new ConsumerCredentials();
        $this->consumer->setIdentifier('CONSUMER');
        $this->consumer->setSecret('CONSUMER_SECRET');

        $this->user = new AccessCredentials();
        $this->user->setIdentifier('ACCESS_TOKEN');
        $this->user->setSecret('ACCESS_SECRET');

        $this->signature = new HmacSha1($this->consumer, $this->user);
        $this->plaintext = new Plaintext($this->consumer, $this->user);
    }

    /**
     * Tear down - runs after each test
     */
    public function tearDown()
    {
        unset($this->consumer);
        unset($this->user);
        unset($this->signature);
        unset($this->plaintext);
    }

    /**
     * @test
     *
     * Test to ensure header is created with identifiable information
     */
    public function verifyHeaderHasIdentifiableInformation()
    {
        $this->signature->setHttpMethod('get');
        $this->signature->setResourceURL('https://example.com/api');
        $this->signature->setCallback('https://my.site/callback');
        $header = new Header();
        $header->setSignature($this->signature);
        $headerString = $header->createAuthorizationHeader(true);
        $this->assertContains('oauth_token="ACCESS_TOKEN"', $headerString, 'Access token not set');
        $this->assertContains('Authorization:', $headerString, 'Authorization prefix missing');
        $this->assertContains('oauth_version="1.0"', $headerString, 'OAuth version missing');
        $this->assertContains('oauth_signature_method="HMAC-SHA1"', $headerString, 'Signature method missing');
    }

    /**
     * @test
     *
     * Test to ensure plaintext signature is added to the header
     */
    public function verifyPlaintextSignatureIsAdded()
    {
        $expectedSignature = rawurlencode($this->consumer->getSecret());
        $expectedSignature .= '%26';
        $expectedSignature .= rawurlencode($this->user->getSecret());
        $this->plaintext->setHttpMethod('get');
        $this->plaintext->setResourceURL('https://example.com/api');
        $this->plaintext->setNonce('123456');
        $header = new Header();
        $header->setSignature($this->plaintext);
        $headerString = $header->createAuthorizationHeader();
        $this->assertContains($expectedSignature, $headerString, 'Signature was not found');
        $this->assertContains('OAuth', $headerString, 'OAuth Authorization type not found');
        $this->assertContains('oauth_nonce="123456"', $headerString, 'Nonce not found');
    }
}
