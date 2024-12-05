<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class DashboardController extends Controller
{
    

public function showPost($id)
{
    // دریافت پست بر اساس ID
    $post = Post::find($id); 

    // دریافت تمام فیلدهای ACF مرتبط با پست
    $acfFields = $post->meta; 

    // ارسال داده‌ها به ویو
    return view('posts.show', ['post' => $post, 'acfFields' => $acfFields]);
}
}
