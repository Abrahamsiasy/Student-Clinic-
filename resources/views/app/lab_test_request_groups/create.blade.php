@extends('layouts.app')

@section('content')
<div class="">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a
                    href="{{ route('lab-test-request-groups.index') }}"
                    class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.lab_test_request_groups.create_title')
            </h4>

            <x-form
                method="POST"
                action="{{ route('lab-test-request-groups.store') }}"
                class="mt-4">
                @include('app.lab_test_request_groups.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('lab-test-request-groups.index') }}"
                        class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.create')
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
