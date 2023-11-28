@extends('layouts.app')

@section('content')
<div class="">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('stock-categories.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.stock_categories.show_title')
            </h4>

            <div class="mt-4"></div>

            <div class="mt-4">


                <div class="mb-4">
                    <h5>Name</h5>
                    <span>{{$stockCategory->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>Description</h5>
                    <span>{{ $stockCategory->description ?? '-' }}</span>
                </div>

                @can('create', App\Models\StockCategory::class)
                <a
                    href="{{ route('stock-categories.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    {{-- @can('view-any', App\Models\Stock::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Stocks</h4>

            <livewire:stock-category-stocks-detail
                :stockCategory="$stockCategory"
            />
        </div>
    </div>
    @endcan --}}
</div>
@endsection
