## 1.0.0 (2015-02-14)

Features:

    * Removed mutator methods in the Credential classes, to allow for constructor injection only.
    * Added tests

## 0.3.0 (2015-01-18)

Bugfixes:

    * Fixed an issue with the autoloading (localheinz)
    * Fixed namespacing issues (localheinz)
    * Deprecated mutator methods for CredentialInterface classes
    * Fixes for the POST fields in the base string

Features: 

    * Identifier and Secret values can be passed via constructor in Credential classes
    * PSR-2 enforced
    * Scrutinizer, Travis, PHPCS 

## 0.2.0 (2014-10-18)

Bugfixes: 

    * Changing the header interface so a signature can be preconfigured

## 0.1.1 (2014-10-18)

Bugfixes:

    * Documentation fixes around Token Retrieval
    * Some Credential naming clarifications
    * Travis fixes
    * Removing Guzzle from composer.json

Features:

    * Packagist

## 0.1.0 - Initial Release (2014-10-17)

Features:

    * HMAC-SHA1 Signature support
    * Plaintext Signature support
    * OAuth Header w/signatures can be easily generated for Guzzle, Curl, etc.
    * Credential classes to handle the separation of Access/Client/Temporary credentials

