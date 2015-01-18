<?php
namespace Snaggle\Client\Credentials;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * This will store the temporary credentials that are sent back in the first
 * step of the token exchange. These are short-lived credentials and will
 * expire if they aren't exchanged for Access Credentials
 */
class RequestCredentials extends Credentials implements CredentialInterface
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
