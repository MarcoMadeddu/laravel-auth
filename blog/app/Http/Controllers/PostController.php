<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    //ARCHIVE POST 

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
    }
}
