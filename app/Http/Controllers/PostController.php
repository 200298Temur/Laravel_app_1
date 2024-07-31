<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Jobs\ChangePost;
use App\Mail\PostCreated as MailPostCreated;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\PostCreated as NotificationsPostCreated;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; // Auth fasadini import qilamiz
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {   

       
        $posts = Cache::remember('posts', now()->addSeconds(30), function () {
            return Post::latest()->paginate(9);
        });

        return view('posts.index')->with('posts', $posts);

        
    }

    public function create()
    {
        Gate::authorize('create-post');

        return view('posts.create')->with([
            'categorys' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $path = null;
    
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = $file->getClientOriginalName();
            $path = $request->file('photo')->storeAs('post-photos', $name);
        }
    
       
        $post = Post::create([
            'user_id' => Auth::id(),
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
    
        // Dispatching job to upload post
        ChangePost::dispatch($post)->onQueue('uploading');
    
        // Sending email notification
        Mail::to(Auth::user())->later(now()->addMilliseconds(15), (new MailPostCreated($post))->onQueue('sending-mails'));
    
        try {
            Notification::sendNow(auth()->user(), new NotificationsPostCreated($post));
            // Log::info('Notification sent successfully');
        } catch (\Exception $e) {
            // Log::error('Failed to send notification: ' . $e->getMessage());
        }

        return redirect()->route('posts.index')->with('success','Post Yaratildi!');
    }
    

    public function show(Post $post)
    {
        return view('posts.show')->with([
            'post' => $post,
            'tags' => Tag::all(),
            'categorys' => Category::all(),
            'recent_posts' => Post::latest()->where('id', '!=', $post->id)->take(5)->get()
        ]);
    }

    public function edit(Post $post)
    {
        // Authorize user
        $this->authorize('update', $post);

        return view('posts.edit')->with(['post' => $post]);
    }

    public function update(StorePostRequest $request, Post $post)
    {
        // Authorize user
        Gate::authorize('update', $post);

        $path = $post->photo;

        if ($request->hasFile('photo')) {
            if (isset($post->photo)) {
                Storage::delete($post->photo);
            }
            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('post-photos', $name);
        }

        $post->update([
            'title' => $request->title,
            'short_content' => $request->short_content,
            'content' => $request->content,
            'photo' => $path
        ]);

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy(Post $post)
    {
        // Detach tags related to the post
        $post->tags()->detach();

        // Delete comments related to the post
        $post->comments()->delete();

        // Delete post photo if exists
        if (isset($post->photo)) {
            Storage::delete($post->photo);
        }

        // Delete the post
        $post->delete();

        // Redirect to post index
        return redirect()->route('posts.index');
    }
}
