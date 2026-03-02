@props(['name'])

@php
    $textareaAttributes = $attributes
        ->except(['value'])
        ->class('textarea')
        ->merge([
            'name' => $name,
        ]);
@endphp

<textarea {{ $textareaAttributes }}>{{ $attributes->get('value', old($name)) }}</textarea>
