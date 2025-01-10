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
    const PLATFORM = "YUNMA_APP";
    const USER_AGENT = "Mozilla/5.0 (Linux; Android 14) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/131.0.6778.135 Mobile Safari/537.36 ZJYXYwebviewbroswer ZJYXYAndroid tourCustomer/yunmaapp.NET/6.5.2/";
    const ENDPOINT = "https://compus.xiaofubao.com";

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

        return $data['data']['securityToken'];
    }

    static public function getAppSecurityToken($deviceId, $securityToken)
    {
        if (strlen($securityToken) != 56) {
            return ['', 'Invalid security token length'];
        }

        $key = substr($securityToken, 0, 16);
        $token = substr($securityToken, 32);

        $cipherText = base64_decode($token);
        if ($cipherText === false) {
            return ['', 'Invalid token encoding'];
        }

        $plainText = openssl_decrypt($cipherText, 'AES-128-ECB', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
        if ($plainText === false) {
            return ['', 'Decryption failed'];
        }

        $t = $plainText;

        $timestampNano = microtime(true) * 1000000000;
        $seconds = floor($timestampNano / 1e9);
        $microseconds = floor(($timestampNano % 1e9) / 1e2);
        $ts = sprintf("%.0f.%.0f", $seconds, $microseconds);

        $data = $deviceId . "|" . self::PLATFORM . "|" . $t . "|" . $ts . "|APP_ALL_VERSION";

        $md5Hash1 = strtoupper(md5($data));
        $md5Hash2 = strtoupper(md5($md5Hash1));

        $s = $md5Hash2;

        $data = $data . "|" . $s;
        $encrypted = openssl_encrypt($data, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        if ($encrypted === false) {
            return ['', 'Encryption failed: ' . openssl_error_string()];
        }

        $appSecurityToken = base64_encode($encrypted);

        return [$appSecurityToken, null];
    }

}