<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FoskyTech\ECampusLogin\Api;

$deviceId = 'ym-' . md5(time());
$securityToken = Api::getSecurityToken($deviceId);

print_r($securityToken);

$securityToken = $securityToken['securityToken'];
$appSecurityTokenCalculate = Api::getAppSecurityToken($deviceId, $securityToken);

$phoneNumber = '';

$result = Api::sendLoginCode($deviceId, $securityToken, $phoneNumber);
print_r($result);