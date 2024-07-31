<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    public function index()
    {
        return PostResource::collection(Post::limit(10)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $path = null;
    
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = $file->getClientOriginalName();
            $path = $request->file('photo')->storeAs('post-photos', $name);
        }
       
        $post = Post::create([
            'user_id' => 1,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'short_content' => $request->short_content,
            'content' => $request->content,
            'photo' => $path ?? null,
        ]);
    
        if (isset($request->tags)) {
            foreach ($request->tags as $tag) {
                $post->tags()->attach($tag);
            }
        }

        return response(['success' => 'Post yaratildi']);
    }


    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return "O'chirildi";
    }
}
