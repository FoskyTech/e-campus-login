<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FoskyTech\ECampusLogin\Api;

$deviceId = 'ym-' . md5(date('Y-m-d'));
$securityToken = Api::getSecurityToken($deviceId);
if ($securityToken['level'] !== 0) {
    $imageCaptcha = Api::getImageCaptcha($deviceId, $securityToken);
    print_r($imageCaptcha);
} else {
    print_r('不需要验证码');
}