<?php
/**
 * Notes:api基类
 * @package Talktrue\LaravelQuickApi\Controllers
 * @class ApiBasedController
 * @author:TalkTrue 2024-04-03
 */

namespace Talktrue\LaravelQuickApi\Controllers;

use App\Enums\ApiCodeEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Talktrue\LaravelQuickApi\Enums\HttpStatus;

class ApiBasedController extends BaseController
{
    protected array $only = [];
    protected array $except = [];//白名单

    public function __construct()
    {
        self::Sanctum();//令牌验证
    }

    /**
     * @Notes:接口鉴权验证
     * @Interface:Laravel Sanctum
     * @author:TalkTrue<705219520@qq.com>
     */
    protected function Sanctum()
    {
        $option = [];
        if (count($this->only)) {
            $option['only'] = $this->only;
        }
        if (count($this->except)) {
            $option['except'] = $this->except;
        }

        $this->middleware('auth:sanctum', $option);
    }

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

    /**
     * @Notes:成功
     * @Interface:Success
     * @param bool $data
     * @return \Illuminate\Http\JsonResponse
     * @author:TalkTrue<705219520@qq.com>
     */
    public static function Success($data = true, HttpStatus $httpStatus = HttpStatus::SUCCESS): JsonResponse
    {
        return self::ReturnMsg($httpStatus->value, $httpStatus->name, $data);
    }

    /**
     * @Notes:失败
     * @Interface:Error
     * @param string|null $megs
     * @param bool|null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function Error($data = false, HttpStatus $httpStatus = HttpStatus::NoContent): JsonResponse
    {
        return self::ReturnMsg($httpStatus->value, $httpStatus->name, $data);
    }

    /**
     * @Notes:判断
     * @Interface:IsReturnMsg
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function IsReturnMsg($data): JsonResponse
    {
        if ($data) {
            return self::Success();
        }
        return self::Error($data);
    }


    /**
     *  Notes：分页
     *  Name: Paging
     * @Author:TalkTrue 705219520@qq.com
     * @param $page
     * @return array
     */
    public static function Paging($page): array
    {
        if ($page instanceof LengthAwarePaginator) {
            return [
                'total' => $page->total(),
                'page' => $page->currentPage(),
                'limit' => $page->perPage(),
                'pages' => $page->lastPage(),
                'list' => $page->items()
            ];
        }


        return [];
    }


    /**
     * Notes:获取登录信息
     * Date: 2023/5/7 16:30
     * Author: TalkTrue
     * @return mixed
     */
    static function User()
    {
        return request()->user();
    }
}
