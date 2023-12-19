@extends('layouts.app')

@section('content')
    <div class="">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input id="indexSearch" type="text" name="search" placeholder="search"
                                value="{{ $search ?? '' }}" class="form-control" autocomplete="off" />
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

        <div class="card">
            <div class="card-header">

                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">Rejected Requests</h4>
                </div>
            </div>



            <div class="card-body">

                @if ($paginator->count() > 0)
                    @foreach ($paginator as $rejected_at => $groupofRequest)
                        @if ($rejected_at == "")
                            @continue
                        @else
                            <div class="card card-outline card-primary collapsed-card">
                                <div class="card-header">
                                    <h3 class="card-title">Rejection Date: {{ $rejected_at }}</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-plus"></i></button>
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
                                                <th>Accepted Amount</th>
                                            </thead>

                                            @foreach ($groupofRequest as $request)
                                                <tr>
                                                    <td>{{ optional($request->productRequest->product)->name ?? '-' }}</td>
                                                    <td>{{ $request->productRequest->pharmacy->name }}</td>
                                                    <td>{{ $request->productRequest->store->name }}</td>
                                                    <td>{{ $request->productRequest->amount }}</td>
                                                    <td>{{ $request->productRequest->approval_amount }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <h3 class=" card-title float-right "> <b>
                                        Rejected By:
                                        </b>
                                         {{ optional($groupofRequest[0]->approvedBy)->name??"-" }}</h3>

                                </div>
                            </div>
                        @endif
                    @endforeach

                    {{ $paginator->links() }}
                @else
                    <div class="alert alert-info">
                        No record
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection
