<?php

declare(strict_types=1);

namespace Webpag;

if (! function_exists('debug')) {
    function debug()
    {
        print "### DEBUG ###\n";
        foreach (func_get_args() as $arg) {
            print_r($arg);
            print "\n";
        }
        die();
    }
}