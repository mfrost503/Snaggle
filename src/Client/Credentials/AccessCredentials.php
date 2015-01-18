<?php
namespace Snaggle\Client\Credentials;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * A class to represent the credentials of the resource owner,
 * these are the credentials that are assigned when a successful
 * token retrieval has been made
 */
class AccessCredentials extends Credentials implements CredentialInterface
{
    /**
     * Property for the identifying token
     */
    protected $identifier = '';

    /**
     * Property for the secret
     */
    protected $secret = '';

    /**
     * @param string $identifier
     * @param string $secret
     */
    public function __construct($identifier = '', $secret = '')
    {
        $this->identifier = $identifier;
        $this->secret = $secret;
    }
}
