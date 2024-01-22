@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('stores-to-pharmacies.index') }}" class="mr-4"><i
                            class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.stores_to_pharmacies.edit_title')
                </h4>

                <x-form method="PUT" action="{{ route('stores-to-pharmacies.update', $storesToPharmacy) }}" class="mt-4">
                    @include('app.stores_to_pharmacies.form-inputs')

                    <div class="mt-4">
                        <a href="{{ route('stores-to-pharmacies.index') }}" class="btn btn-light">
                            <i class="icon ion-md-return-left text-primary"></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('stores-to-pharmacies.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add text-primary"></i>
                            @lang('crud.common.create')
                        </a>

                        <button type="submit" class="btn btn-primary float-right">
                            <i class="icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@endsection
