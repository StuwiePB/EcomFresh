<?php
$vendor = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($vendor)) {
    echo "ERROR: vendor/autoload.php not found. Run composer install." . PHP_EOL;
    exit(1);
}
require $vendor;
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo 'customer_categories: ' . DB::table('customer_categories')->count() . PHP_EOL;
    echo 'customer_products: ' . DB::table('customer_products')->count() . PHP_EOL;
    echo 'customer_product_prices: ' . DB::table('customer_product_prices')->count() . PHP_EOL;
    echo 'products (legacy): ' . DB::table('products')->count() . PHP_EOL;
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
