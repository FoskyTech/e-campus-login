<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FoskyTech\ECampusLogin\Api;

$deviceId = 'ym-' . md5(date('Y-m-d') . '1');

echo 'deviceId=' . $deviceId;

$phoneNumber = '';
$userId = '';
$token = ''; // token 看上去就是个时间戳，理论上应该可以 fake？并未进行尝试。

$result = Api::loginBySilent($deviceId, $phoneNumber, $userId, $token);
print_r($result);
