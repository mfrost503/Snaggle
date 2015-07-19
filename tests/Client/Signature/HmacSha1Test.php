<?php
namespace Snaggle\Tests\Client\Signatures;

use Snaggle\Client\Credentials\ConsumerCredentials;
use Snaggle\Client\Credentials\AccessCredentials;
use Snaggle\Client\Signatures\HmacSha1;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package tests
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * Tests for the HMAC-SHA1 signature
 */
class HmacSha1Test extends \PHPUnit_Framework_TestCase
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
     * Setup
     */
    protected function setUp()
    {
        $this->consumer = new ConsumerCredentials(
            'ABCDEFG',
            'SHHHHHHH'
        );

        $this->user = new AccessCredentials(
            '1234ABCD',
            'KEEPOUT'
        );

        $this->signature = new HmacSha1($this->consumer, $this->user);
    }

    /**
     * Tear Down
     */
    protected function tearDown()
    {
        unset($this->user);
        unset($this->consumer);
        unset($this->signature);
    }

    /**
     * @test
     * Test to ensure the nonce is being set correctly
     */
    public function generateNonce()
    {
        $nonce = $this->signature->getNonce();
        $this->assertNotEmpty($nonce);
    }

    /**
     * @test
     *
     * Test to ensure that method is being set correctly when lowercase
     */
    public function checkHttpMethod()
    {
        $verb = 'get';
        $this->signature->setHttpMethod($verb);
        $this->assertEquals(strtoupper($verb), $this->signature->getHttpMethod());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     *
     * Test to ensure that an invalid argument exception is thrown for mismatched method
     */
    public function ensureExceptionIsThrownForUnknownMethod()
    {
        $verb = 'dostuff';
        $this->signature->setHttpMethod($verb);
    }

    /**
     * @test
     *
     * Ensure that a proper timestamp is created, offsetting the time by 100 seconds
     */
    public function createTimestamp()
    {
        $time = time();
        $time = $time - 100;
        $this->signature->setTimestamp();
        $timestamp = $this->signature->getTimestamp();
        $this->assertGreaterThan($time, $timestamp);
    }

    /**
     * @test
     *
     * Set timestamp with provided value
     */
    public function timestampWithProvidedValue()
    {
        $this->signature->setTimestamp(12345);
        $this->assertEquals(12345, $this->signature->getTimestamp());
    }

    /**
     * @test
     *
     * Ensure different timestamps are set, offsetting the time by 10 seconds
     */
    public function differentTimestamps()
    {
        $this->signature->setTimestamp();
        $time1 = $this->signature->getTimestamp();
        $this->assertGreaterThan(0, $time1, 'Timestamp 1 is not greater than 0');
        $this->signature->setTimestamp($time1+10);
        $time2 = $this->signature->getTimestamp();

        $this->assertGreaterThan($time1, $time2);
    }

    /**
     * @test
     *
     * Test to ensure version is returned correctly
     */
    public function versionIsReturned()
    {
        $expectedVersion = "1.0";
        $this->assertEquals($expectedVersion, $this->signature->getVersion());
    }

    /**
     * @test
     *
     * Test to ensure signature method is returned correctly
     */
    public function signatureMethodIsReturned()
    {
        $expectedSignatureMethod = 'HMAC-SHA1';
        $this->assertEquals($expectedSignatureMethod, $this->signature->getSignatureMethod());
    }

    /**
     * @test
     *
     * Ensure signature is not empty
     */
    public function ensureSignatureIsNotEmpty()
    {
        $this->signature->setHttpMethod('get');
        $this->signature->setResourceURL('http://example.com/api/user');
        $this->assertNotEmpty($this->signature->sign(), 'The signature was empty');
    }

    /**
     * @test
     *
     * Ensure Post Fields are added to the base string correctly
     */
    public function ensurePostFieldsAreAddedToBaseString()
    {
        $this->signature->setHttpMethod('post');
        $this->signature->setResourceURL('http://example.com/api/user');
        $this->signature->setPostFields(['status' => rawurlencode('This is a test')]);
        $expectedString = '%26status%3DThis%2520is%2520a%2520test';
        $baseString = $this->signature->createBaseString();
        $this->assertTrue(strpos($baseString, $expectedString) > -1, 'Expected String was not found in base string');
    }

    /**
     * @test
     *
     * Ensure the base string has the required elements
     */
    public function ensureBaseStringFieldsArePresent()
    {
        $this->signature->setHttpMethod('post');
        $this->signature->setResourceURL('http://example.com/api/user');
        $this->signature->setTimestamp(104020507);
        $this->signature->setNonce('NONCEBRO');
        $baseString = rawurldecode($this->signature->createBaseString());
        $array = [];
        parse_str($baseString, $array);
        $this->assertEquals($array['oauth_timestamp'], 104020507);
        $this->assertEquals($array['oauth_nonce'], 'NONCEBRO');
        $this->assertEquals($array['oauth_version'], 1.0);
        $this->assertEquals($array['oauth_token'], '1234ABCD');
    }

    /**
     * @test
     *
     * Ensure empty callback and verifier don't get put into the base string
     */
    public function ensureEmptyVerifierAndCallbackAreRemoved()
    {
        $this->signature->setHttpMethod('post');
        $this->signature->setResourceUrl('https://example.com/api/user');
        $baseString = rawurldecode($this->signature->createBaseString());
        $array = [];
        parse_str($baseString, $array);
        // might be an assertion to check for missing array key...
        $this->assertFalse(isset($array['oauth_verifier']));
        $this->assertFalse(isset($array['oauth_callback']));
    }

    /**
     * @test
     *
     * Test to ensure getEmptyToken returns correctly
     */
    public function getEmptyTokenReturnsCorrectly()
    {
        $this->signature->setEmptyToken(false);
        $this->assertFalse($this->signature->getEmptyToken());
    }

    /**
     * @test
     *
     * Ensure set empty token with non boolean value throws exception
     * @expectedException \InvalidArgumentException
     */
    public function setEmptyTokenWithBadParamThrowsException()
    {
        $this->signature->setEmptyToken('not a boolean');
    }

    /**
     * @test
     *
     * Ensure a resource can be set retrieved
     */
    public function ensureResourceURLCanBeRetrieved()
    {
        $resource = 'http://example.com';
        $this->signature->setResourceURL($resource);
        $this->assertEquals($resource, $this->signature->getResourceURL());
    }

    /**
     * @test
     *
     * Ensure Post Fields can be retrieved
     */
    public function ensurePostFieldsCanBeRetrieved()
    {
        $postFields = ['name' => 'Matt Frost'];
        $this->signature->setPostFields($postFields);
        $this->assertEquals($postFields, $this->signature->getPostFields());
    }

    /**
     * @test
     *
     * Ensure verifier can be set
     */
    public function ensureVerifierCanBeSet()
    {
        $verifier = '12345abc';
        $signature = $this->signature->setVerifier($verifier);
        $this->assertEquals($verifier, $this->signature->getVerifier());
        $this->assertSame($signature, $this->signature);
    }
}
