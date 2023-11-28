@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">
                        Product Request Lists
                    </h4>
                </div>

                <div class="searchbar mt-4 mb-5">
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <div class="input-group">
                                    <input id="indexSearch" type="text" name="search"
                                        placeholder="{{ __('crud.common.search') }}" value="{{ $search ?? '' }}"
                                        class="form-control" autocomplete="off" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            @can('create', App\Models\ProductRequest::class)
                                <a href="{{ route('product-requests.create') }}" class="btn btn-primary">
                                    <i class="icon ion-md-add"></i>
                                    @lang('crud.common.create')
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover  table-sm table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">
                                    @lang('crud.product_requests.inputs.product_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.product_requests.inputs.amount')
                                </th>
                                {{-- <th class="text-left">
                                @lang('crud.product_requests.inputs.clinic_id')
                            </th> --}}

                                @can('pharmacy.*')
                                    <th class="text-left">
                                        Store
                                    </th>
                                @endcan


                                @can('store.*')
                                    <th class="text-left">
                                        Pharmacy
                                    </th>
                                @endcan

                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @forelse($productRequests as $productRequest)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        {{ optional($productRequest->product)->name ?? '-' }}
                                    </td>
                                    <td>{{ $productRequest->amount ?? '-' }}</td>
                                    {{-- <td>
                                {{ optional($productRequest->clinic)->name ??
                                '-' }}
                            </td> --}}
                                    {{-- @if (Auth::user()->hasRole(App\Constants::PHARMACY_USER)) --}}
                                    @can('pharmacy.*')
                                        <td>
                                            {{ optional($productRequest->store)->name ?? '-' }}
                                        </td>
                                    @endcan
                                    {{-- @elseif (Auth::user()->hasRole(App\Constants::STORE_USER_ROLE)) --}}
                                    @can('store.*')
                                        <td>

                                            {{ optional($productRequest->pharmacy)->name ?? '-' }}
                                        </td>
                                    @endcan
                                    {{-- @endif --}}
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            {{-- @can('update', $productRequest) --}}
                                            {{-- <a
                                        href="{{ route('product-requests.edit', $productRequest) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a> --}}
                                            {{-- @endcan @can('view', $productRequest) --}}
                                            {{-- <a
                                        href="{{ route('product-requests.show', $productRequest) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a> --}}

                                            @can('store.*')
                                                {{-- <a
                                                    href="{{ route('product-requests.approve', ['productRequest' => $productRequest]) }}">
                                                    <button type="button" class="btn btn-primary">
                                                        Approve
                                                    </button>
                                                </a>


                                                <a
                                                    href="{{ route('product-requests.reject', ['productRequest' => $productRequest]) }}">
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                        Reject
                                                    </button>
                                                </a> --}}
                                                <a href="#" data-toggle="modal" data-target="#approveModal">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">Approve</button>
                                                </a>

                                                <a href="#" data-toggle="modal" data-target="#rejectModal"
                                                    onclick="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    <button type="button" class="btn btn-sm btn-outline-danger mx-1">Reject</button>
                                                </a>

                                                <!-- Approval Modal -->
                                                <div class="modal fade" id="approveModal" tabindex="-1" role="dialog"
                                                    aria-labelledby="approveModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="approveModalLabel">Approve Request
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="GET"
                                                                    action="{{ route('product-requests.approve', ['productRequest' => $productRequest]) }}"
                                                                    id="approveForm">
                                                                    @csrf
                                                                    <label for="approvalAmount">Amount:</label>
                                                                    <input type="number" id="approvalAmount"
                                                                        name="approvalAmount" class="form-control" required
                                                                        max="{{ $productRequest->amount }}">
                                                                    <input type="hidden" name="productRequest_id"
                                                                        value="{{ $productRequest->id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-primary mt-3">Approve</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Rejection Modal -->
                                                <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="rejectModalLabel">Reject Request</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="GET" action="{{ route('product-requests.reject', ['productRequest' => $productRequest]) }}" id="rejectForm">
                                                                    @csrf
                                                                    <label for="reason">Reason:</label>
                                                                    <input type="hidden" name="productRequest_id" value="{{ $productRequest->id }}">
                                                                    <textarea id="reason" name="reason" class="form-control" required></textarea>

                                                                    <button type="submit" class="btn btn-danger mt-3">Reject</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                {{-- <a href="#" wire:click.prevent="rejectProductRequest('{{ $productRequest->id }}')" class="btn btn-danger" onclick="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        Reject
                                    </a> --}}
                                            @endcan

                                            {{-- <form action="{{ route('product-requests.reject', ['product-request'=>$productRequest]) }}"
                                            method="GET"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                Reject
                                            </button>
                                        </form> --}}

                                            @can('pharmacy.*')
                                                <form action="{{ route('product-requests.destroy', $productRequest) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-light text-danger">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endcan

                                            {{-- @endif --}}
                                            {{-- @endcan --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    {!! $productRequests->render() !!}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
