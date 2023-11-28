@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('product-requests.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.product_requests.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.product_requests.inputs.amount')</h5>
                        <span>{{ $productRequest->amount ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.product_requests.inputs.clinic_id')</h5>
                        <span>{{ optional($productRequest->clinic)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.product_requests.inputs.product_id')</h5>
                        <span>{{ optional($productRequest->product)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.product_requests.inputs.store_id')</h5>
                        <span>{{ optional($productRequest->store)->name ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('product-requests.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\ProductRequest::class)
                        <a href="{{ route('product-requests.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
