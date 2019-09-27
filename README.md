# Mikdoc, a multi-user laravel package for files and folder management

Mikdoc is a package based on Laravel authentification system. Typically, that's means you have to run the command below:

```
php artisan make:auth
```

Now depending on your Lavarel's version, this may change. Check the documentation for more details.<br>
If everything looks fine, follow the steps below and install the package.

## Installation

### Step 01: Download package by using composer

To get started with Mikdoc, use composer to add the package to your project's dependencies.

```
composer require mikofb/mikdoc
```

### Step 02: Migrate

This step will create a `documents` table in your database, so ensure that there's none for now.

```
php artisan migrate
```

### Step 03: Publish assets and config file

Here you have publish the `mikdoc.php` config file and all the differents assets.

```
php artisan vendor:publish --provider="Mikofb\Mikdoc\MikdocServiceProvider"
```

### Step 04: Check this out

Finally, visit your domain url by adding `/documents` as prefix.

> note: This prefix can be change to whatever you want, just see config/mikdoc.php for more details! 

The Mikdoc package as been set for auto-discover but if you get some unknown routes errors you can fix them this way.<br>
You just have to register service provider and aliase in your `config/app.php`

```
'providers' => [
		 Mikofb\Mikdoc\MikdocServiceProvider::class,
],

/*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */
    
'aliases' => [
		'Mikdoc' => Mikofb\Mikdoc\Facades\Mikdoc::class, 
],
```

## Languages

Only two languages are provided for now:

<ul>
	<li>English (en)</li>
	<li>French (fr)</li>
</ul>
<br>

## Credentials
All the views in this package are provided by <a href="https://www.creative-tim.com/" target="_blank">Creative Tim</a> free templates. 

## License

Mikdoc is open-sourced software licensed under the MIT License (MIT). Please see [License File](LICENSE.md) for more information.

<p align="center"> <b>Made with :heart: <b> </p>
