<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;
use Snaggle\Client\Credentials\RequestCredentials;

class RequestCredentialsTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorSetsValues()
    {
        $identifier = 'foo';
        $secret = 'bar';

        $credentials = new RequestCredentials(
            $identifier,
            $secret
        );

        $this->assertSame($identifier, $credentials->getIdentifier());
        $this->assertSame($secret, $credentials->getSecret());
    }

    public function testConstructorHasDefaultValues()
    {
        $credentials = new RequestCredentials();

        $this->assertSame('', $credentials->getIdentifier());
        $this->assertSame('', $credentials->getSecret());
    }
}
