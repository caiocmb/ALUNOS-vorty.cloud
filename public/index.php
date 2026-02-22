<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Env;
use App\Core\Router;

Env::load(__DIR__ . '/../.env');

Router::dispatch();
