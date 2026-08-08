<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0'],
            ['loc' => url('/docs'), 'priority' => '0.9'],
            ['loc' => url('/blog'), 'priority' => '0.8'],
        ];

        return response()->view('pseo.sitemap', compact('urls'))->header('Content-Type', 'application/xml');
    }
}
