<x-main-layout title-page="{{ __('Tambah Sumber Dana') }}">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('sumber-dana.store') }}" method="POST">
            <div class="card-body">
                @include('sumber-dana.partials._form')
            </div>
        </form>
    </div>
</x-main-layout>
