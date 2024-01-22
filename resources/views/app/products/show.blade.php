@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('products.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.products.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.products.inputs.name')</h5>
                        <span>{{ $product->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.products.inputs.category_id')</h5>
                        <span>{{ optional($product->category)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.products.inputs.store_id')</h5>
                        <span>{{ optional($product->store)->name ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Product::class)
                        <a href="{{ route('products.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        {{-- @can('view-any', App\Models\Item::class) --}}
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title w-100 mb-2">Items</h4>

                <livewire:product-items-detail :product="$product" />
            </div>
        </div>
        {{-- @endcan --}}
        {{-- @can('view-any', App\Models\ItemRequest::class) --}}
        {{-- <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Item Requests</h4>

            <livewire:product-item-requests-detail :product="$product" />
        </div>
    </div> --}}
        {{-- @endcan --}}
    </div>
@endsection
