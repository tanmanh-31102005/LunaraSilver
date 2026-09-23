<?php
header('Content-Type: text/plain');

echo "VENDOR DIRECTORY:\n";
if (is_dir(__DIR__ . '/vendor')) {
    print_r(scandir(__DIR__ . '/vendor'));
} else {
    echo "vendor dir does not exist!\n";
}

echo "\nCOMPOSER DIRECTORY:\n";
if (is_dir(__DIR__ . '/vendor/composer')) {
    print_r(scandir(__DIR__ . '/vendor/composer'));
}

echo "\nIS CLOUDINARY DIR EXIST?\n";
var_dump(is_dir(__DIR__ . '/vendor/cloudinary'));
if (is_dir(__DIR__ . '/vendor/cloudinary')) {
    print_r(scandir(__DIR__ . '/vendor/cloudinary'));
}
