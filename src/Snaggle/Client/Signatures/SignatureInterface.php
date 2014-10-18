<?php
namespace Snaggle\Client\Signatures;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @copyright Copyright (c) 2014
 * @package Snaggle
 * @subpackage Client
 * @license http://opensource.org/licenses/MIT MIT
 *
 * Contract for any types of signatures that may be added or replaced
 */
interface SignatureInterface
{
    /**
     * Method to create the signature
     */
    public function sign();
}
