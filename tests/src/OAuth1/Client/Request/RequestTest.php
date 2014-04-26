<?php
namespace Snaggle\OAuth1\Client\Request;

/**
 * @package tests
 * @subpackage OAuth1
 * @license http://opensource.org/licenses/MIT MIT
 * @author Matt Frost <mfrost.design@gmail.com>
 */

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Setup - runs prior to each test
     */
    public function setUp()
    {
        $this->request = new Request();
    }

    /**
     * TearDown runs prior to each test
     */
    public function tearDown()
    {
        unset($this->request);
    }

    /**
     * Test to ensure that a Guzzle HTTP Client is returned when get client is called
     *
     * @test
     */
    public function verifyGuzzleClientIsReturned()
    {
        $client = $this->request->getHttpClient();
        $this->assertInstanceOf('\GuzzleHttp\Client', $client);
    }
}

