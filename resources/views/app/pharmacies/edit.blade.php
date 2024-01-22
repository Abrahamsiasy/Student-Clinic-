@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('pharmacies.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.pharmacies.edit_title')
                </h4>

                <x-form method="PUT" action="{{ route('pharmacies.update', $pharmacy) }}" class="mt-4">
                    @include('app.pharmacies.form-inputs')

                    <div class="mt-4">
                        <a href="{{ route('pharmacies.index') }}" class="btn btn-light">
                            <i class="icon ion-md-return-left text-primary"></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('pharmacies.create') }}" class="btn btn-light">
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

        {{-- @can('view-any', App\Models\ItemRequest::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Item Requests</h4>

            <livewire:pharmacy-item-requests-detail :pharmacy="$pharmacy" />
        </div>
    </div>
    @endcan @can('view-any', App\Models\PharmacyUser::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Pharmacy Users</h4>

            <livewire:pharmacy-pharmacy-users-detail :pharmacy="$pharmacy" />
        </div>
    </div>
    @endcan @can('view-any', App\Models\ItemsInPharmacy::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Items In Pharmacies</h4>

            <livewire:pharmacy-items-in-pharmacies-detail
                :pharmacy="$pharmacy"
            />
        </div>
    </div>
    @endcan --}}
    </div>
@endsection
