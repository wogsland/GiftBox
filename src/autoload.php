<?php
spl_autoload_register(
    function ($class) {
        if (0 !== strpos($class, 'GiveToken')) {
            return;
        } else {
            $class = ltrim($class, 'GiveToken');
        }
        $file = __DIR__.'/'.str_replace("\\", "/", $class).'.php';
        if (is_file($file)) {
            include $file;
        }
    }
);
