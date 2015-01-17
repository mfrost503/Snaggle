<?php

namespace Snaggle\Tests\Client\Credentials;

use PHPUnit_Framework_TestCase;

class TemporaryCredentialsTest extends PHPUnit_Framework_TestCase
{
    public function testCanAutoloadClass()
    {
        $this->assertTrue(class_exists('Snaggle\Client\Credentials\TemporaryCredentials'));
    }
}
