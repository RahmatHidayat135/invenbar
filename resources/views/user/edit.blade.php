<x-main-layout :title-page="__('Edit User')">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                @include('user.partials._form', ['update' => true])
            </div>
        </form>
    </div>
</x-main-layout>
