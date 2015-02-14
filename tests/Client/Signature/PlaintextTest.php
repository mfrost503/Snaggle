<?php
namespace Snaggle\Tests\Client\Signatures;

use Snaggle\Client\Credentials\AccessCredentials;
use Snaggle\Client\Credentials\ConsumerCredentials;
use Snaggle\Client\Signatures\Plaintext;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright (c) 2014
 * @license http://opensource.org/licenses/MIT MIT
 * @package tests
 * @subpackage Snaggle
 *
 * Test to validate the creation of the Plaintext signature
 */
class PlaintextTest extends \PHPUnit_Framework_TestCase
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
     * Setup
     */
    protected function setUp()
    {
        $this->consumer = new ConsumerCredentials(
            'ABCDEFG',
            'THISISA'
        );

        $this->user = new AccessCredentials(
            '123ABC',
            'SECRETMESSAGE'
        );
    }

    /**
     * Tear down
     */
    protected function tearDown()
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
