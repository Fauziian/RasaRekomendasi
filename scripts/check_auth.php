<?php
$autoload = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoload)) {
	echo "Cannot find vendor/autoload.php, run composer install" . PHP_EOL;
	exit(1);
}
require $autoload;
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

// create user
$user = User::factory()->create();

// show stored password
echo "Stored password hash: " . $user->password . PHP_EOL;

// attempt login
$attempt = Auth::attempt(['email' => $user->email, 'password' => 'password']);
echo "Auth attempt returned: " . ($attempt ? 'true' : 'false') . PHP_EOL;

echo "Auth check: " . (Auth::check() ? 'true' : 'false') . PHP_EOL;

// print user details
print_r([$user->email, $user->id]);

return 0;
