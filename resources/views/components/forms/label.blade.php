@props(['for'])

<label for="{{ $for }}" {{ $attributes->class('label') }}>
    {{ $slot }}
</label>
