@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('stores.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.stores.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.stores.inputs.name')</h5>
                        <span>{{ $store->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.stores.inputs.campus_id')</h5>
                        <span>{{ optional($store->campus)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.stores.inputs.description')</h5>
                        <span>{{ $store->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.stores.inputs.status')</h5>
                        <span>{{ $store->status ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('stores.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Store::class)
                        <a href="{{ route('stores.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        {{-- @can('view-any', App\Models\Product::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Products</h4>

            <livewire:store-products-detail :store="$store" />
        </div>
    </div>
    @endcan @can('view-any', App\Models\StoreUser::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Store Users</h4>

            <livewire:store-store-users-detail :store="$store" />
        </div>
    </div>
    @endcan --}}
    </div>
@endsection
