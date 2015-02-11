<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;
use Snaggle\Client\Credentials\TemporaryCredentials;

class TemporaryCredentialsTest extends PHPUnit_Framework_TestCase
{
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

    public function testConstructorHasDefaultValues()
    {
        $credentials = new TemporaryCredentials();

        $this->assertSame('', $credentials->getIdentifier());
        $this->assertSame('', $credentials->getVerifier());
    }
}
