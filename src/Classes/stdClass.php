<?php
namespace STORMSQ\DeveloperService\Classes;
use Exception;
class stdClass {

    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                if(is_numeric($property)):
                    $this->{$argument} = null;
                else:
                    $this->{$property} = $argument;
                endif;
            }
        }
    }
    
    public function __call($method, $arguments) {
        $arguments = array_merge(array("stdObject" => $this), $arguments); // Note: method argument 0 will always referred to the main class ($this).
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $arguments);
        } else {
            return null;
            //throw new Exception("Fatal error: Call to undefined method stdObject::{$method}()");

        }
    }
    
    public function __get($name){
        if(property_exists($this, $name)):
            return $this->{$name};
        else:
            return $this->{$name} = null;
        endif;
    }
    
    public function __set($name, $value) {
        $this->{$name} = $value;
    }
    
}