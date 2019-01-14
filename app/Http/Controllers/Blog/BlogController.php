<?php

namespace App\Http\Controllers\Blog;

use App\Services\Blog\BlogService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{

    /**
     * @param Request $request
     * @param BlogService $blogService
     * @return mixed
     */
    public function getBlogs(Request $request, BlogService $blogService)
    {
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',10);
        $title = $request->input('title');
        $blogData = $blogService->getBlogs($page, $pageSize, $title);
        return response()->json($blogData);
    }

    /**
     * 拉取博客详情
     * @param Request $request
     * @param BlogService $blogService
     * @return \Illuminate\Http\JsonResponse
     */
    public function blogInfo(Request $request, BlogService $blogService)
    {
        $id = intval($request->input('id'));
        if(empty($id)){
            return $this->json_failure('参数错误~');
        }
        $data = $blogService->getBlogById($id);
        return response()->json($data);

    }


    public function saveBlog(Request $request, BlogService $blogService)
    {
        $params = $request->only(['title', 'textValue', 'tagIds','id']);
        $message = [
            'title.required'             => '标题不能为空',
            'textValue.required'           => '内容不能为空',
            'tagIds.required'            => '类型不能为空',
        ];
        $validate = Validator::make($params,[
            'title'               => 'required',
            'textValue'             => 'required',
            'tagIds'              => 'required',
        ],$message);
        $errors = $validate->errors();
        foreach($errors->all() as $error) {
            return ['error' => 1, 'msg' => $error];
        }
        $ret = $blogService->saveBlog($params);
        return $this->json_success('操作成功',$ret);
        
    }



}
