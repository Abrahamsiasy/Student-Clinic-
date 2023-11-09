@php $editing = isset($clinicUser) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $clinicUser->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach ($users as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.select name="encounter_id" label="Encounter" required>
            @php $selected = old('encounter_id', ($editing ? $clinicUser->encounter_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Encounter</option>
            @foreach ($encounters as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}

    {{-- <div class="form-group col-sm-12 mt-4">
        <h4>Assign @lang('crud.clinics.name')</h4>

        @foreach ($clinics as $clinic)
        <div>
            <x-inputs.checkbox
                id="clinic{{ $clinic->id }}"
                name="clinics[]"
                label="{{ ucfirst($clinic->name) }}"
                value="{{ $clinic->id }}"
                :checked="isset($clinicUser) ? $clinicUser->clinics()->where('id', $clinic->id)->exists() : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div> --}}
    {{-- <div class="form-group col-sm-12 mt-4">
        <h4>Assign @lang('crud.rooms.name')</h4>

        @foreach ($rooms as $room)
            <div>
                <x-inputs.checkbox id="room{{ $room->id }}" name="rooms[]" label="{{ ucfirst($room->name) }}"
                    value="{{ $room->id }}" :checked="isset($clinicUser)
                        ? $clinicUser
                            ->rooms()
                            ->where('id', $room->id)
                            ->exists()
                        : false" :add-hidden-value="false"></x-inputs.checkbox>
            </div>
        @endforeach
    </div> --}}
</div>
