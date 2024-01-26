<?php

namespace BookPlugin;
/**
 * abstract class for the instance, constructor, and clone for the plugin
 */
abstract class Singleton
{
    /**
     * @var $instance
     */
    protected static $instance;

    /**
     * constructor
     */
    abstract protected function __construct();


    //prevent cloning (PHP specific)

    /**
     * @return void
     * prevents cloning
     */
    private function __clone()
    {
    }

    //method for creating/ returning the exsisting instance

    /**
     * @return mixed
     * getter for the instance
     */
    public static function getInstance()
    {
        //self == the class that it is written in
        // static == the class that implements/calls the method

        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}