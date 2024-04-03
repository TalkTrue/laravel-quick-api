<?php
/**
 * Notes:
 * @package Talktrue\LaravelQuickApi\Controllers
 * @class ApiBasedController
 * @author:TalkTrue 2024-04-03
 */
namespace Talktrue\LaravelQuickApi\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class ApiBasedController extends BaseController
{
    /**
     * @Notes:统一返回
     * @Interface:ReturnMsg
     * @param $msg
     * @param $code
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     * @author:TalkTrue<705219520@qq.com>
     */
    private static function ReturnMsg($msg, $code, $data): JsonResponse
    {
        return response()->json([
            'msg' => $msg,
            'code' => $code,
            'data' => $data
        ], $code);
    }
}