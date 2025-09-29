<x-main-layout :title-page="__('Barang')">
<div class="card">
<div class="card-body">
@include('barang.partials.toolbar')
<x-notif-alert class="mt-4" />
</div>
</div>

<div class="card mt-4">
    <div class="card-body">
        @include('barang.partials.list-barang')
        {{ $barangs->links() }}
    </div>
</div>

</x-main-layout>