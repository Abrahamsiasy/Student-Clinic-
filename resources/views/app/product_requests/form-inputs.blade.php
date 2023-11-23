@php $editing = isset($productRequest) @endphp

<div class="row">

        <x-inputs.group class="col-sm-12">
            <x-inputs.select name="store_id" label="Store">
                @php $selected = old('store_id', ($editing ? $productRequest->store_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Store</option>
                @foreach($stores as $s)
                <option value="{{ $s->id }}" {{ $selected == $s->id  ? 'selected' : '' }} >{{ $s->name  }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>
        <x-inputs.group class="col-sm-12">
            <x-inputs.select name="product_id" label="Product">
                @php $selected = old('product_id', ($editing ? $productRequest->product_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Product</option>
                @foreach($products as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', ($editing ? $productRequest->amount : ''))"
            max="1000"
            step="0.01"
            placeholder="Amount"
        ></x-inputs.number>
    </x-inputs.group>

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.select name="clinic_id" label="Clinic">
            @php $selected = old('clinic_id', ($editing ? $productRequest->clinic_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Clinic</option>
            @foreach($clinics as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}

</div>
