<?php

require __DIR__ . '/vendor/autoload.php';

header('Content-Type: text/html; charset=utf-8');

if (class_exists('Cloudinary\Cloudinary')) {
    echo "SUCCESS: Class Cloudinary\\Cloudinary is loaded successfully!";
} else {
    echo "ERROR: Class Cloudinary\\Cloudinary not found.";
}
