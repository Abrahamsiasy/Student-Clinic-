@php $editing = isset($room) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="name" label="Name" :value="old('name', $editing ? $room->name : '')" maxlength="255" placeholder="Name"></x-inputs.text>
    </x-inputs.group>

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $room->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group> --}}
{{-- 
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="status"
            label="Status"
            :value="old('status', ($editing ? $room->status : ''))"
            maxlength="255"
            placeholder="Status"
        ></x-inputs.text>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="is_active"
            label="Is Active"
            :value="old('is_active', ($editing ? $room->is_active : ''))"
            maxlength="255"
            placeholder="Is Active"
        ></x-inputs.text>
    </x-inputs.group> --}}

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="clinic_id" label="Clinic">
            @php $selected = old('clinic_id', ($editing ? $room->clinic_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Clinic</option>
            @foreach ($clinics as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
{{-- 
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="encounter_id" label="Encounter">
            @php $selected = old('encounter_id', ($editing ? $room->encounter_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Encounter</option>
            @foreach ($encounters as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}

    {{-- <div class="form-group col-sm-12 mt-4">
        <h4>Assign @lang('crud.clinic_users.name')</h4>

        @foreach ($clinicUsers as $clinicUser)
            <div>
                <x-inputs.checkbox id="clinicUser{{ $clinicUser->id }}" name="clinicUsers[]"
                    label="{{ ucfirst($clinicUser->id) }}" value="{{ $clinicUser->id }}" :checked="isset($room)
                        ? $room
                            ->clinicUsers()
                            ->where('id', $clinicUser->id)
                            ->exists()
                        : false"
                    :add-hidden-value="false"></x-inputs.checkbox>
            </div>
        @endforeach
    </div> --}}
</div>
