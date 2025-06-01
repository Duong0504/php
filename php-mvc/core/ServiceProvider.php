<?php
abstract class ServiceProvider {

    // View share
    public $db= null;
    abstract public function boot();
}