<?php
$autoload = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoload)) { echo "composer autoload missing\n"; exit(1); }
require $autoload;
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/login', 'GET');

try {
    $response = $kernel->handle($request);
    echo "Response status: " . $response->getStatusCode() . PHP_EOL;
    echo (string)$response->getContent();
} catch (Throwable $e) {
    echo "Exception: " . get_class($e) . " - " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString();
}

return 0;
