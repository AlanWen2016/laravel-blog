<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function json_success($msg = '操作成功',$data = array()){
        return response()->json(array('error' => 0,'msg' => $msg,'data' => $data));
    }

    public function json_failure($msg = '操作失败',$data = array()){
        return response()->json(array('error' => 1,'msg' => $msg,'data' => $data));
    }



}
