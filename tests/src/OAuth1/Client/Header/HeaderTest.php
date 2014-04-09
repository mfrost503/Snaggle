<?php
namespace Snaggle\OAuth1\Client\Header;
use Snaggle\OAuth1\Client\Signatures as Signature;
use Snaggle\OAuth1\Client\Credentials as Credential;
/**
 * Tests for the header functionality
 */
Class HeaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up - runs prior to each test
     */
    public function setUp()
    {
        $this->consumer = new Credential\ConsumerCredentials();
        $this->consumer->setIdentifier('CONSUMER');
        $this->consumer->setSecret('CONSUMER_SECRET');

        $this->user = new Credential\AccessCredentials();
        $this->user->setIdentifier('ACCESS_TOKEN');
        $this->user->setSecret('ACCESS_SECRET');

        $this->signature = new Signature\HmacSha1($this->consumer, $this->user);
    }

    /**
     * Tear down - runs after each test
     */
    public function tearDown()
    {
        unset($this->consumer);
        unset($this->user);
        unset($this->signature);
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
        $header = new Header($this->signature);
        $headerString = $header->createAuthorizationHeader(true);
        $this->assertContains('oauth_token="ACCESS_TOKEN"', $headerString, 'Access token not set');
        $this->assertContains('Authorization:', $headerString, 'Authorization prefix missing');
        $this->assertContains('oauth_version="1.0"', $headerString, 'OAuth version missing');
        $this->assertContains('oauth_signature_method="HMAC-SHA1"', $headerString, 'Signature method missing');
    }
}
