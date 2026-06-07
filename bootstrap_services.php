<?php
// Bootstrap script for Laravel Services
require_once __DIR__ . '/vendor/autoload.php';

// Create Services/Denah directory structure
$servicesDenahPath = __DIR__ . '/app/Services/Denah';
if (!is_dir($servicesDenahPath)) {
    @mkdir($servicesDenahPath, 0755, true);
}

echo "Directory created: $servicesDenahPath\n";

// Now the regular create tool should work
?>
