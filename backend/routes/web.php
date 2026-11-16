<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerContactController;
use App\Http\Controllers\ServiceOrderController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DiagnosisEstimateController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::middleware(['auth', 'active'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Melihat daftar pengguna
    Route::middleware('permission:users.view')->group(function () {
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');
    });

    // Mengelola pengguna
    Route::middleware('permission:users.manage')->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('users.update');
    });

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');


    // Manajemen Pelanggan
    Route::middleware('permission:customers.view')->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])
            ->name('customers.index');
    });

    Route::middleware('permission:customers.manage')->group(function () {
        Route::get('/customers/create', [CustomerController::class, 'create'])
            ->name('customers.create');

        Route::post('/customers', [CustomerController::class, 'store'])
            ->name('customers.store');

        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])
            ->name('customers.edit');

        Route::put('/customers/{customer}', [CustomerController::class, 'update'])
            ->name('customers.update');
    });

    Route::middleware('permission:customers.view')->group(function () {
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])
            ->whereNumber('customer')
            ->name('customers.show');
    });


    // Pengelolaan Kontak Pelanggan
    Route::middleware('permission:customers.manage')->group(function () {
        Route::post(
            '/customers/{customer}/contacts',
            [CustomerContactController::class, 'store']
        )->name('customers.contacts.store');

        Route::put(
            '/customers/{customer}/contacts/{contact}',
            [CustomerContactController::class, 'update']
        )->name('customers.contacts.update');

        Route::patch(
            '/customers/{customer}/contacts/{contact}/status',
            [CustomerContactController::class, 'toggleStatus']
        )->name('customers.contacts.toggle-status');
    });

    // Manajemen Pesanan Servis

    // Melihat daftar dan detail pesanan servis
    Route::middleware('permission:service_orders.view')->group(function () {
        Route::get('/service-orders', [ServiceOrderController::class, 'index'])
            ->name('service-orders.index');

        Route::get('/service-orders/{serviceOrder}', [ServiceOrderController::class, 'show'])
            ->whereNumber('serviceOrder')
            ->name('service-orders.show');
    });

    // Membuat pesanan servis baru
    Route::middleware('permission:service_orders.create')->group(function () {
        Route::get('/service-orders/create', [ServiceOrderController::class, 'create'])
            ->name('service-orders.create');

        Route::post('/service-orders', [ServiceOrderController::class, 'store'])
            ->name('service-orders.store');
    });

    // Diagnosis Perangkat
    Route::middleware('permission:diagnoses.manage')->group(function () {
        Route::post(
            '/service-items/{serviceItem}/diagnoses',
            [DiagnosisEstimateController::class, 'storeDiagnosis']
        )
            ->whereNumber('serviceItem')
            ->name('service-items.diagnoses.store');
    });

    // Estimasi Biaya
    Route::middleware('permission:estimates.manage')->group(function () {
        Route::post(
            '/service-items/{serviceItem}/estimates',
            [DiagnosisEstimateController::class, 'storeEstimate']
        )
            ->whereNumber('serviceItem')
            ->name('service-items.estimates.store');
    });

    // Persetujuan Pelanggan
    Route::middleware('permission:customer_approvals.manage')->group(function () {
        Route::post(
            '/service-items/{serviceItem}/approvals',
            [DiagnosisEstimateController::class, 'storeApproval']
        )
            ->whereNumber('serviceItem')
            ->name('service-items.approvals.store');
    });
});
