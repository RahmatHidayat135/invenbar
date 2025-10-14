<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gunakan Bootstrap 5 untuk pagination
        Paginator::useBootstrapFive();

        // ✅ Gate untuk mengatur izin sumber dana
        Gate::define('manage sumber_dana', function ($user) {
            return $user->hasRole('admin'); // hanya admin yang bisa tambah/edit/hapus sumber dana
        });
    }
}
