@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                {{-- @dd($pharmacy) --}}

                @if ($pharmacy === true)
                    <h4 class="card-title">

                        Assign Pharamcy To User {{ $user->name }}
                    </h4>

                    <x-form method="POST" action="{{ route('user.assignPharamacyPlace', ['user' => $user->id]) }}"
                        class="mt-4">
                        {{-- <x-inputs.group class="col-sm-12">
                            <x-inputs.text name="user" label="{{ $user->name }}" :value="old('user')"
                                placeholder="{{ $user->name }}" ></x-inputs.text>
                        </x-inputs.group> --}}


                        <x-inputs.group class="col-sm-12">
                            <x-inputs.select name="pharmacy_id" label="Pharmacy">
                                {{-- @php $selected = old('pharmacy_id', ($editing ? $user->id : '')) @endphp --}}
                                <option>Please select the Pharmacy
                                </option>
                                @foreach ($pharmacies as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}</option>
                                @endforeach
                            </x-inputs.select>
                        </x-inputs.group>


                        <div class="mt-4">


                            <button type="submit" class="btn btn-primary float-right">
                                <i class="icon ion-md-save"></i>
                                Assign
                            </button>
                        </div>
                    </x-form>
                @elseif ($pharmacy === false)
                    <h4 class="card-title">

                        Assign Store To User {{ $user->name }}
                    </h4>

                    <x-form method="POST" action="{{ route('user.assignStorePlace', ['user' => $user->id]) }}" class="mt-4">
                        {{-- <x-inputs.group class="col-sm-12">
                            <x-inputs.text name="user" label="Name" :value="old('user')"
                                placeholder="{{ $user->name }}" ></x-inputs.text>
                        </x-inputs.group> --}}


                        <x-inputs.group class="col-sm-12">
                            <x-inputs.select name="store_id" label="Store">
                                {{-- @php $selected = old('pharmacy_id', ($editing ? $user->id : '')) @endphp --}}
                                <option>Please select the Store</option>
                                @foreach ($stores as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}</option>
                                @endforeach
                            </x-inputs.select>
                        </x-inputs.group>


                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary float-right">
                                <i class="icon ion-md-save"></i>
                                Assign
                            </button>
                        </div>
                    </x-form>
                @endif
            </div>
        </div>
    </div>
@endsection
