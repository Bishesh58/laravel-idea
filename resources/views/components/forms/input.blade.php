@props(['name', 'type' => 'text'])

@php
    $inputAttributes = $attributes
        ->except(['value'])
        ->class('input')
        ->merge([
            'name' => $name,
            'type' => $type,
        ]);
@endphp

<input
    {{ $inputAttributes }}
    @if (! in_array($type, ['password', 'file'], true))
        value="{{ $attributes->get('value', old($name)) }}"
    @endif
>
