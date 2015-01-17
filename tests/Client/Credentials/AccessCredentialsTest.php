<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;
use Snaggle\Client\Credentials\AccessCredentials;

class AccessCredentialsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AccessCredentials
     */
    private $credentials;

    protected function setUp()
    {
        $this->credentials = new AccessCredentials();
    }

    protected function tearDown()
    {
        unset($this->credentials);
    }

    public function testDefaults()
    {
        $this->assertNull($this->credentials->getIdentifier());
        $this->assertNull($this->credentials->getSecret());
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
