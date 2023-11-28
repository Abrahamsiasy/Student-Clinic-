@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('stores.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.stores.edit_title')
                </h4>

                <x-form method="PUT" action="{{ route('stores.update', $store) }}" class="mt-4">
                    @include('app.stores.form-inputs')

                    <div class="mt-4">
                        <a href="{{ route('stores.index') }}" class="btn btn-light">
                            <i class="icon ion-md-return-left text-primary"></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('stores.create') }}" class="btn btn-light">
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
