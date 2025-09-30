<x-main-layout :title-page="__('Peminjaman')">
    <div class="card">
        <div class="card-body">
            @include('peminjaman.partials.toolbar')
            <x-notif-alert class="mt-4" />
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            @include('peminjaman.partials.list-peminjaman')
            {{ $peminjamans->links() }} {{-- pagination --}}
        </div>
    </div>
</x-main-layout>
