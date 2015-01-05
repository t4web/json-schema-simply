<?php


$autoloadFile = dirname(__DIR__) . '/vendor/autoload.php';

if (! is_readable($autoloadFile)) {
    echo <<<EOT
You must run `composer.phar install` to install the dependencies
before running the test suite.

EOT;
    exit(1);
}

// Include the Composer generated autoloader
require_once $autoloadFile;

spl_autoload_register(function ($class)
{
    if (0 === strpos($class, 'JsonSchemaSimply\\Tests')) {
        $classFile = str_replace('\\', '/', $class) . '.php';
        require __DIR__ . '/' . $classFile;
    }
});
