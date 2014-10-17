## Snaggle

[![Build Status](https://travis-ci.org/mfrost503/Snaggle.svg?branch=master)](https://travis-ci.org/mfrost503/Snaggle)

Snaggle is an OAuth 1 Client Library that can be used to generate signatures and
the appropriate OAuth 1 Headers. While OAuth 2.0 is suggested for building a new API, there are still plenty of popular services that use OAuth 1.0. 

### OAuth 1.0 Client Examples
OAuth 1.0 requires the use of Access and Consumer tokens, being able to create a valid signature will unlock the content of an OAuth 1.0 APi.

```php
<?php
namespace Snaggle\OAuth1\Client\Credentials;
use Snaggle\OAuth1\Client\Signatures\HmacSha1;
use Snaggle\OAuth1\Client\Signatures\Plaintext;
use Snaggle\OAuth1\Client\Header\Header;

// first we need to represent our tokens, these should be stored securely
$consumer = new ConsumerCredentials();
$consumer->setIdentifer('CONSUMER_KEY');
$consumer->setSecret('CONSUMER_SECRET');

$access = new AccessCredentials();
$access->setIdentifier('ACCESS_TOKEN');
$access->setSecret('ACCESS_SECRET');

$signature = new HmacSha1($consumer, $access)
    ->setResourceURL('https://api.example.com/v1/users')
    ->setHttpMethod('get');

$header = new Header($signature);
$header->createAuthorizationHeader();
```

There's also a plaintext signature type (which should only be used when there is no other way and over https), it implements the signature interface and uses the signature parent, so it's use is the same as HmacSha1, only the instantiation differs
```php
$signature = new Plaintext($consumer, $access);
```
This line can be used interchangeably with the signature instantiation in the previous example.

## HTTP Client

Snaggle does not come with an HTTP client included in the library, the reason
for that is there are HTTP Clients that are very well done, but everyone's needs
and access to these tools maybe different. Those clients do a great job at the
job they're meant to do, which is make HTTP requests. Snaggle's role in this
process is to provide the headers that are required to make OAuth 1 requests
work properly and handing those off to whatever client you choose to use.

There are a couple different cases when it comes to providing headers to
clients. For example, when setting a header in cURL you'll have to send the
```'Authorization: '``` prefix, but it Guzzle you'll just want the content of
the headers. Snaggle gives you the option to generate the headers with or
without the prefix. Below is an example of each using Guzzle and cURL:

### Guzzle

In Guzzle, we don't want the prefix so the
``` $header->creationAuthorizationHeader()``` has a parameter ```
$includePrefix``` that is set to false by default. So here's how you'd use it
with a client that doesn't need the header prefix.
 
```php
<?php
namespace Snaggle\OAuth1\Client\Credentials;
use Snaggle\OAuth1\Client\Signatures\HmacSha1;
use Snaggle\OAuth1\Client\Signatures\Plaintext;
use Snaggle\OAuth1\Client\Header\Header;

// first we need to represent our tokens, these should be stored securely
$consumer = new ConsumerCredentials();
$consumer->setIdentifer('CONSUMER_KEY');
$consumer->setSecret('CONSUMER_SECRET');

$access = new AccessCredentials();
$access->setIdentifier('ACCESS_TOKEN');
$access->setSecret('ACCESS_SECRET');

$signature = new HmacSha1($consumer, $access)
    ->setResourceURL('https://api.example.com/v1/users')
    ->setHttpMethod('get');

$header = new Header($signature);
$authorizationHeader = $header->createAuthorizationHeader();

$client = new Guzzle\HttpClient();
$client->get('https://api.example.com/v1/users', [
	'headers' => ['Authorization' => $authorizationHeader]
]);
```

### cURL

cURL will require the prefix when adding the header to the request. In order to
do this, we'll just need to pass the parameter ```true``` to the ```
$header->createAuthorizationHeader();```

```php
<?php
namespace Snaggle\OAuth1\Client\Credentials;
use Snaggle\OAuth1\Client\Signatures\HmacSha1;
use Snaggle\OAuth1\Client\Signatures\Plaintext;
use Snaggle\OAuth1\Client\Header\Header;

// first we need to represent our tokens, these should be stored securely
$consumer = new ConsumerCredentials();
$consumer->setIdentifer('CONSUMER_KEY');
$consumer->setSecret('CONSUMER_SECRET');

$access = new AccessCredentials();
$access->setIdentifier('ACCESS_TOKEN');
$access->setSecret('ACCESS_SECRET');

$signature = new HmacSha1($consumer, $access)
    ->setResourceURL('https://api.example.com/v1/users')
    ->setHttpMethod('get');

$header = new Header($signature);
$authorizationHeader = $header->createAuthorizationHeader(true);

$ch = curl_init('https://api.example.com/v1/users');
curl_setopt($ch, CURLOPT_HTTPHEADER, [$authorizationHeader]);
```

By using this approach, we can decouple the generation of the OAuth 1 Headers
from the HTTP Client that will eventually be used to send the requests.

## Notes

OAuth 1.0 can be a little bit difficult to wrap your head around when you first
look at it, the aim of this library to encapsulate a lot of that confusion and
provide a simple interface for making OAuth 1.0 calls. The OAuth 1.0 RFC was the
standard that was kept in mind when building this library, though I feel that I
should point out, not every service that calls itself an OAuth 1.0 service
follows this standard.

This library works best with APIs that make an attempt to closely adhere to the
Signature standards in the OAuth 1.0 specification, which unfortunately means
that this may not work with every API that calls itself an OAuth 1.0. That
doesn't mean that we've given up on those completely, it just means that as we
become aware of them we'll have to analyze whether or not it's in the best
interest of this project to accommodate various divergences from the OAuth 1.0
standard. Pull Requests are always welcome.
