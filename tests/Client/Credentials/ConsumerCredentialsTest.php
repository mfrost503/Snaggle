<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;
use Snaggle\Client\Credentials\ConsumerCredentials;

class ConsumerCredentialsTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorSetsValues()
    {
        $identifier = 'foo';
        $secret = 'bar';

        $credentials = new ConsumerCredentials(
            $identifier,
            $secret
        );

        $this->assertSame($identifier, $credentials->getIdentifier());
        $this->assertSame($secret, $credentials->getSecret());
    }


    public function testConstructorHasDefaultValues()
    {
        $credentials = new ConsumerCredentials();

        $this->assertSame('', $credentials->getIdentifier());
        $this->assertSame('', $credentials->getSecret());
    }
}
