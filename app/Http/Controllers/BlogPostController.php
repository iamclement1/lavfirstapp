<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    //
    //create post
    public function newPost(Request $request)
    {
        $blogFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $blogFields['title'] = strip_tags($blogFields['title']);
        $blogFields['body'] = strip_tags($blogFields['body']);
        $blogFields['user_id'] = auth()->id();

        $newPost = Post::create($blogFields);
        return redirect('/post/' . $newPost->id)->with('success', 'Blog post successfully created');
    }

    //show post controller
    public function showCreateForm()
    {
        return view('create-post');
    }
    //show post url
    public function viewSinglePost(Post $post) {
        $post['body'] = strip_tags(Str::markdown($post -> body), 
    '<p><h1><h2><h3><h4><h5><h6><em><br><strong><ul><li><ol>');
        return view('single-post', ['post' => $post]);
    }
}
