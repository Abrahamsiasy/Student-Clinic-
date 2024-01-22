@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <div class="d-flex justify-content-between">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="schedule-tab" data-toggle="pill" href="#approved-tabs"
                                role="tab" aria-controls="custom-tabs-one-tabs" aria-selected="false"
                                onclick="setTabCookie(0)">Approved Requestes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="on-progress-tab" data-toggle="pill" href="#rejected-tabs" role="tab"
                                onclick="setTabCookie(1)" aria-controls="tabs-on-progress" aria-selected="false">Rejected
                                Requestes</a>
                        </li>


                    </ul>
                </div>
            </div>
            <div class="card-body">


                <div class="tab-content" id="records-of-requested">
                    <div class="tab-pane fade active show " id="approved-tabs" role="tabpanel"
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
                                        <th class="text-left">
                                            @lang('crud.product_requests.inputs.amount')
                                        </th>

                                        <th class="text-left">
                                            @lang('crud.product_requests.inputs.product_id')
                                        </th>
                                        <th class="text-left">
                                            Pharmacy
                                        </th>

                                        <th>Approved Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ApprovedRequests as $ApprovedRequest)
                                        <tr>
                                            <td>{{ $ApprovedRequest->amount ?? '-' }}</td>
                                            <td>
                                                {{ optional($ApprovedRequest->product)->name ?? '-' }}
                                            </td>
                                            <td>
                                                {{ optional($ApprovedRequest->pharmacy)->name ?? '-' }}
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
                                            {!! $ApprovedRequests->render() !!}
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
                                <thead>
                                    <tr>
                                        <th class="text-left">
                                            @lang('crud.product_requests.inputs.amount')
                                        </th>
                                        {{-- <th class="text-left">
                                        @lang('crud.product_requests.inputs.clinic_id')
                                    </th> --}}
                                        <th class="text-left">
                                            @lang('crud.product_requests.inputs.product_id')
                                        </th>

                                        <th class="text-left">
                                            Pharmacy
                                        </th>
                                        <th>Rejected Date</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($RejectedRequests as $RejectedRequest)
                                        <tr>
                                            <td>{{ $RejectedRequest->amount ?? '-' }}</td>
                                            {{-- <td>
                                        {{ optional($productRequest->clinic)->name ??
                                        '-' }}
                                    </td> --}}
                                            <td>
                                                {{ optional($RejectedRequest->product)->name ?? '-' }}
                                            </td>


                                            <td>
                                                {{ optional($RejectedRequest->pharmacy)->name ?? '-' }}
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
                                            {!! $RejectedRequests->render() !!}
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
