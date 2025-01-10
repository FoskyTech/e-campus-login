<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FoskyTech\ECampusLogin\Api;

$deviceId = 'ym-' . md5(time());
$securityToken = '1aa0bd9b487933f8989640c2f4416b38Ywk6vsFHi0n8isLZHD56Lg==';
$appSecurityTokenCalculate = Api::getAppSecurityToken($deviceId, $securityToken);

print_r($appSecurityTokenCalculate);