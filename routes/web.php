<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', function($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
})->name('locale.switch');

Route::get('/docs', [\App\Http\Controllers\DocsController::class, 'index'])->name('docs');

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);

Route::get('/blog', function () {
    return view('blog.index', [
        'posts' => \App\Models\BlogPost::where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(12),
    ]);
})->name('blog.index');

Route::get('/blog/{slug}', function ($slug) {
    $post = \App\Models\BlogPost::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();
    return view('blog.show', compact('post'));
})->name('blog.show');

Route::get('/blog/category/{slug}', function ($slug) {
    $category = \App\Models\BlogCategory::where('slug', $slug)->firstOrFail();
    $posts = $category->posts()
        ->where('is_published', true)
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->paginate(12);
    return view('blog.category', compact('category', 'posts'));
})->name('blog.category');

Route::get('/invoice/{invoice}/pdf', function (\App\Models\SalesInvoice $invoice) {
    return \App\Services\ReportPdfService::generateInvoicePdf($invoice)
        ->download('invoice-' . $invoice->invoice_no . '.pdf');
})->name('invoice.pdf')->middleware(['auth']);

Route::get('/purchase-order/{order}/pdf', function (\App\Models\PurchaseOrder $order) {
    return \App\Services\ReportPdfService::generatePurchaseOrderPdf($order)
        ->download('po-' . $order->order_no . '.pdf');
})->name('po.pdf')->middleware(['auth']);

Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Portal\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Portal\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Portal\AuthController::class, 'logout'])->name('logout');

    Route::middleware([\App\Http\Middleware\PortalAuth::class])->group(function () {
        Route::get('/', [\App\Http\Controllers\Portal\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/invoices', [\App\Http\Controllers\Portal\DashboardController::class, 'invoices'])->name('invoices');
        Route::get('/invoices/{id}', [\App\Http\Controllers\Portal\DashboardController::class, 'invoiceDetail'])->name('invoice.detail');
        Route::get('/payments', [\App\Http\Controllers\Portal\DashboardController::class, 'payments'])->name('payments');
    });
});

require base_path('routes/pair-routes.php');
