@extends('layouts.app')

@section('content')
<div class="">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('lab-test-requests.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
              Add Patient laboratory Result below
            </h4>
<br>
            <x-form method="PUT" action="{{ route('lab-test-requests.update', $labTestRequest) }}" class="mt-4">
                @include('app.lab_test_requests.form-inputs')

                <div class="mt-4">
                    <a href="{{ route('lab-test-requests.index') }}" class="btn btn-light" >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    {{-- <a href="{{ route('lab-test-requests.create') }}" class="btn btn-light">
                        <i class="icon ion-md-add text-primary"></i>
                        @lang('crud.common.create')
                    </a> --}}

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        {{-- @lang('crud.common.update') --}}
                        Save
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
