@php $editing = isset($video) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="title" label="Title" :value="old('title', $editing ? $video->title : '')" maxlength="255" placeholder="Title"
            required></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="desc" label="Desc" :value="old('desc', $editing ? $video->desc : '')" maxlength="255" placeholder="Desc"
            required></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="status" label="Status" :value="old('status', $editing ? $video->status : '')" maxlength="255" placeholder="Status"
            required></x-inputs.text>
    </x-inputs.group>

    {{-- <x-inputs.text type="hidden" name="path" :value="old('path', $editing ? $video->path : '')" maxlength="255"></x-inputs.text> --}}


    <x-inputs.group class="col-sm-12">
        <x-inputs.partials.label name="path" label="Path"></x-inputs.partials.label><br />

        <input type="file" name="path" id="path" class="form-control-file" />

        @if ($editing && $video->path)
            <div class="mt-2">
                <a href="{{ \Storage::url($video->path) }}" target="_blank"><i
                        class="icon ion-md-download"></i>&nbsp;Download</a>
            </div>
        @endif @error('path')
        @include('components.inputs.partials.error')
    @enderror
</x-inputs.group>
</div>
