<?php

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;
use TwoFA\TwoFactorAuth;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

$twoFA = new TwoFactorAuth(
    $_ENV['SMTP_HOST'],
    $_ENV['SMTP_PORT'],
    $_ENV['SMTP_USER'],
    $_ENV['SMTP_PASS'],
    $_ENV['SMTP_FROM']
);

function saveToFile($filename, $data) {
    file_put_contents($filename, json_encode($data));
}

function readFromFile($filename) {
    if (file_exists($filename)) {
        $data = file_get_contents($filename);
        return json_decode($data, true);
    }
    return null;
}

$storageFile = '2fa_storage.json';



?>