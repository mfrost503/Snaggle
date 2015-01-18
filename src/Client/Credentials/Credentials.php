<?php
namespace Snaggle\Client\Credentials;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @package Snaggle
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 */
abstract class Credentials
{
    /**
     * The public API key that is assigned at the creation of the application
     *
     * @var $identifier string
     */
    protected $identifier = '';

    /**
     * The API secret that is assigned at the creation of the application
     *
     * @var $secret string
     */
    protected $secret = '';

    /**
     * Return the identifier property
     *
     * @return string the identifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Return the secret property
     *
     * @return string the secret
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Set the identifier property
     *
     * @param string $identifier
     * @deprecated Will be removed in 1.0.0 - please use constructor
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Set the secret property
     *
     * @param string $secret
     * @deprecated Will be removed in 1.0.0 - please use constructor
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }
}
