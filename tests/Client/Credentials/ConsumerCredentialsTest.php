<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;
use Snaggle\Client\Credentials\ConsumerCredentials;

class ConsumerCredentialsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ConsumerCredentials
     */
    private $credentials;

    protected function setUp()
    {
        $this->credentials = new ConsumerCredentials();
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
