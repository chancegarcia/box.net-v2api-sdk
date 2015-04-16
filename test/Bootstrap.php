<?php
/**
 * @package     Box
 * @subpackage  Box_Test
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace BoxTest;

set_include_path(implode(PATH_SEPARATOR, array(
    '.',
    __DIR__ . '/../src',
    get_include_path(),
)));

spl_autoload_register(function($class) {
    $file = str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $class) . '.php';
    if (false === ($realpath = stream_resolve_include_path($file))) {
        return false;
    }
    include_once $realpath;
});