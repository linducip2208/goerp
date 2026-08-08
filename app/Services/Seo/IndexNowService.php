<?php

namespace App\Services\Seo;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class IndexNowService
{
    protected string $key;
    protected array $endpoints = [
        'https://api.indexnow.org/indexnow',
        'https://www.bing.com/indexnow',
    ];

    public function __construct()
    {
        $this->key = config('services.indexnow.key', '');
    }

    public function submit(string $url): void
    {
        if (Cache::has('indexnow:' . $url)) {
            return;
        }

        foreach ($this->endpoints as $endpoint) {
            Http::post($endpoint, [
                'host' => parse_url(config('app.url'), PHP_URL_HOST),
                'key' => $this->key,
                'urlList' => [$url],
            ]);
        }

        Cache::put('indexnow:' . $url, true, now()->addDays(30));
    }
}
