<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //


    public function saveBlog(Request $request)
    {
        return $request->all();
        
    }
}
