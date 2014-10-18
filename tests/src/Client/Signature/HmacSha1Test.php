<?php
namespace Snaggle\Client\Signatures;
use Snaggle\Client\Credentials\ConsumerCredentials;
use Snaggle\Client\Credentials\AccessCredentials;

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
     * Setup
     */
    public function setUp()
    {
        $this->consumer = new ConsumerCredentials();
        $this->consumer->setIdentifier('ABCDEFG');
        $this->consumer->setSecret('SHHHHHHH');

        $this->user = new AccessCredentials();
        $this->user->setIdentifier('1234ABCD');
        $this->user->setSecret('KEEPOUT');
        $this->signature = new HmacSha1($this->consumer, $this->user);
    }

    /**
     * Tear Down
     */
    public function tearDown()
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
}

