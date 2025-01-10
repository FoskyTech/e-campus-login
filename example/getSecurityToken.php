<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FoskyTech\ECampusLogin\Api;

$deviceId = 'ym-6ab3c7e083c8b49fcb0c8a88107416dd';
$securityToken = Api::getSecurityToken($deviceId);

print_r($securityToken);