<?php
header('Content-Type: text/plain');

echo "VENDOR / CLOUDINARY:\n";
if (is_dir(__DIR__ . '/vendor/cloudinary/cloudinary_php')) {
    print_r(scandir(__DIR__ . '/vendor/cloudinary/cloudinary_php'));
} else {
    echo "vendor/cloudinary/cloudinary_php does not exist!\n";
}

echo "\nSRC EXISTS?\n";
var_dump(is_dir(__DIR__ . '/vendor/cloudinary/cloudinary_php/src'));
if (is_dir(__DIR__ . '/vendor/cloudinary/cloudinary_php/src')) {
    print_r(scandir(__DIR__ . '/vendor/cloudinary/cloudinary_php/src'));
}

echo "\nFILE Cloudinary.php EXISTS?\n";
var_dump(file_exists(__DIR__ . '/vendor/cloudinary/cloudinary_php/src/Cloudinary.php'));

echo "\nTEST AUTOLOAD:\n";
require_once __DIR__ . '/vendor/autoload.php';
var_dump(class_exists('Cloudinary\Cloudinary'));
