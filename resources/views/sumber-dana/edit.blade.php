<x-main-layout :title-page="__('Edit Sumber Dana')">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('sumber-dana.update', $sumberDana->id) }}" method="POST">
            <div class="card-body">
                @csrf
                @method('PUT')
                @include('sumber-dana.partials._form', ['update' => true])
            </div>
        </form>
    </div>
</x-main-layout>
