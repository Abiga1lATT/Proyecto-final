@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-white drop-shadow-md']) }}>
    {{ $value ?? $slot }}
</label>