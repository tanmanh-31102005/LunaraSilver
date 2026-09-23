<?php
header('Content-Type: text/plain');

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if (class_exists('Cloudinary\Cloudinary')) {
    echo "SUCCESS: Class Cloudinary\\Cloudinary is loaded successfully!\n";
} else {
    echo "ERROR: Class Cloudinary\\Cloudinary not found.\n";
}
