@props(['name', 'label', 'type' => 'text'])

@if ($label ?? null)
    @include('components.inputs.partials.label')
@endif

<select id="{{ $name }}" name="{{ $name }}" {{ $required ?? false ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'form-control select2 select2-hidden-accessible2']) }}
    autocomplete="off">{{ $slot }}</select>

@error($name)
    @include('components.inputs.partials.error')
@enderror
