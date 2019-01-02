<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    /**
     * 输出json结果
     * @param $retCode
     * @param $msg
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json_out($retCode, $msg, $data=NULL)
    {
        $jsonResult = [
            'code' => $retCode,
            'msg'  => $msg
        ];
        if(!is_null($data)){
            $jsonResult['data'] = $data;
        }
        return response()->json($jsonResult);
    }

    /**
     * 输出json结果：成功
     * @param $msg
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json_success($msg, $data=NULL)
    {
        return $this->json_out(0, $msg, $data);
    }

    /**
     * 输出json结果：异常
     * @param $msg
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json_failure($msg, $data=NULL)
    {
        return $this->json_out(-1, $msg, $data);
    }
}
