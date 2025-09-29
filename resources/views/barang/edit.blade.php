<x-main-layout :title-page="'Edit Barang'">
    <form class="card" action="{{ route('barang.update', $barang->id) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="card-body">
            @include('barang.partials._form', ['update' => true])
        </div>
    </form>
</x-main-layout>
