<x-table-list>
    <x-slot name="header">
        <tr>
            <th>#</th>
            <th>Nama Sumber Dana</th>
            @can('manage sumber_dana')
                <th>&nbsp;</th>
            @endcan
        </tr>
    </x-slot>

    @forelse ($sumber_danas as $index => $sumberDana)
        <tr>
            <td>{{ $sumber_danas->firstItem() + $index }}</td>
            <td>{{ $sumberDana->nama_sumber_dana }}</td>

            @can('manage sumber_dana')
                <td>
                    <x-tombol-aksi :href="route('sumber-dana.edit', $sumberDana->id)" type="edit" />
                    <x-tombol-aksi :href="route('sumber-dana.destroy', $sumberDana->id)" type="delete" />
                </td>
            @endcan
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center">
                <div class="alert alert-danger">
                    Data sumber dana belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse
</x-table-list>
