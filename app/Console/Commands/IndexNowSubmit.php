<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Services\Seo\IndexNowService;
use Illuminate\Console\Command;

class IndexNowSubmit extends Command
{
    protected $signature = 'seo:indexnow';
    protected $description = 'Submit new blog post URLs to IndexNow';

    public function handle(IndexNowService $indexNow): int
    {
        $posts = BlogPost::where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(50)
            ->get();

        foreach ($posts as $post) {
            $url = url('/blog/' . $post->slug);
            $indexNow->submit($url);
            $this->line("Submitted: {$url}");
        }

        $this->info('IndexNow submission complete.');
        return self::SUCCESS;
    }
}
