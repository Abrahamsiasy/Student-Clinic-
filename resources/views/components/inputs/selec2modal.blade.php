@props(['name', 'label', 'options'])

<x-inputs.group class="col-sm-12">
    <label for="{{ $name }}">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-control select2 select2-hidden-accessible']) }} autocomplete="off">
        <option value="null" disabled>-</option>

        @foreach ($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</x-inputs.group>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#{{ $name }}').select2();
        });
    </script>
@endpush
