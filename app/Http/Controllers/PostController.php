<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function index(){
        $posts = Post::latest()->paginate(12);
        $randomCategory = Category::all()->random(1);
        return view('post.posts',compact('posts','randomCategory'));
    }

    public function details($slug)
    {
        $post = Post::where('slug', $slug)->first();
        // view count
        $blogKey = 'blog_'.$post->id;
        if (!Session::has($blogKey)){
            $post->increment('view_count');
            Session::put($blogKey,1);
        }
        $randomPosts = Post::all()->random(3);
        return view('post.post', compact('post', 'randomPosts'));
    }

    public function postByCategory($slug){
        $category = Category::where('slug',$slug)->first();
        return view('post.category_posts', compact('category'));
    }
}
