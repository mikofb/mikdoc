<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Routes prefix
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of the Mikofb/Mikdoc basic route.
    | You can change this prefix to what ever you want, the package will still 
    | work fine.
    |
    */

    'routes'        => [
        'prefix'   => 'documents'
    ],

	/*
    |--------------------------------------------------------------------------
    | Disk
    |--------------------------------------------------------------------------
    |
    | This option configure the default disk for uploaded files.
    | You can change this value by providing another filesystem "disk".
    |
    */ 
    // TODO: Please see config/filesystems.php for more details.

	'disk' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | This option configure the pagination display.
    |
    */

    'paginate' => 8,

    /*
    |--------------------------------------------------------------------------
    | SEO
    |--------------------------------------------------------------------------
    |
    | These options configure the SEO settings of your Mikofb/Mikdoc version. 
    | You can set the author, the description and the keywords.
    |
    |
    */

	'seo' 				=> [
		'author' 		=> 'Mikfob',
		'description'	=> 'A multi-user package for files and folder management.',
		'keywords' 		=> 'Laravel Package Explorer Folder File Management',
	],

	/*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | These options configure the additional appearance and behaviors of your
    | Mikofb/Mikdoc version.
    | You can change the main color of the header, sidebar
    |
    |
    */
    'settings'       	=> [
    	'appearance' 	=> [
            'avatar'    => 'vendor/mikdoc/img/default.jpg',
            'favicon'   => 'vendor/mikdoc/img/favicon.png',
            'logo'      => 'vendor/mikdoc/img/mikdoc.png',
    	]
    ]	
];