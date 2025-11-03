<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\ProductController;
use Illuminate\Contracts\View\View;

$controller = new ProductController();
$resp = $controller->index();

if ($resp instanceof View) {
    $data = $resp->getData();
    $categories = $data['categories'] ?? null;
    if (is_iterable($categories)) {
        echo 'categories count: ' . count($categories) . PHP_EOL;
        foreach ($categories as $cat) {
            echo '- ' . ($cat->name ?? $cat['name']) . ' (' . ($cat->products_count ?? '0') . ')\n';
        }
    } else {
        var_dump($categories);
    }
} else {
    echo 'Controller did not return a View; got: ' . gettype($resp) . PHP_EOL;
}
