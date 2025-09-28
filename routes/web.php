<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\TaxRateController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FormFieldController;

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
    return view('website.pages.index');
});

Route::get('/blog', function () {
    return view('website.pages.blog');
})->name('blog');
Route::get('/blog-details', function () {
    return view('website.pages.blog-details');
})->name('blog-details');
Route::get('/dashboard', function () {
    return view('admin.pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/schedule', function () {
        return view('admin.pages.schedule-calendar');
    })->name('schedule');

    // Route::get('/client/view', function () {
    //     return view('admin.pages.client.view_client');
    // })->name('clients.view');

    // client route
    Route::resource('clients', ClientController::class);
    Route::resource('form-fields', FormFieldController::class);
    Route::post('clients/add-tag', [ClientController::class, 'addTag'])->name('clients.addTag');
    Route::resource('tax-rates', TaxRateController::class)->except(['show']);

    Route::resource('jobs', JobController::class);

    Route::resource('requests', RequestController::class);
    Route::patch('requests/{request}/status', [RequestController::class, 'updateStatus'])->name('requests.update-status');
    Route::resource('quotes', QuoteController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/create-for-client/{client}', [InvoiceController::class, 'createForClient'])->name('invoices.create-for-client');
    Route::patch('invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.update-status');

    // API Routes for Calendar
    Route::prefix('api')->group(function () {
        Route::get('schedule-events', [\App\Http\Controllers\Api\ScheduleController::class, 'getEvents'])->name('api.schedule-events');
        Route::get('schedule-data/{date}', [\App\Http\Controllers\Api\ScheduleController::class, 'getDateData'])->name('api.schedule-data');
        Route::get('schedule-details/{date}', [\App\Http\Controllers\Api\ScheduleController::class, 'getDateDetails'])->name('api.schedule-details');
    });

});

require __DIR__ . '/auth.php';
