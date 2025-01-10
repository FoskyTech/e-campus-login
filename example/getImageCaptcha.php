<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FoskyTech\ECampusLogin\Api;

$deviceId = 'ym-' . md5(date('Y-m-d'));
$securityToken = Api::getSecurityToken($deviceId);
$imageCaptcha = Api::getImageCaptcha($deviceId, $securityToken);

print_r($imageCaptcha);