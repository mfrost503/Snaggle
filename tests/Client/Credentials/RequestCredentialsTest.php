<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;
use Snaggle\Client\Credentials\RequestCredentials;

class RequestCredentialsTest extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiateClass()
    {
        new RequestCredentials();
    }
}
