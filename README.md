# doublebit/okcoin
A simple Laravel 5 wrapper for OKCoin API.

**This package is not ready for use in production!**

## Installation

Install with [composer](https://getcomposer.org):

`composer require doublebit/okcoin`

Then add the provider to `config/app.php`

`DoubleBit\OKCoin\OkcoinServiceProvider::class,`

and optionally add the facade to aliases

`'OKCoin' => DoubleBit\OKCoin\Facade::class,`

Then run `php artisan vendor:publish --provider="Doublebit\Okcoin\OkcoinServiceProvider`

## Usage

`echo json_encode(\OKCoin::getTicker())`


The package has no built-in API calls, you can make a call to any endpoint from the [OKCoin API](https://www.okcoin.com/about/rest_api.do).

If the OKCoin API adds new endpoints you can make calls to those without updating the package.
 
The methods are constructed as follows: first all lowercase word is the method (get/post).
Then starting with an uppercase letter is the name of the endpoint from OKCoin API.
In the name of the endpoint remove all the underscores (_) and start each word after an underscore
with an uppercase. Example: `POST /api/v1/batch_trade` becomes `OKCoin::postBatchTrade()`

The methods support up to 4 arguments, as follows:
* If the first argument is not a string, it MUST BE an array of parameters for the query (according to the API docs)
* If the first argument is string, it's considered API_KEY and the second argument MUST BE SECRET_KEY and the array
of parameters are moved to the third argument
* Last argument is always the callback. The callback receives the following 3 arguments: `$endpoint, $params, $result`.
The $endpoint is the API endpoint, not the method name. The $params is an array of params (sent to the method).
The $result is the json received from the server or `false` in case of error.

## OkcoinException

// @todo

## Issues

Report any issues on [github](https://github.com/doublebit/okcoin/issues)

## License

See [LICENSE](https://github.com/doublebit/okcoin/blob/master/LICENSE) file