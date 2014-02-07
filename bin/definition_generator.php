#!/usr/bin/env php
<?php

use Zend\Code\Scanner\FileScanner as CodeFileScanner;
use Zend\Di\Definition\CompilerDefinition;

define('__ZFLIB__', __DIR__ . '/../vendor/zendframework/zendframework/library');

// Autoloader
$loader = require __ZFLIB__ . '/../../../autoload.php';

$loader->add('WebinoData', __DIR__ . '/../src');

// Compile Di Definition
$diCompiler = new CompilerDefinition;

$diCompiler->addDirectory(__DIR__ . '/../src');

foreach (array(

    // add files
    __ZFLIB__ . '/Zend/Db/TableGateway/TableGateway.php',
    __ZFLIB__ . '/Zend/Filter/FilterChain.php',
    __ZFLIB__ . '/Zend/InputFilter/Factory.php',
    __ZFLIB__ . '/Zend/Validator/ValidatorChain.php',

) as $file) {
    $diCompiler->addCodeScannerFile(new CodeFileScanner($file));
}

$diCompiler->compile();

$definition = $diCompiler->toArrayDefinition()->toArray();

$dir = __DIR__ . '/../data/di';

is_dir($dir) or mkdir($dir);

file_put_contents(
    $dir . '/definition.php',
    '<?php ' . PHP_EOL . 'return ' . var_export($definition, true) . ';' . PHP_EOL
);