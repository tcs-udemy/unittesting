<?php

// define custom functions

if (! function_exists('base_path')) {
    function base_path()
    {
        $base_path = str_replace("/bootstrap", "", __DIR__);
        return $base_path;
    }
}
