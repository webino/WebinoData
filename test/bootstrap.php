<?php

chdir(__DIR__);

$loader = @include 'autoload.php';

if (empty($loader)) {
    throw new RuntimeException('Unable to load. Run `php composer.phar install`.');
}

$loader->add('WebinoData', __DIR__ . '/../src');
