@extends('layouts.app')

@section('content')
    <div class="">
        <div class="searchbar mt-0 mb-4">
            <div class="row">


            </div>
        </div>


        <div class="card">
            <div class="card-header">

                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">Request to be approved</h4>
                </div>
            </div>
            <div class="card-body">


                            @forelse($groupofRequests  as $key =>  $groupofRequest)
                            <div class="card card-outline card-primary collapsed-card">
                                <div class="card-header">
                                <h3 class="card-title">Date: {{$groupofRequest[0]->approved_at}}</h3>
                                <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                </button>
                                </div>

                                </div>

                                <div class="card-body" style="display: none;">

                                    <div class="table-responsive">
                                        <table class="table table-hover  table-sm table-condensed">
                                        <thead>
                                            <th>Product Name</th>
                                            <th>Requesting Pharmacy</th>
                                            <th>Store</th>
                                            <th>Requested Amount</th>
                                            <th>Approved Amount</th>
                                        </thead>

                                        @foreach ($groupofRequest as $request)

                                        <tr>
                                            <td>  {{ optional($request->product)->name ?? '-' }}</td>
                                            <td>{{$request->pharmacy->name}}</td>
                                            <td>{{$request->store->name}}</td>
                                            <td>{{$request->amount}}</td>
                                            <td>{{$request->approval_amount}}</td>
                                        </tr>

                                        @endforeach
                                    </table>
                                </div>

                                <div class="row ml-auto">
                                    <form action="{{ route('request.approve.approve') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="groupofRequest" value="{{ json_encode($groupofRequest) }}">

                                    <button class="btn btn-sm btn-outline-success mx-1">Approve</button>

                                    </form>

                                    <form action="{{ route('request.approve.reject') }}"
                                    method="POST">
                                    <input type="hidden" name="groupofRequest" value="{{ json_encode($groupofRequest) }}">


                                    <button class="btn btn-sm btn-outline-danger mx-1">Reject</button></div>
                                </form>


                                    </div>
                            </div>

                            @empty
                                <tr>
                                    <td colspan="2">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse

            </div>
        </div>
    </div>
@endsection
