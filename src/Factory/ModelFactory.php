<?php
namespace STORMSQ\DeveloperService\Factory;
use Illuminate\Support\Facades\App;

class ModelFactory{
    public static function bind(string $stringName){
  
        App::bind('Model', $stringName);
    }
}