<?php
namespace Snaggle\Client\Credentials;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * Contract for the credentials and/or any other type that could
 * serve as it's replacement
 */

interface CredentialInterface
{
    /**
     * getIdentifier method to return the identifying value of the credential
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * getSecret method to return the secret token for the credential
     *
     * @return string
     */
    public function getSecret();
}
