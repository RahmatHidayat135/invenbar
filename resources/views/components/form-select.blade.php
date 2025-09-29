@props([
    'name',
    'label' => null,
    'value' => null,
    'disabled' => false,
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'nama',
])

@if ($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
@endif

<select name="{{ $name }}" id="{{ $name }}"
    class="form-select @error($name) is-invalid @enderror"
    @disabled($disabled)>
    <option value="">{{ $label ? 'Pilih ' . $label . ' :' : 'Pilih Opsi :' }}</option>

    @foreach ($options as $item)
        <option value="{{ is_array($item) ? $item[$optionValue] : $item->$optionValue }}"
            @if ($value == (is_array($item) ? $item[$optionValue] : $item->$optionValue)) selected @endif>
            {{ is_array($item) ? $item[$optionLabel] : $item->$optionLabel }}
        </option>
    @endforeach
</select>

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
