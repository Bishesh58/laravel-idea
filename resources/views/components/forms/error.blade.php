@props(['field'])

@error($field)
    <p {{ $attributes->class('error') }}>{{ $message }}</p>
@enderror
