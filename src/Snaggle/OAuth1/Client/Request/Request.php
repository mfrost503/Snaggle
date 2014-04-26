<?php
namespace Snaggle\OAuth1\Client\Request;
use GuzzleHttp as Guzzle;
/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @license http://opensource.org/licenses/MIT
 * @package Snaggle
 * @subpackage OAuth1
 *
 * Class that will use an HTTP client to make requests for token exchanges and api consumption
 */
class Request
{
    /**
     * Guzzle Client used for making the requests
     *
     * @var \GuzzleHttp\Client $httpClient
     */
    protected $httpClient;

    /**
     * Config for client, default value is an empty array can be overridden 
     * for different vendors
     *
     * @var string $host
     */
    protected $configuration = []; 

    /**
     * Method to get a Guzzle HTTP Client to make the calls.
     *
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        return new Guzzle\Client($this->configuration);
    }
}
