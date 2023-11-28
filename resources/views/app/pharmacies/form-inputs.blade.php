@php $editing = isset($pharmacy) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Pharmacy Name"
            :value="old('name', ($editing ? $pharmacy->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">

        <x-inputs.select name="admin_id" label="Admin" required>
            @php $selected = old('admin_id', ($editing ? $pharmacy->admin_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Admin</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>


    </x-inputs.group>

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.select name="campus_id" label="Campus" required>
            @php $selected = old('campus_id', ($editing ? $pharmacy->campus_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Campus</option>
            @foreach($campuses as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="clinic_id" label="Clinic" required>
            @php $selected = old('clinic_id', ($editing ? $pharmacy->clinic_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Clinic </option>
            @foreach($clinics as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="store_id" label="Store" required>
            @php $selected = old('store_id', ($editing ? $pharmacy->store_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Store </option>
            @foreach($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="status"
            label="Status"
            :checked="old('status', ($editing ? $pharmacy->status : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $pharmacy->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
