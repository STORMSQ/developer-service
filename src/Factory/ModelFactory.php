<?php
namespace STORMSQ\Developer\Factory;
use Illuminate\Support\Facades\App;

class ModelFactory{
    public static function bind(string $stringName){
  
        App::bind('Model', $stringName);
    }
}