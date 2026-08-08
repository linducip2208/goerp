<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgrammaticSeoController extends Controller
{
    protected array $pseoPatterns = [
        'best-{category}' => 'bestCategory',
        'best-{category}-{year}' => 'bestCategoryYear',
        'alternatives-to-{slug}' => 'alternatives',
        'compare/{a}-vs-{b}' => 'compare',
        '{category}-under-{price}' => 'categoryUnderPrice',
        'learn-{skill}-online' => 'learnSkillOnline',
    ];

    public function index()
    {
        return response()->view('pseo.index', [
            'totalPages' => 1000000,
            'patterns' => $this->pseoPatterns,
        ]);
    }

    public function bestCategory(string $category): \Illuminate\View\View
    {
        $title = "10 {$category} Terbaik " . date('Y');
        return $this->renderPseoPage($title, 'best-category', compact('category'));
    }

    public function bestCategoryYear(string $category, string $year): \Illuminate\View\View
    {
        $title = "10 {$category} Terbaik Tahun {$year}";
        return $this->renderPseoPage($title, 'best-category-year', compact('category', 'year'));
    }

    public function alternatives(string $slug): \Illuminate\View\View
    {
        $name = str_replace('-', ' ', $slug);
        $title = "10 Alternatif {$name} — Pilihan Terbaik " . date('Y');
        return $this->renderPseoPage($title, 'alternatives', compact('slug', 'name'));
    }

    public function compare(string $a, string $b): \Illuminate\View\View
    {
        $nameA = str_replace('-', ' ', $a);
        $nameB = str_replace('-', ' ', $b);
        $title = "{$nameA} vs {$nameB} — Perbandingan Lengkap " . date('Y');
        return $this->renderPseoPage($title, 'compare', compact('a', 'b', 'nameA', 'nameB'));
    }

    public function categoryUnderPrice(string $category, string $price): \Illuminate\View\View
    {
        $title = "{$category} di Bawah Rp " . number_format((int)$price, 0, ',', '.') . " — Rekomendasi " . date('Y');
        return $this->renderPseoPage($title, 'category-under-price', compact('category', 'price'));
    }

    public function learnSkillOnline(string $skill): \Illuminate\View\View
    {
        $name = str_replace('-', ' ', $skill);
        $title = "Belajar {$name} Online — Panduan Lengkap " . date('Y');
        return $this->renderPseoPage($title, 'learn-skill', compact('skill', 'name'));
    }

    protected function renderPseoPage(string $title, string $type, array $data): \Illuminate\View\View
    {
        $canonical = url()->current();
        $description = "{$title}. Temukan informasi lengkap, perbandingan, dan rekomendasi terbaik.";

        return view('pseo.page', array_merge($data, [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'type' => $type,
        ]));
    }
}
