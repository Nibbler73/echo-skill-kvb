<?php
/**
 * Created by PhpStorm.
 * User: hhusic
 * Date: 14.07.2017
 * Time: 13:47
 */

function __autoload($classname) {
    $path = '../classes/' . $classname . '.php';

    return file_exists($path) ? require_once $path : false;
}

