@php $editing = isset($labTestRequest) @endphp

<div class="row">
    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="sample_collected_at"
            label="Sample Collected At"
            value="{{ old('sample_collected_at', ($editing ? optional($labTestRequest->sample_collected_at)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="sample_analyzed_at"
            label="Sample Analyzed At"
            value="{{ old('sample_analyzed_at', ($editing ? optional($labTestRequest->sample_analyzed_at)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="status"
            label="Status"
            :value="old('status', ($editing ? $labTestRequest->status : ''))"
            maxlength="255"
            placeholder="Status"
        ></x-inputs.text>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="notification"
            label="Notification"
            :value="old('notification', ($editing ? $labTestRequest->notification : ''))"
            maxlength="255"
            placeholder="Notification"
        ></x-inputs.text>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="note" label="Note" maxlength="255"
            >{{ old('note', ($editing ? $labTestRequest->note : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group> --}}


    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="sample_id"
            label="Sample Id"
            :value="old('sample_id', ($editing ? $labTestRequest->sample_id : ''))"
            maxlength="255"
            placeholder="Enter sumple ID"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="result" label="Result" maxlength="255"
            >{{ old('result', ($editing ? $labTestRequest->result : ''))
            }}
            </x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="comment" label="Comment" maxlength="255"
            >{{ old('comment', ($editing ? $labTestRequest->comment : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>




    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="analyser_result"
            label="Analyser Result"
            :value="old('analyser_result', ($editing ? $labTestRequest->analyser_result : ''))"
            maxlength="255"
            placeholder="Analyser Result"
        ></x-inputs.text>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="approved_at"
            label="Approved At"
            value="{{ old('approved_at', ($editing ? optional($labTestRequest->approved_at)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group> --}}
{{-- 
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="price"
            label="Price"
            :value="old('price', ($editing ? $labTestRequest->price : ''))"
            max="255"
            step="0.01"
            placeholder="Price"
        ></x-inputs.number>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="sample_id"
            label="Sample Id"
            :value="old('sample_id', ($editing ? $labTestRequest->sample_id : ''))"
            maxlength="255"
            placeholder="Sample Id"
        ></x-inputs.text>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="ordered_on"
            label="Ordered On"
            value="{{ old('ordered_on', ($editing ? optional($labTestRequest->ordered_on)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="lab_test_request_group_id"
            label="Lab Test Request Group"
        >
            @php $selected = old('lab_test_request_group_id', ($editing ? $labTestRequest->lab_test_request_group_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Lab Test Request Group</option>
            @foreach($labTestRequestGroups as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="sample_collected_by_id"
            label="Sample Ccollected By"
        >
            @php $selected = old('sample_collected_by_id', ($editing ? $labTestRequest->sample_collected_by_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Clinic User</option>
            @foreach($clinicUsers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="sample_analyzed_by_id"
            label="Sample Analyzed By"
        >
            @php $selected = old('sample_analyzed_by_id', ($editing ? $labTestRequest->sample_analyzed_by_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Clinic User</option>
            @foreach($clinicUsers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.select name="lab_catagory_id" label="Lab Catagory">
            @php $selected = old('lab_catagory_id', ($editing ? $labTestRequest->lab_catagory_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Lab Catagory</option>
            @foreach($labCatagories as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.select name="approved_by_id" label="Approved By">
            @php $selected = old('approved_by_id', ($editing ? $labTestRequest->approved_by_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Clinic User</option>
            @foreach($clinicUsers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}
</div>
