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

// Retrieve the JSON data from the request body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($action === 'sendCode') {
    $toEmail = $data['email'];
    $code = $twoFA->generateCode();
    $expiryTime = time() + 300; // 5 minutes from now
    
    // Store session information
    $storageData = readFromFile($storageFile) ?? [];
    $storageData[$toEmail] = [
        'code' => $code,
        'expires' => $expiryTime
    ];
    saveToFile($storageFile, $storageData);
    
    $sent = $twoFA->send2FACode($toEmail, $code);
    if ($sent) {
        echo json_encode(['success' => true, 'message' => '2FA code sent']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send 2FA code']);
    }
} elseif ($action === 'verifyCode') {
    $inputCode = (int)$data['code'];
    $toEmail = $data['email'];

    $storageData = readFromFile($storageFile);
    if (isset($storageData[$toEmail])) {
        $sessionData = $storageData[$toEmail];

        if ($sessionData['expires'] > time() && $sessionData['code'] === $inputCode) {
            echo json_encode(['success' => true, 'message' => '2FA code verified']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid or expired 2FA code']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or session expired']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}



?>