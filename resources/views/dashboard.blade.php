@extends('layouts.app')

@section('header')
<h2 class="h5 mb-0">Dashboard</h2>
@endsection

@section('title', 'Dashboard')

@section('content')

<div class="container mt-4">

    <!-- Greeting -->
        <h2 class="mb-4" style="font-size: 30px;">
            Selamat Datang, <strong>{{ auth()->user()->name }}</strong>!
        </h2>



            <div class="row g-3 mb-4">

                <!-- Total Barang -->
                <div class="col-md-3">
                    <div class="card border-primary shadow-sm h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-uppercase text-primary mb-1">TOTAL BARANG</h6>
                                <h3 class="mb-0">{{ $totalBarang }}</h3>
                            </div>
                            <i class="bi bi-box-seam text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <a href="{{ route('barang.index') }}" class="text-decoration-none small text-primary">
                                Lihat Selengkapnya <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total Kategori -->
                <div class="col-md-3">
                    <div class="card border-secondary shadow-sm h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-uppercase text-secondary mb-1">TOTAL KATEGORI</h6>
                                <h3 class="mb-0">{{ $totalKategori }}</h3>
                            </div>
                            <i class="bi bi-tags text-secondary" style="font-size: 2rem;"></i>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <a href="{{ route('kategori.index') }}" class="text-decoration-none small text-secondary">
                                Lihat Selengkapnya <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total Lokasi -->
                <div class="col-md-3">
                    <div class="card border-success shadow-sm h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-uppercase text-success mb-1">TOTAL LOKASI</h6>
                                <h3 class="mb-0">{{ $totalLokasi }}</h3>
                            </div>
                            <i class="bi bi-geo-alt text-success" style="font-size: 2rem;"></i>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <a href="{{ route('lokasi.index') }}" class="text-decoration-none small text-success">
                                Lihat Selengkapnya <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total User (hanya admin) -->
                @if(auth()->user()->hasRole('admin'))
                <div class="col-md-3">
                    <div class="card border-danger shadow-sm h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-uppercase text-danger mb-1">TOTAL USER</h6>
                                <h3 class="mb-0">{{ $totalUser }}</h3>
                            </div>
                            <i class="bi bi-people text-danger" style="font-size: 2rem;"></i>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <a href="{{ route('user.index') }}" class="text-decoration-none small text-danger">
                                Lihat Selengkapnya <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

            </div>


    <!-- Ringkasan & Barang Terbaru -->
    <div class="row g-3">

        <!-- Ringkasan Kondisi -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    Ringkasan Kondisi Barang
                </div>
                <div class="card-body">
                    <!-- Baik -->
                    <div class="d-flex justify-content-between mb-1">
                        <span>Baik</span>
                        <span>{{ $baikCount }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 16px;">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ $baikPercent }}%;" aria-valuenow="{{ $baikPercent }}"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <!-- Rusak Ringan -->
                    <div class="d-flex justify-content-between mb-1">
                        <span>Rusak Ringan</span>
                        <span>{{ $rusakRinganCount }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 16px;">
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ $rusakRinganPercent }}%;" aria-valuenow="{{ $rusakRinganPercent }}"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <!-- Rusak Berat -->
                    <div class="d-flex justify-content-between mb-1">
                        <span>Rusak Berat</span>
                        <span>{{ $rusakBeratCount }}</span>
                    </div>
                    <div class="progress" style="height: 16px;">
                        <div class="progress-bar bg-danger" role="progressbar"
                            style="width: {{ $rusakBeratPercent }}%;" aria-valuenow="{{ $rusakBeratPercent }}"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Terakhir -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    5 Barang Terakhir Ditambahkan
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Lokasi</th>
                                <th>Tgl. Pengadaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangTerbaru as $barang)
                            <tr>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->lokasi->nama_lokasi ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->format('d-m-Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Data barang belum tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
