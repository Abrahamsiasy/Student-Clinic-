@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('pharmacies.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.pharmacies.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.pharmacies.inputs.name')</h5>
                        <span>{{ $pharmacy->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.pharmacies.inputs.admin_id')</h5>
                        <span>{{ $pharmacy->admin_id ?? '-' }}</span>
                    </div>
                    {{-- <div class="mb-4">
                    <h5>@lang('crud.pharmacies.inputs.campus_id')</h5>
                    <span>{{ optional($pharmacy->campus)->name ?? '-' }}</span>
                </div> --}}
                    <div class="mb-4">
                        <h5>@lang('crud.pharmacies.inputs.status')</h5>
                        <span>{{ $pharmacy->status ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.pharmacies.inputs.description')</h5>
                        <span>{{ $pharmacy->description ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('pharmacies.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Pharmacy::class)
                        <a href="{{ route('pharmacies.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
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
