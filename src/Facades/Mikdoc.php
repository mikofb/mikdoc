<?php

namespace Mikofb\Mikdoc\Facades;

use Illuminate\Support\Facades\Facade;

class Mikdoc extends Facade
{
    protected static function getFacadeAccessor() 
    { 
    	return 'mikdoc';
    }

}