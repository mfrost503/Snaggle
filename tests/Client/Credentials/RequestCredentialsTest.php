<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;
use Snaggle\Client\Credentials\RequestCredentials;

class RequestCredentialsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var RequestCredentials
     */
    private $credentials;

    protected function setUp()
    {
        $this->credentials = new RequestCredentials();
    }

    protected function tearDown()
    {
        unset($this->credentials);
    }

    public function testDefaults()
    {
        $this->assertSame('', $this->credentials->getIdentifier());
        $this->assertSame('', $this->credentials->getSecret());
    }

    public function testCanSetAndGetIdentifier()
    {
        $identifier = 'foo';

        $this->credentials->setIdentifier($identifier);

        $this->assertSame($identifier, $this->credentials->getIdentifier());
    }

    public function testCanSetAndGetSecret()
    {
        $secret = 'bar';

        $this->credentials->setSecret($secret);

        $this->assertSame($secret, $this->credentials->getSecret());
    }
}
