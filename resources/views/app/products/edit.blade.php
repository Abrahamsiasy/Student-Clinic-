@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('products.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.products.edit_title')
                </h4>

                <x-form method="PUT" action="{{ route('products.update', $product) }}" class="mt-4">
                    @include('app.products.form-inputs')

                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-light">
                            <i class="icon ion-md-return-left text-primary"></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('products.create') }}" class="btn btn-light">
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

        @can('view-any', App\Models\Item::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Items</h4>

                    <livewire:product-items-detail :product="$product" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\ItemRequest::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Item Requests</h4>

                    <livewire:product-item-requests-detail :product="$product" />
                </div>
            </div>
        @endcan
    </div>
@endsection
