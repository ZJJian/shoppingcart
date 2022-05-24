<?php

if ( ! function_exists('responseFormat')) {
    function responseFormat($code, $msg, $data = []): array
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }
}
