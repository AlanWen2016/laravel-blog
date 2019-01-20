<?php

namespace App\Services\Blog;


use App\Models\Blog;
use App\Services\CommonService;

class BlogService extends CommonService
{


    public function __construct(){

    }


    public function getBlogs($page = 0, $pageSize = 10, $title){
        $query = Blog::where('row_status', '=', 0)
            ->selectRaw('SQL_CALC_FOUND_ROWS *')
            ->orderBy('updated_at', 'desc');

        if(!empty($title)){
            $query->where('title','like',"%{$title}%");
        }

        $offset = ($page - 1) * $pageSize;
        $count = $query->count();
        $list = $query->offset($offset)->take($pageSize)->get()->toArray();
        return array('data'=>$list,'total'=>$count);
    }

    public function getBlogById($id){
        return Blog::find($id);
    }

    public function saveBlog($params){

        if(isset($params['id']) && $params['id']){
            $id = intval($params);
            $blog = Blog::find($id);
            $blog->title = $params['title'];
            $blog->status = 30;
            $blog->row_status = 0;
            $blog->content = $params['content'];
            $blog->save();
        }else{
            $blog = new Blog();
            $blog->title = $params['title'];
            $blog->status = 30;
            $blog->row_status = 0;
            $blog->content = $params['content'];
            $blog->save();
        }
        return $blog;
    }

}