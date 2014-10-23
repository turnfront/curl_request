<?php namespace Turnfront\CurlRequest;

use Illuminate\Support\ServiceProvider;
use Turnfront\CurlRequest\Engine\CurlRequest;

class CurlRequestServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
    \App::bind("Turnfront\\CurlRequest\\Contracts\\CurlRequestInterface", function ($app){
      return new CurlRequest();
    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}