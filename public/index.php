<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Autoload Composer
require __DIR__.'/../vendor/autoload.php';

// Bootstrap app
$app = require_once __DIR__.'/../bootstrap/app.php';

// Buat Kernel HTTP
$kernel = $app->make(Kernel::class);

// Tangkap request dan jalankan aplikasi
$request = Request::capture();
$response = $kernel->handle($request);

// Kirim response ke browser
$response->send();

// Terminate kernel
$kernel->terminate($request, $response);
