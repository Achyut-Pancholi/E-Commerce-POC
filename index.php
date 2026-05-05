<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * This file allows you to run Laravel from the root directory
 * on shared hosting like InfinityFree.
 */

define('LARAVEL_START', microtime(true));

// 1. Load the Composer Autoloader
require __DIR__.'/vendor/autoload.php';

// 2. Start the Laravel Application
$app = require_once __DIR__.'/bootstrap/app.php';

// 3. Handle the Request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
