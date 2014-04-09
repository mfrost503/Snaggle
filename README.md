## Snaggle

[![Build Status](https://travis-ci.org/mfrost503/Snaggle.svg?branch=master)](https://travis-ci.org/mfrost503/Snaggle)

Snaggle is an OAuth Library that you can use to help deal with all things OAuth. While OAuth 2.0 is suggested for building a new API, there are still plenty of popular services that use OAuth 1.0. The first release of this library is the OAuth 1.0 Client. Building the Authorization headers for an OAuth 1.0 request doesn't have to be difficult.

### OAuth 1.0 Client Examples
OAuth 1.0 requires the use of Access and Consumer tokens, being able to create a valid signature will unlock the content of an OAuth 1.0 APi.

```php
<?php
namespace Snaggle\OAuth1\Client\Credentials;
use Snaggle\OAuth1\Client\Signatures as Signature;
use Snaggle\OAuth1\Client\Header as Header;

// first we need to represent our tokens, these should be stored securely
$consumer = new ConsumerCredentials();
$consumer->setIdentifer('CONSUMER_KEY');
$consumer->setSecret('CONSUMER_SECRET');

$access = new AccessCredentials();
$access->setIdentifier('ACCESS_TOKEN');
$access->setSecret('ACCESS_SECRET');

$signature = new Signature\HmacSha1($consumer, $access);
$signature->setResourceURL('https://api.example.com/v1/users');
$signature->setHttpMethod('get');

$header = new Header\Header($signature);
$header->createAuthorizationHeader();
```

At this point, the headers can be place in a CURL call or set in Guzzle, there will be examples of this to follow.

Also coming soon, will be a Request class that is going to wrap Guzzle, and will natively handle the token exchange.
