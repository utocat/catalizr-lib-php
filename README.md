![PHP Library for Catalizr API](./img/catalizr.png)
CATALIZR LIBRARY
=================================================
 This is a PHP client library to work with [Catalizr API](https://api.catalizr.io/doc/).


Requirements
-------------------------------------------------
To use this Library, you will need (as a minimum):
* PHP v5.6
* cURL (included and enabled in a standard PHP distribution)
* OpenSSL (included and enabled in a standard PHP distribution)
* You do not have to use [Composer](https://getcomposer.org/), but you are strongly advised to (particularly for handling the dependency on the PSR Log library)

Installation with Composer
-------------------------------------------------
You can use Catalizr library as a dependency in your project with [Composer](https://getcomposer.org/) (which is the preferred technique). Follow [these installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have Composer installed.
A composer.json file is available in the repository and it has been referenced from [Packagist](https://packagist.org/packages/utocat/catalizr). 

The installation with Composer is easy and reliable: 

Step 1 - Add the Catalizr Library as a dependency by executing the following command:

    you@yourhost:/path/to/your-project$ composer require utocat/catalizr
    
Step 2 - Update your dependencies with Composer

    you@yourhost:/path/to/your-project$ composer update
    
Step 3 - Finally, be sure to include the autoloader in your project

    require_once '/path/to/your-project/vendor/autoload.php';

The Library has been added into your dependencies and is ready to be used.


Installation without Composer
-------------------------------------------------
The project attempts to comply with PSR-4 specification for autoloading classes from file paths. As a namespace prefix is `Catalizr\` with base directory `/path/to/your-project/`.

If you're not using PSR-4 or Composer, the installation is as easy as downloading the library and storing it under any location that will be available for including in your project (**don't forget to include the required library dependencies though**):
```php
    require_once '/path/to/your-project/Catalizr/Autoloader.php';
```

License
-------------------------------------------------
Catalizr Library is distributed under MIT license, see the [LICENSE file](https://github.com/utocat/lib-catalizr-php/blob/master/LICENSE).


Unit Tests
-------------------------------------------------

Tests are based on phpunit. To install it with other quality tools, you can install
local npm project in a clone a project

    git https://github.com/utocat/lib-catalizr-php.git
    cd lib-catalizr-php
    php composer.phar install

Edit **phpunit.xml** file with your credentials to pass functionals tests. Then,
you can run directly unit and functionals tests with [phing](http://www.phing.info/).

    vendor/bin/phing test

To skip functionals and run unit tests only, you can use the `only.units` option :

    vendor/bin/phing test -Donly.units=true


Contacts
-------------------------------------------------
Report bugs or suggest features using
[issue tracker on GitHub](https://github.com/utocat/lib-catalizr-php/issues).


Account creation
-------------------------------------------------
You can ask an [account](https://www.utocat.com/fr/contact) (note that validation of your sandbox/production account can take a few days, so think about doing it in advance of when you actually want to go live).


Configuration
-------------------------------------------------
Using the credential info from your subscription, you should then set `$api->config->publicKey` to your Catalizr Public Key and `$api->config->privateKey` to your Catalizr Private Key.

`$api->config->url` is set to preproduction environment.
To enable production environment, set it to `https://api.catalizr.io`.

```php
require_once '/path/to/your-project/vendor/autoload.php';
$api = new Catalizr\Api();

// configuration
$api->config->publicKey = 'your-public-key';
$api->config->privateKey = 'your-private-key';
$api->config->url = 'https://preprod.api.catalizr.io';

// call some API methods...
try {
    $investorIds = $api->investors->getAllId();
} catch(Exception $ex) {
    // handle/log the response exception with code $ex->getCode(), message $ex->getMessage()
}
```


Sample usage
-------------------------------------------------
```php
require_once '/path/to/your-project/vendor/autoload.php';
$api = new Catalizr\Api();

// configuration
$api->config->publicKey = 'your-public-key';
$api->config->privateKey = 'your-private-key';
$api->config->url = 'https://preprod.api.catalizr.io';

// Create an investor with personal ID
try {
    $investor = new \Catalizr\Entity\Investors();
	$investor->name = "Doe";
	$investor->surname = "John";
	$investor->birth_date = "1990/08/03";
	$investor->birth_city = "Hirson";
	$investor->address = "165 Avenue de Bretagne";
	$investor->zip = "59000";
	$investor->city="Lille";
	$investor->country = "Nord";
	$investor->title = "M.";
	$investor->iid = "MY_PERSONAL_ID";
	$api->investors->create($investor);
} catch(Exception $ex) {
    // handle/log the response exception with code $e->GetCode(), message $ex->getMessage()
}

// Get an investor with a personal ID
try {
    $investorGet = $api->investors->getByExternalId($investor->iid);
} catch(Exception $ex) {
    // handle/log the response exception with code $e->getCode(), message $ex->getMessage()
}

```


Sample usage with Composer in a Symfony project
-------------------------------------------------
You can integrate Catalizr features in a Service in your Symfony project. 

CatalizrService.php : 
```php

<?php

namespace Path\To\Service;

use Catalizr;


class CatalizrService
{

    private $catalizrApi;

    public function __construct()
    {
        $this->catalizrApi = new Catalizr\Api();
        $this->catalizrApi->config->publicKey = 'your-public-key';
        $this->catalizrApi->config->privateKey = 'your-private-key';
        $this->catalizrApi->config->url = 'https://api.preprod.catalizr.io';    
    }
    
    /**
     * Create a new
     * @return Investor $investor
     */
    public function createInvestor()
    {  
        $investor = new \Catalizr\Entity\Investors();
		$investor->name = "Doe";
		$investor->surname = "John";
		$investor->birth_date = "1990/08/03";
		$investor->birth_city = "Hirson";
		$investor->address = "165 Avenue de Bretagne";
		$investor->zip = "59000";
		$investor->city="Lille";
		$investor->country = "Nord";
		$investor->title = "M.";
		$investor->iid = "MY_PERSONAL_ID";

        //Send the request
        $investor = $this->catalizrApi->investors->create($investor);

        return $investor;
    }
}
```
