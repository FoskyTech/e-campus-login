<?php

// Copyright (C) 2025 FoskyM<i@fosky.top>

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.

// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.

// The file created at 2025/01/10 15:45.

namespace FoskyTech\ECampusLogin;

use FoskyTech\ECampusLogin\RequestUtil;

class Api
{
    const APP_VERSION = "640";
    const APP_SCHEMA_VERSION = "6.5.2";
    const MOBILE_OS = "ANDROID";
    const MOBILE_OS_VERSION = "14";
    const MOBILE_BRAND = "XIAOMI";
    const MOBILE_TYPE = "Android for arm64";
    const CLIENT_ID = "65l2o68kessyp8e";
    const PLATFORM = "YUNMA_APP";
    const USER_AGENT = "Mozilla/5.0 (Linux; Android 14) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/131.0.6778.135 Mobile Safari/537.36 ZJYXYwebviewbroswer ZJYXYAndroid tourCustomer/yunmaapp.NET/6.5.2/";
    const ENDPOINT = "https://compus.xiaofubao.com";

    static public function loginBySilent($deviceId, $phoneNumber, $userId, $token)
    {
        $url = self::ENDPOINT . '/login/doLoginBySilent';

        $param = [
            'appVersion' => self::APP_VERSION,
            'appAllVersion' => self::APP_SCHEMA_VERSION,
            'appPlatform' => self::MOBILE_OS,
            'brand' => self::MOBILE_BRAND,
            'clientId' => self::CLIENT_ID,
            'deviceId' => $deviceId,
            'platform' => self::PLATFORM,
            'mobilePhone' => $phoneNumber,
            'ymId' => $userId,
            'mobileType' => self::MOBILE_TYPE,
            'osType' => self::MOBILE_OS,
            'osVersion' => self::MOBILE_OS_VERSION,
            'invitationCode' => '',
            'schoolCode' => '',
            'testAccount' => 1,
            'token' => $token
        ];
        $headers = [
            'user-agent: ' . self::USER_AGENT . $deviceId
        ];

        $ret = RequestUtil::post($url, $param, $headers, '', true, false);
        $response = json_decode($ret['response'], true);

        if (!$response['success']) return false;

        return $response['data'];
    }

    static public function loginByCode($deviceId, $phoneNumber, $verificationCode)
    {
        $url = self::ENDPOINT . '/login/doLoginByVerificationCode';

        $param = [
            'appVersion' => self::APP_VERSION,
            'appAllVersion' => self::APP_SCHEMA_VERSION,
            'appPlatform' => self::MOBILE_OS,
            'brand' => self::MOBILE_BRAND,
            'clientId' => self::CLIENT_ID,
            'deviceId' => $deviceId,
            'platform' => self::PLATFORM,
            'mobilePhone' => $phoneNumber,
            'verificationCode' => $verificationCode,
            'mobileType' => self::MOBILE_TYPE,
            'osType' => self::MOBILE_OS,
            'osVersion' => self::MOBILE_OS_VERSION,
            'invitationCode' => '',
            'schoolCode' => '',
            'testAccount' => 1,
            'token' => ''
        ];

        $headers = [
            'user-agent: ' . self::USER_AGENT . $deviceId
        ];

        $ret = RequestUtil::post($url, $param, $headers, '', true, false);
        $response = json_decode($ret['response'], true);

        if (!$response['success']) return false;

        return $response['data'];
    }

    static public function getImageCaptcha($deviceId, $securityToken)
    {
        $url = self::ENDPOINT . '/common/security/imageCaptcha';
        if (is_array($securityToken)) {
            $securityToken = $securityToken['securityToken'];
        }

        $param = [
            'appVersion' => self::APP_VERSION,
            'deviceId' => $deviceId,
            'platform' => self::PLATFORM,
            'securityToken' => $securityToken,
            'schoolCode' => '',
            'testAccount' => 1,
            'token' => ''
        ];

        $headers = [
            'user-agent: ' . self::USER_AGENT . $deviceId
        ];

        $ret = RequestUtil::post($url, $param, $headers, '', true, false);
        $response = json_decode($ret['response'], true);

        if (!$response['success']) return false;

        $base64 = str_replace('data:image/jpeg;base64,', '', $response['data']);
        return base64_decode($base64);
    }

    static public function sendLoginCode($deviceId, $securityToken, $phoneNumber, $sendCount = 0, $imageCaptchaVal = '', $appSecurityToken = '')
    {
        $url = self::ENDPOINT . '/compus/user/sendLoginVerificationCode';
        if (is_array($securityToken)) {
            $securityToken = $securityToken['securityToken'];
        }
        if (!$appSecurityToken) {
            $appSecurityToken = self::getAppSecurityToken($deviceId, $securityToken)[0];
        }
        $param = [
            'appVersion' => self::APP_VERSION,
            'deviceId' => $deviceId,
            'platform' => self::PLATFORM,
            'securityToken' => $securityToken,
            'appSecurityToken' => $appSecurityToken,
            'mobilePhone' => $phoneNumber,
            'sendCount' => $sendCount,
            'schoolCode' => '',
            'testAccount' => 1,
            'token' => ''
        ];
        if ($imageCaptchaVal != '') {
            $param['imageCaptchaValue'] = $imageCaptchaVal;
        }
        ksort($param);
        $headers = [
            'user-agent: ' . self::USER_AGENT . $deviceId,
            'content-type: application/json; charset=UTF-8'
        ];

        $ret = RequestUtil::post($url, $param, $headers, '', true, true);
        $response = $ret['response'];

        $data = json_decode($response, true);
        if (!$data['success']) return false;

        return $data['data']['userExists'];
    }

    static public function getSecurityToken($deviceId, $sceneCode = 'app_user_login')
    {
        $url = self::ENDPOINT . '/common/security/token';
        $param = [
            'appVersion' => self::APP_VERSION,
            'deviceId' => $deviceId,
            'platform' => self::PLATFORM,
            'sceneCode' => $sceneCode,
            'schoolCode' => '',
            'testAccount' => 1,
            'token' => ''
        ];
        $headers = [
            'user-agent: ' . self::USER_AGENT . $deviceId
        ];

        $ret = RequestUtil::post($url, $param, $headers, '', true, false);
        $response = $ret['response'];

        $data = json_decode($response, true);
        if (!$data['success']) return false;

        return $data['data'];
    }

    static public function getAppSecurityToken($deviceId, $securityToken)
    {
        if (is_array($securityToken)) {
            $securityToken = $securityToken['securityToken'];
        }
        if (strlen($securityToken) != 56) {
            return ['', 'Invalid security token length'];
        }

        $key = substr($securityToken, 0, 16);
        $token = substr($securityToken, 32);

        $cipherText = base64_decode($token);
        if ($cipherText === false) {
            return ['', 'Invalid token encoding'];
        }

        $plainText = openssl_decrypt($cipherText, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        if ($plainText === false) {
            return ['', 'Decryption failed'];
        }

        $t = $plainText;
        $ts = floor(microtime(true) * 1e3 - 300);

        $data = $deviceId . "|" . self::PLATFORM . "|" . $t . "|" . $ts . "|" . self::APP_SCHEMA_VERSION;

        $md5Hash1 = strtoupper(md5($data));
        $md5Hash2 = strtoupper(md5($md5Hash1));

        $data = $data . "|" . $md5Hash2;
        $encrypted = openssl_encrypt($data, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        if ($encrypted === false) {
            return ['', 'Encryption failed: ' . openssl_error_string()];
        }

        $appSecurityToken = base64_encode($encrypted);

        return [$appSecurityToken, null];
    }
}