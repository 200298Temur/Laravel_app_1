<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangePost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post;
    public function __construct(Post $post)
    {
        $this->post=$post;   
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->post->photo='bigfile/bigfile.zip';
        $this->post->save();
    }
}
