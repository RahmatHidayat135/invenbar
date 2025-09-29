<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $titlePage ? $titlePage . ' - ' : '' }}{{ config('app.name', 'Laravel') }}
    </title>

    <link href="{{ asset('bootstrap/font/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-vh-100 bg-light pb-2">

    {{-- Navigation --}}
    @include('layouts.navigation')

    {{-- Header --}}
    @if ($titlePage)
        <header class="bg-white shadow-sm">
            <div class="container py-4">
                <h2 class="h5 mb-0">
                    {{ $titlePage }}
                </h2>
            </div>
        </header>
    @endif

    {{-- Main Content --}}
    <main class="container">
        <div class="my-5">
            {{ $slot }}
        </div>
    </main>

    {{-- Tambahkan modal delete di sini, sebelum tag <script> --}}
    <x-modal-delete />

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Kode JavaScript untuk menangani modal delete --}}
    <script>
        // Ambil elemen modal delete
        const deleteModal = document.getElementById('deleteModal');

        // Tambahkan event listener saat modal tampil
        deleteModal.addEventListener('show.bs.modal', event => {
            // Tombol yang memicu modal
            const button = event.relatedTarget;
            // Ambil URL dari atribut data-url pada tombol tersebut
            const url = button.getAttribute('data-url');
            // Ambil form di dalam modal
            const deleteForm = deleteModal.querySelector('form');
            // Salin URL ke atribut action pada form
            deleteForm.setAttribute('action', url);
        });
    </script>
</body>
</html>
