<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FoskyTech\ECampusLogin\Api;

$deviceId = 'ym-' . md5(date('Y-m-d') . '1');
$securityToken = Api::getSecurityToken($deviceId);

print_r($securityToken);

$securityToken = $securityToken['securityToken'];
$appSecurityTokenCalculate = Api::getAppSecurityToken($deviceId, $securityToken);

$phoneNumber = '';

$result = Api::sendLoginCode($deviceId, $securityToken, $phoneNumber);
print_r($result);