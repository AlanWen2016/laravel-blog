<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //


    public function saveBlog(Request $request)
    {

        $id = $request->input('id');
        $title = $request->input('title');
        $content = $request->input('content');

        return $request->all();
        
    }
}
