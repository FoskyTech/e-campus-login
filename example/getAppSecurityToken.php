<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FoskyTech\ECampusLogin\Api;

$deviceId = 'ym-6ab3c7e083c8b49fcb0c8a88107416dd';
$securityToken = '1aa0bd9b487933f8989640c2f4416b38Ywk6vsFHi0n8isLZHD56Lg==';
$appSecurityTokenCalculate = Api::getAppSecurityToken($deviceId, $securityToken);

print_r($appSecurityTokenCalculate);