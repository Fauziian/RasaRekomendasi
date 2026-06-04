<?php
$autoload = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoload)) {
    echo "composer autoload missing\n";
    exit(1);
}
require $autoload;
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$class = 'App\\Http\\Controllers\\Auth\\EmailVerificationPromptController';

if (!class_exists($class)) {
    echo "Class not found: $class\n";
    exit(1);
}

$reflect = new ReflectionClass($class);
if ($reflect->hasMethod('__invoke')) {
    echo "Class $class is invokable\n";
} else {
    echo "Class $class is NOT invokable\n";
}

// Test creating instance
$inst = new $class();
if (is_callable($inst)) {
    echo "Instance is callable\n";
} else {
    echo "Instance is NOT callable\n";
}

return 0;
