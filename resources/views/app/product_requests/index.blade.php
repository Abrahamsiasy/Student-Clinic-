@extends('layouts.app')
@push('scripts')
<script>
    function showAcceptAmountModal(id ) {

        // $('#productRequest_id').val(id);
        // $('#student_id').val(studentId);
        // $('#serialNo').val(pcSerial);
        var p=document.getElementById("productRequest_id_a");
        p.value=id;
        console.log(p.value);
        $('#acceptModal').modal('show');


    }
    function showRejectModal(id ) {

        // $('#productRequest_id').val(id);
        // $('#student_id').val(studentId);
        // $('#serialNo').val(pcSerial);
        var p=document.getElementById("productRequest_id_r");
        p.value=id;
        console.log(p.value);
        $('#rejectModal').modal('show');


    }
</script>
@endpush
@section('content')
    <div class="">
        @if (session()->has('enough'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Attention!</strong> There is no available amount in the store for the given request
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

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
                                <tr id="prpduct{{$i}}">
                                    <td id=>{{ $i++ }}</td>
                                    <td>
                                        {{ optional($productRequest->product)->name ?? '-' }}
                                    </td>
                                    <td>{{ $productRequest->amount ?? '-' }}</td>

                                    @can('pharmacy.*')
                                        <td>
                                            {{ optional($productRequest->store)->name ?? '-' }}
                                        </td>
                                    @endcan

                                    @can('store.*')
                                        <td>

                                            {{ optional($productRequest->pharmacy)->name ?? '-' }}
                                        </td>
                                    @endcan

                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">


                                            @can('store.*')

                                                <a href="#" data-toggle="modal" >
                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1" onclick="

                                                        showAcceptAmountModal({{$productRequest->id}})   ">Approve</button>
                                                </a>

                                                <a href="#" data-toggle="modal"   onclick="showRejectModal({{$productRequest->id}})" >
                                                    <button type="button" class="btn btn-sm btn-outline-danger mx-1">Reject</button>
                                                </a>

                                                <!-- Approval Modal -->
                                                <div class="modal fade" id="acceptModal" tabindex="-1" role="dialog"
                                                    aria-labelledby="acceptModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="acceptModalLabel">Approve Request
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="{{ route('product-requests.approve') }}"
                                                                    id="approveForm">
                                                                    @csrf
                                                                    <label for="approvalAmount">Amount:</label>
                                                                    <input type="hidden" name="productRequest_id_a" id="productRequest_id_a" value="">
                                                                    <input type="number" id="approvalAmount"
                                                                        name="approvalAmount" class="form-control" required
                                                                        {{-- max="{{ $productRequest->amount }}" --}}
                                                                        >

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
                                                                <form method="POST" action="{{ route('product-requests.reject') }}" id="rejectForm">
                                                                    @csrf
                                                                    <input type="hidden" name="productRequest_id_r" id="productRequest_id_r" value="">
                                                                    <label for="reason">Reason:</label>
                                                                    {{-- <input type="hidden" name="productRequest_id"  value="{{ $productRequest->id }}"> --}}
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
