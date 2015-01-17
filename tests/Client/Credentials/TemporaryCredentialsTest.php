<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;
use Snaggle\Client\Credentials\TemporaryCredentials;

class TemporaryCredentialsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var TemporaryCredentials
     */
    private $credentials;

    protected function setUp()
    {
        $this->credentials = new TemporaryCredentials();
    }

    public function testConstructorSetsValues()
    {
        $identifier = 'foo';
        $secret = 'bar';

        $credentials = new TemporaryCredentials(
            $identifier,
            $secret
        );

        $this->assertSame($identifier, $credentials->getIdentifier());
        $this->assertSame($secret, $credentials->getVerifier());
    }

    protected function tearDown()
    {
        unset($this->credentials);
    }

    public function testDefaults()
    {
        $this->assertSame('', $this->credentials->getIdentifier());
    }

    public function testCanSetAndGetIdentifier()
    {
        $identifier = 'foo';

        $this->credentials->setIdentifier($identifier);

        $this->assertSame($identifier, $this->credentials->getIdentifier());
    }

    public function testCanSetAndGetVerifier()
    {
        $verifier = 'bar';

        $this->credentials->setVerifier($verifier);

        $this->assertSame($verifier, $this->credentials->getVerifier());
    }

    public function testCanAutoloadClass()
    {
        $this->assertTrue(class_exists('Snaggle\Client\Credentials\TemporaryCredentials'));
    }
}
