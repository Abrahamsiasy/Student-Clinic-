@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('stores-to-pharmacies.index') }}" class="mr-4"><i
                            class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.stores_to_pharmacies.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>
                            @lang('crud.stores_to_pharmacies.inputs.pharmacy_id')
                        </h5>
                        <span>{{ optional($storesToPharmacy->pharmacy)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.stores_to_pharmacies.inputs.store_id')</h5>
                        <span>{{ optional($storesToPharmacy->store)->name ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('stores-to-pharmacies.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\StoresToPharmacy::class)
                        <a href="{{ route('stores-to-pharmacies.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
