<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;
use Snaggle\Client\Credentials\AccessCredentials;

class AccessCredentialsTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorSetsValues()
    {
        $identifier = 'foo';
        $secret = 'bar';

        $credentials = new AccessCredentials(
            $identifier,
            $secret
        );

        $this->assertSame($identifier, $credentials->getIdentifier());
        $this->assertSame($secret, $credentials->getSecret());
    }

    public function testConstructorHasDefaultValues()
    {
        $credentials = new AccessCredentials();

        $this->assertSame('', $credentials->getIdentifier());
        $this->assertSame('', $credentials->getSecret());
    }
}
