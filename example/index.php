<?php

use EditorTemplater\Engine;

require 'vendor/autoload.php';
require 'HelloFunction.php';

$engine = new Engine();
$engine->addFunction(new HelloFunction());

echo $engine->compile('{{ hello(world) }}') . PHP_EOL;
