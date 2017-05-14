<?php
/*
Copyright 2016-2017 Daniil Gentili
(https://daniil.it)
This file is part of MadelineProto.
MadelineProto is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
MadelineProto is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Affero General Public License for more details.
You should have received a copy of the GNU General Public License along with MadelineProto.
If not, see <http://www.gnu.org/licenses/>.
*/

namespace danog;

class SMSActivate
{
    public $key;
    public function __construct($key) {
        $this->key = $key;
    }
    public function __call($method, $params) {
        $params = isset($params[0]) ? $params[0] : [];
        $params['api_key'] = $this->key;
        $params['action'] = $method;
        $res = file_get_contents('http://sms-activate.ru/stubs/handler_api.php?'.http_build_query($params));
        switch ($method) {
            case 'getBalance': $res = str_replace('ACCESS_BALANCE:', '', $res); break;
            case 'getNumbersStatus':
                $jres = json_decode($res, true);
                if ($jres !== null) {
                    $res = new Numbers($jres);
                }
                break;
            case 'getNumber':
                if (strpos($res, 'ACCESS_NUMBER:') !== false) {
                    $res = ['id' => explode(':', $res)[1], 'number' => explode(':', $res)[2]];
                }
                break;
        }
        return $res;
    }
}
