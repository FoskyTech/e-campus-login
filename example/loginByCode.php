<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FoskyTech\ECampusLogin\Api;

$deviceId = 'ym-' . md5(date('Y-m-d') . '1');

echo 'deviceId=' . $deviceId;

$phoneNumber = '';
$verificationCode = '';

$result = Api::loginByCode($deviceId, $phoneNumber, $verificationCode);
print_r($result);
