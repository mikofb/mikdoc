<p align="center">

# Mikdoc, a multi-user laravel package for files and folder management
</p>
<p align="center">
    <img src="https://github.com/mikofb/mikdoc/tree/master/src/assets/img/Capture.PNG" width="562" height="388">
</p>

## Installation

### Step 01: Download package by using composer

To get started with Mikdoc, use Composer to add the package to your project's dependencies.

```
composer require mikofb/mikdoc
```

### Step 02: Migrate

This step will create a `documents` table in your database! <br>
:warning: Ensure that there's none for now.

```
php artisan migrate
```

### Step 03: Publish assets and config file

Here we will create a `mikdoc.php` file in your config folder.

```
php artisan vendor:publish --provider="Mikofb\Mikdoc\MikdocServiceProvider"
```

### Step 04: Check this out

Finally, visit your domain url by adding `/documents` as prefix.

> note: This prefix can be change to whatever you want, just see config/mikdoc.php for more details! 

## Languages

Only two languages are provided for now:

<ul>
	<li>English (en)</li>
	<li>French (fr)</li>
</ul>
<br>

## Credentials
All the views in this package is provided by <a href="https://www.creative-tim.com/" target="_blank">Creative Tim</a> free templates. 

## License

Mikdoc is open-sourced software licensed under the MIT License (MIT). Please see [License File](LICENSE.md) for more information.

<p align="center"> <b>Made with :heart: <b> </p>
