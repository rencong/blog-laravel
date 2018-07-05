<?php
/**
 * Created by PhpStorm.
 * User: xiaoxiaocong
 * Date: 2018/7/3
 * Time: 上午10:50
 */

function apiError($message)
{
    return \Illuminate\Support\Facades\Response::json([
        'status'  => 'failed',
        'code'    => 404,
        'message' => $message
    ]);
}

function apiSuccess($data = [])
{
    return \Illuminate\Support\Facades\Response::json([
        'status' => 'success',
        'code'   => 200,
        'data'   => $data
    ]);
}