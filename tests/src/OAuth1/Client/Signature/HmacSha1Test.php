<?php
namespace Snaggle\OAuth1\Client\Signatures;
use Snaggle\OAuth1\Client\Credentials as Credentials;

class HmacSha1Test extends \PHPUnit_Framework_TestCase
{
    /**
     * Setup
     */
    public function setUp()
    {
    }

    /**
     * Tear Down
     */
    public function tearDown()
    {
    }

    /**
     * @test
     * Test to ensure the nonce is being set correctly
     */
    public function generateNonce()
    {
        $consumer = new Credentials\ConsumerCredentials();
        $consumer->setIdentifier('ABCDEFG');
        $consumer->setSecret('SHHHHHHH');

        $user = new Credentials\AccessCredentials();
        $user->setIdentifier('1234ABCD');
        $user->setSecret('KEEPOUT');

        $signature = new HmacSha1($consumer, $user);
        $nonce = $signature->getNonce();
        $this->assertNotEmpty($nonce);
    }
}
