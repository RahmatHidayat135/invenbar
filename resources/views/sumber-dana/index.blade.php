<x-main-layout :title-page="__('Daftar Sumber Dana')">
    <div class="mb-3">
        @include('sumber-dana.partials.toolbar')
    </div>

    @include('sumber-dana.partials.list-sumber-dana')

    <div class="mt-3">
        {{ $sumber_danas->links() }}
    </div>
</x-main-layout>
