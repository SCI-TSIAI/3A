<?php


namespace App\Helpers;


class HttpHeadersHelper {

    public static function getHttpHeader($name) {
        $headers = array();

        foreach (getallheaders() as $key => $value) {
            $headers[strtolower($key)] = $value;
        }

        return isset($headers[strtolower($name)]) ? $headers[strtolower($name)] : null;
    }

    public static function getTokenForRequest() {
        $bearerToken = self::getHttpHeader("Authorization");

        $token = explode(" ", $bearerToken);

        return isset($token[1]) ? $token[1] : null;
    }

}