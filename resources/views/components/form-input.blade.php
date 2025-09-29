@props([
    'name',
    'label' => null,
    'value' => null,
    'type' => 'text',
])

@if ($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
@endif

<input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
    value="{{ old($name, $value) }}"
    class="form-control @error($name) is-invalid @enderror">

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
