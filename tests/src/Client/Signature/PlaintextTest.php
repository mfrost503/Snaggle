<?php
namespace Snaggle\Client\Signatures;
use Snaggle\Client\Credentials\AccessCredentials;
use Snaggle\Client\Credentials\ConsumerCredentials;
/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright (c) 2014
 * @license http://opensource.org/licenses/MIT MIT
 * @package Tests
 * @subpackage Snaggle
 *
 * Test to validate the creation of the Plaintext signature
 */
class PlaintextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Setup
     */
    public function setUp()
    {
        $this->consumer = new ConsumerCredentials();
        $this->consumer->setIdentifier('ABCDEFG');
        $this->consumer->setSecret('THISISA');

        $this->user = new AccessCredentials();
        $this->user->setIdentifier('123ABC');
        $this->user->setSecret('SECRETMESSAGE');
    }

    /**
     * Tear down
     */
    public function tearDown()
    {
        unset($this->consumer);
        unset($this->user);
    }

    /**
     * @test
     *
     * Test to ensure that the Plaintext signature is created correctly
     */
    public function ensurePlaintextSignatureIsCreatedCorrectly()
    {
        $expectedSignature = rawurlencode($this->consumer->getSecret());
        $expectedSignature .= '&';
        $expectedSignature .= rawurlencode($this->user->getSecret());

        $plaintextSignature = new Plaintext($this->consumer, $this->user);
        $signature = $plaintextSignature->sign();

        $this->assertEquals($expectedSignature, $signature);
    }
}
