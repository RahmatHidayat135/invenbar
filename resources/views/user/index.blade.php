<x-main-layout :title-page="__('User')">

    <div class="card mt-4">
        <div class="card-body">
            {{-- Toolbar (tombol tambah, export, dll) --}}
            @include('user.partials.toolbar')

            {{-- Alert notification --}}
            <x-notif-alert class="mt-4" />

            {{-- List User --}}
            @include('user.partials.list-user')

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

</x-main-layout>
