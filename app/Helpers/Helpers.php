<?php

if ( ! function_exists('responseFormat')) {
    function responseFormat($code, $msg, $data = []): array
    {
        return [
            'status' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }
}
