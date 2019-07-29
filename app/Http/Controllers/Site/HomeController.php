<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Classificado;
use App\Models\Banner;
use App\Models\Position;
use App\Models\Post;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        return view('site.home.index', compact( 'posts' ));
    }
}
