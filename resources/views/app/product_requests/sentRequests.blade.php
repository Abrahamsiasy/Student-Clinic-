@extends('layouts.app')
@push('js')
    <script>
        function getCookie(name) {
            let cookie = {};
            document.cookie.split(';').forEach(function(el) {
                let [key, value] = el.split('=');
                cookie[key.trim()] = value;
            });
            return cookie[name];
        }
        $(function() {
            switch (getCookie('tab')) {
                case "0":
                    $('#ongoing-tabs').toggleClass('show');
                    $('#ongoing-tabs').toggleClass('show');
                    $('#ongoing-tabs').toggleClass('active');
                    $('#ongoing-tab').toggleClass('active');
                    break;
                case "1":
                    $('#approved-tabs').toggleClass('show');
                    $('#approved-tabs').toggleClass('active');
                    $('#approved-tab').toggleClass('active');
                    break;
                case "2":
                    $('#rejected-tabs').toggleClass('show');
                    $('#rejected-tabs').toggleClass('active');
                    $('#rejected-tab').toggleClass('active');
                    break;
                default:
                    $('#ongoing-tabs').toggleClass('show');
                    $('#ongoing-tabs').toggleClass('active');
                    $('#ongoing-tab').toggleClass('active');
                    break;
            }
        })

        function setTabCookie(tab) {
            document.cookie = "tab=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "tab=" + tab + "; path={{ url()->current() }}";
        }
    </script>
    <script></script>
    <script></script>
@endpush
@section('content')
    <div class="">
        <div class="card">

            <div class="card-header p-0 pt-1 border-bottom-0">
                <div class="d-flex justify-content-between">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="schedule-tab" data-toggle="pill" href="#ongoing-tabs"
                                role="tab" aria-controls="custom-tabs-one-tabs" aria-selected="false"
                                onclick="setTabCookie(0)">OnGoing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="schedule-tab" data-toggle="pill" href="#approved-tabs" role="tab"
                                aria-controls="custom-tabs-one-tabs" aria-selected="false"
                                onclick="setTabCookie(1)">Approved Requestes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="on-progress-tab" data-toggle="pill" href="#rejected-tabs" role="tab"
                                onclick="setTabCookie(2)" aria-controls="tabs-on-progress" aria-selected="false">Rejected
                                Requestes</a>
                        </li>


                    </ul>
                </div>
            </div>

            <div class="card-body">


                <div class="tab-content" id="records-of-requested">
                    <div class="tab-pane fade" id="approved-tabs" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">



                        <div style="display: flex; justify-content: space-between;">
                            <h4 class="card-title">
                                Approved Requestes
                            </h4>
                        </div>

                        <div class="searchbar mt-4 mb-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <form>
                                        <div class="input-group">
                                            <input id="indexSearch" type="text" name="searchApproved"
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
                                            Requested Amount
                                        </th>
                                        <th class="text-left">
                                            Approved Amount
                                        </th>

                                        <th class="text-left">
                                            Store
                                        </th>

                                        <th>Approved Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse($ApprovedProductRequests as $ApprovedRequest)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                {{ optional($ApprovedRequest->product)->name ?? '-' }}
                                            </td>
                                            <td>{{ $ApprovedRequest->amount ?? '-' }}</td>
                                            <td>{{ $ApprovedRequest->approval_amount ?? '-' }}</td>
                                            <td>
                                                {{ optional($ApprovedRequest->store)->name ?? '-' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ApprovedRequest->updated_at)->format('d-m-Y') }}
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
                                            {!! $ApprovedProductRequests->render() !!}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="rejected-tabs" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">



                        <div style="display: flex; justify-content: space-between;">
                            <h4 class="card-title">
                                Rejected Requestes
                            </h4>
                        </div>

                        <div class="searchbar mt-4 mb-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <form>
                                        <div class="input-group">
                                            <input id="indexSearch" type="text" name="searchRejected"
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

                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover  table-sm table-condensed">
                                @php
                                    $i = 1;
                                @endphp
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">
                                            @lang('crud.product_requests.inputs.product_id')
                                        </th>
                                        <th class="text-left">
                                           Requested Amount
                                        </th>

                                        <th class="text-left">
                                            Store
                                        </th>
                                        <th class="text-left">
                                            Rejection reason
                                        </th>
                                        <th>Rejection Date</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($RejectedProductRequests as $RejectedRequest)
                                        <tr>
                                            <th>{{ $i++ }}</th>

                                            <td>
                                                {{ optional($RejectedRequest->product)->name ?? '-' }}
                                            </td>
                                            <td>{{ $RejectedRequest->amount ?? '-' }}</td>



                                            <td>
                                                {{ optional($RejectedRequest->store)->name ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $RejectedRequest->reason_of_rejection ?? '-' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $RejectedRequest->updated_at)->format('d-m-Y') }}
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
                                            {!! $RejectedProductRequests->render() !!}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>

                    <div class="tab-pane fade active show" id="ongoing-tabs" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">




                        <div style="display: flex; justify-content: space-between;">
                            <h4 class="card-title">
                                On Going Production Request Lists

                            </h4>
                        </div>

                        <div class="searchbar mt-4 mb-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <form>
                                        <div class="input-group">
                                            <input id="indexSearch" type="text" name="RequestedSearch"
                                                placeholder="{{ __('crud.common.search') }}"
                                                value="{{ $RejectedSearch ?? '' }}" class="form-control"
                                                autocomplete="off" />
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
                                @php
                                    $i = 1;
                                @endphp
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">
                                            @lang('crud.product_requests.inputs.amount')
                                        </th>

                                        <th class="text-left">
                                            @lang('crud.product_requests.inputs.product_id')
                                        </th>

                                        @can('store.*')
                                            <th class="text-left">
                                                Pharmacy
                                            </th>
                                        @endcan
                                        @can('pharmacy.*')
                                            <th class="text-left">
                                                @lang('crud.product_requests.inputs.store_id')
                                            </th>
                                        @endcan
                                        <th class="text-center">
                                            @lang('crud.common.actions')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($RequestedProductRequests as $requestedProductRequest)
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <td>{{ $requestedProductRequest->amount ?? '-' }}</td>
                                            {{-- <td>
                                            {{ optional($productRequest->clinic)->name ??
                                            '-' }}
                                        </td> --}}
                                            <td>
                                                {{ optional($requestedProductRequest->product)->name ?? '-' }}
                                            </td>
                                            {{-- @if (Auth::user()->hasRole(App\Constants::PHARMACY_USER)) --}}
                                            @can('pharmacy.*')
                                                <td>
                                                    {{ optional($requestedProductRequest->store)->name ?? '-' }}
                                                </td>
                                            @endcan
                                            @can('store.*')
                                                {{-- @elseif (Auth::user()->hasRole(App\Constants::STORE_USER_ROLE)) --}}
                                                <td>
                                                    {{ optional($requestedProductRequest->pharmacy)->name ?? '-' }}

                                                </td>
                                            @endcan
                                            {{-- @elseif (Auth::user()->hasRole(App\Constants::STORE_USER_ROLE))
                                            <td>
                                                </td>
                                            @endif --}}
                                            {{-- </td>  --}}
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

                                                    {{-- @endcan @can('delete', $productRequest) --}}
                                                    {{-- @if (Auth::user()->hasRole(App\Constants::PHARMACY_USER)) --}}
                                                    @can('pharmacy.*')
                                                        <form
                                                            action="{{ route('product-requests.destroy', $requestedProductRequest) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger mx-1">
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
                                            {!! $RequestedProductRequests->render() !!}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                    </div>


                </div>


            </div>


        </div>
    </div>
@endsection
