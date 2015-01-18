<?php
namespace Snaggle\Client\Credentials;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * A class to represent the credentials of the consuming service provider,
 * these are the credentials that are assigned when an API application
 * is created
 */
class ConsumerCredentials extends Credentials implements CredentialInterface
{
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
