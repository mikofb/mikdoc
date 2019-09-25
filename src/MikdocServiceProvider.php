<?php

namespace Mikofb\Mikdoc;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class MikdocServiceProvider extends ServiceProvider
{
	public function boot()
	{
        //\Mikdoc::createFile('File 3', null, 1, 1);
		$this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'mikdoc');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang/', 'mikdoc');
		Route::group($this->routesConfig(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        });
		
		$this->publishes(
			[
	        	__DIR__.'/assets' => public_path('vendor/mikdoc'),
	        	__DIR__.'/config/mikdoc.php'=> config_path('mikdoc.php'),
	    	]
	    );
	}

	/**
     * @return array
     */
    protected function routesConfig()
    {
        return [
            'prefix'     => '/'.config('mikdoc.routes.prefix'),
            'namespace'  => 'Mikofb\Mikdoc\Http\Controllers',
            'middleware' => ['web', 'auth'],
        ];
    }

	public function register()
	{
		$this->registerConfigs();

		\App::bind('mikdoc', function()
        {
            return new Models\Mikdoc;
        });
	}

	/**
     * Register the package configs.
     */
    protected function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__.'/config/mikdoc.php', 'mikdoc');
    }
}