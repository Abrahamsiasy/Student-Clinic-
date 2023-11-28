@extends('layouts.app')

@section('content')
    <div class="">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-3">
                    <form>
                        <div class="input-group">
                            <select name="dept" class="form-control select2"  required>
                                <option value="">Filter by duration</option>
                             
                                    <option value="1">Today</option>
                                    <option value="2">Last week</option>
                                    <option value="3">Last month</option>
                                    <option value="4">Last 3 months</option>
                                    <option value="4">Last 6 months</option>
                                    <option value="5">Last Year</option>
                            </select>
                        </div>
                        
                    </form>
                </div>

                <div class="col-md-3">
               
                        <div class="input-group">
                            <select name="dept" class="form-control select2"  required>
                                <option value="">Filter by Lab category</option>
                                <option value="0">All categories</option>
                                @foreach($labCategories as $labCategory)
                                
                                <option value="{{ $labCategory->id }}">{{ $labCategory->lab_name }} </option>
                              @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary ml-2">
                                    <i class="icon ion-md-search"></i> Filter
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>


                @php

$closedlabRequests = \App\Models\LabTestRequest::whereNotNull('status')
    ->whereNotNull('result')
    ->get();

               
$labRequests = \App\Models\LabTestRequest::whereNull('status')
                    ->whereNull('result')
                    ->get();
            @endphp 

                {{-- {{ route('lab-test-requests.create') }} --}}
                <div class="col-md-6 text-right">
                    @can('create', App\Models\LabTestRequest::class)
                        <a href="#" class="btn btn-warning">

                            <i class="icon ion-md-list"> </i> List of active lab requests(  {{  $labRequests->count() }} )
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">

                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="false" aria-controls="collapseOne" style="font-size: 15px;">
                            <i class="fa fa-list"> </i> Incoming Lab Test Requests [{{ $labRequests->count() ?? '0'  }}]
                        </button>


                        <button class="btn float-right" data-toggle="collapse" data-target="#collapseOne"><i
                                class="fa fa-angle-down"></i></button>


                    </h5>
                </div>


                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">

                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo" style="font-size: 15px;">
                            <i class="fa fa-list"> </i> Closed Lab Results[ {{ $closedlabRequests->count() ?? '0' }}]
                        </button>


                        <button class="btn float-right" data-toggle="collapse" data-target="#collapseTwo"><i
                                class="fa fa-angle-down"></i></button>


                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="card col-md-12 mb-2"
                                style="border-radius:1%; border-top-color: red !important; border-top-width:2px;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            List of active lab requests
                                            <div class="row justify-content-between">
                                                <div class="col-md-12">

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div style="display: flex; justify-content: space-between;">

                                                            </div>

                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-sm table-condensed">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Student</th>
                                                                            <!-- Other table headers -->
                                                                            <th class="text-left">Lab test</th>
                                                                            <th class="text-left">SampleID</th>
                                                                            <th class="text-left">Result</th>
                                                                            <th class="text-left">Comment</th>
                                                                            <th class="text-right">Price</th>
                                                                            <th class="text-left">Date of requested</th>
                                                                            <th class="text-left">Lab Technician</th>
                                                                            <th class="text-left">Status</th>
                                                                            <th class="text-center">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php $previousStudent = null; @endphp
                                                                        @php $previousDate = null; @endphp
                                                                        @forelse($labTestRequests as $key => $labTestRequest)
                                                                            @if ($previousStudent !== $labTestRequest->encounter->student?->fullName)
                                                                                @php $previousStudent = $labTestRequest->encounter->student?->fullName; @endphp
                                                                                @php $previousDate = null; @endphp


                                                                                @if ($labTestRequest->result === null)
                                                                                    <tr>

                                                                                        <td colspan="18" class="bg-light">

                                                                                            <span class="badge badge-info">
                                                                                                {{ $previousStudent }} -
                                                                                                {{ $labTestRequest->encounter->student?->id_number ?? '' }}</span>


                                                                                        </td>

                                                                                    </tr>
                                                                                @endif
                                                                            @endif
                                                                            @if ($previousDate !== $labTestRequest->created_at->toDateString())
                                                                                @php $previousDate = $labTestRequest->created_at->toDateString(); @endphp
                                                                                @if ($labTestRequest->result === null)
                                                                                    <tr>
                                                                                        <td colspan="18" class="bg-light">
                                                                                            Date: {{ $previousDate }} By<u>
                                                                                                {{ $labTestRequest->encounter->Doctor?->name }}
                                                                                            </u>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endif
                                                                            @if ($labTestRequest->result == null)
                                                                                <tr>
                                                                                    <td>{{ $key + 1 }}</td>
                                                                                    <td></td>
                                                                                    <td>{{ optional($labTestRequest->labTest->labCatagory)->lab_name ?? '-' }}
                                                                                        -
                                                                                        {{ $labTestRequest->labTest->test_name ?? '-' }}
                                                                                    </td>
                                                                                    <td>{{ $labTestRequest->sample_id ?? '?' }}
                                                                                    </td>
                                                                                    <td>{{ $labTestRequest->result ?? '?' }}
                                                                                    </td>
                                                                                    <td>{{ $labTestRequest->comment ?? '?' }}
                                                                                    </td>
                                                                                    <td>{{ $labTestRequest->labTest->price ?? '-' }}
                                                                                    </td>
                                                                                    <td>{{ $labTestRequest->created_at }}
                                                                                    </td>
                                                                                    <td>
                                                                                        {{ optional($labTestRequest->sampleAnalyzedBy)->user?->name ?? '?' }}
                                                                                    </td>
                                                                                    <td>
                                                                                        @if ($labTestRequest->result === null)
                                                                                            <span
                                                                                                class="badge badge-danger">Pending</span>
                                                                                        @else
                                                                                            <span
                                                                                                class="badge badge-success">Closed</span>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <div role="group"
                                                                                            aria-label="Row Actions"
                                                                                            class="btn-group">


                                                                                            @can('update', $labTestRequest)
                                                                                                @if ($labTestRequest->sample_id === null and $labTestRequest->result === null)
                                                                                                    <a
                                                                                                        href="{{ route('lab-test-requests.edit', $labTestRequest) }}">
                                                                                                        <button type="button"
                                                                                                            class="btn btn-sm btn-outline-primary mx-1">
                                                                                                            <i
                                                                                                                class="fa fa-flask"></i>
                                                                                                            Take sample
                                                                                                        </button>
                                                                                                    </a>
                                                                                                @elseif($labTestRequest->sample_id != null and $labTestRequest->result === null)
                                                                                                    <a
                                                                                                        href="{{ route('lab-test-requests.edit', $labTestRequest) }}">
                                                                                                        <button type="button"
                                                                                                            class="btn btn-sm btn-outline-primary mx-1">
                                                                                                            <i
                                                                                                                class="fa fa-flask"></i>
                                                                                                            Add Result
                                                                                                        </button>
                                                                                                    </a>
                                                                                                @else
                                                                                                    <a
                                                                                                        href="{{ route('lab-test-requests.edit', $labTestRequest) }}">
                                                                                                        <button type="button"
                                                                                                            class="btn btn-sm btn-outline-primary mx-1">
                                                                                                            <i
                                                                                                                class="fa fa-flask"></i>
                                                                                                            Edit Result
                                                                                                        </button>
                                                                                                    </a>
                                                                                                @endif
                                                                                            @endcan

                                                                                            {{-- @can('update', $labTestRequest)
                                                                                                <a href="{{ route('lab-test-requests.edit', $labTestRequest) }}">
                                                                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                                                                        <i class="fa fa-plus"></i> Add Result
                                                                                                    </button>
                                                                                                </a>
                                                                                            @endcan --}}
                                                                                            {{-- @can('update', $labTestRequest)
                                                                                                <a href="#">
                                                                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                                                                        <i class="fa fa-upload"></i> Upload
                                                                                                    </button>
                                                                                                </a>
                                                                                            @endcan --}}

                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="18">
                                                                                    @lang('crud.common.no_items_found')
                                                                                </td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="18">
                                                                                {!! $labTestRequests->render() !!}
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="card col-md-12 mb-2"
                                style="border-radius:1%; border-top-color: green !important; border-top-width:2px;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            List of active lab requests
                                            <div class="row justify-content-between">
                                                <div class="col-md-12">


                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-sm table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Student</th>
                                                                    <!-- Other table headers -->
                                                                    <th class="text-left">Lab test</th>
                                                                    <th class="text-left">SampleID</th>
                                                                    <th class="text-left">Result</th>
                                                                    <th class="text-left">Comment</th>
                                                                    <th class="text-right">Price</th>
                                                                    <th class="text-left">Date of requested</th>
                                                                    <th class="text-left">Lab Technician</th>
                                                                    <th class="text-left">Status</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $previousStudent = null; @endphp
                                                                @php $previousDate = null; @endphp
                                                                @forelse($labTestRequests as $key => $labTestRequest)
                                                                    @if ($previousStudent !== $labTestRequest->encounter->student?->fullName)
                                                                        @php $previousStudent = $labTestRequest->encounter->student?->fullName; @endphp
                                                                        @php $previousDate = null; @endphp



                                                                        <tr>
                                                                            @if ($labTestRequest->result != null)
                                                                                <td colspan="18" class="bg-light">

                                                                                    <span class="badge badge-info">
                                                                                        {{ $previousStudent }} -
                                                                                        {{ $labTestRequest->encounter->student?->id_number ?? '' }}</span>


                                                                                </td>
                                                                            @endif
                                                                        </tr>
                                                                    @endif
                                                                    @if ($previousDate !== $labTestRequest->created_at->toDateString())
                                                                        @php $previousDate = $labTestRequest->created_at->toDateString(); @endphp

                                                                        @if ($labTestRequest->result != null)
                                                                            <tr>
                                                                                <td colspan="18" class="bg-light">
                                                                                    Date: {{ $previousDate }} By<u>
                                                                                        {{ $labTestRequest->encounter->Doctor?->name }}
                                                                                    </u>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endif

                                                                    @if ($labTestRequest->result != null)
                                                                        <tr>
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td></td>
                                                                            <td>{{ optional($labTestRequest->labTest->labCatagory)->lab_name ?? '-' }}
                                                                                -
                                                                                {{ $labTestRequest->labTest->test_name ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $labTestRequest->sample_id ?? '?' }}
                                                                            </td>
                                                                            <td>{{ $labTestRequest->result ?? '?' }}</td>
                                                                            <td>{{ $labTestRequest->comment ?? '?' }}</td>
                                                                            <td>{{ $labTestRequest->labTest->price ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $labTestRequest->created_at }}</td>
                                                                            <td>
                                                                                {{ optional($labTestRequest->sampleAnalyzedBy)->user?->name ?? '?' }}
                                                                            </td>
                                                                            <td>
                                                                                @if ($labTestRequest->result === null)
                                                                                    <span
                                                                                        class="badge badge-danger">Pending</span>
                                                                                @else
                                                                                    <span
                                                                                        class="badge badge-success">Closed</span>
                                                                                @endif
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div role="group"
                                                                                    aria-label="Row Actions"
                                                                                    class="btn-group">


                                                                                    @can('update', $labTestRequest)
                                                                                        @if ($labTestRequest->sample_id === null and $labTestRequest->result === null)
                                                                                            <a
                                                                                                href="{{ route('lab-test-requests.edit', $labTestRequest) }}">
                                                                                                <button type="button"
                                                                                                    class="btn btn-sm btn-outline-primary mx-1">
                                                                                                    <i class="fa fa-flask"></i>
                                                                                                    Take sample
                                                                                                </button>
                                                                                            </a>
                                                                                        @elseif($labTestRequest->sample_id != null and $labTestRequest->result === null)
                                                                                            <a
                                                                                                href="{{ route('lab-test-requests.edit', $labTestRequest) }}">
                                                                                                <button type="button"
                                                                                                    class="btn btn-sm btn-outline-primary mx-1">
                                                                                                    <i class="fa fa-flask"></i>
                                                                                                    Add Result
                                                                                                </button>
                                                                                            </a>
                                                                                        @else
                                                                                            <a
                                                                                                href="{{ route('lab-test-requests.edit', $labTestRequest) }}">
                                                                                                <button type="button"
                                                                                                    class="btn btn-sm btn-outline-primary mx-1">
                                                                                                    <i class="fa fa-flask"></i>
                                                                                                    Edit Result
                                                                                                </button>
                                                                                            </a>
                                                                                        @endif
                                                                                    @endcan

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="18">
                                                                            @lang('crud.common.no_items_found')
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="18">
                                                                        {!! $labTestRequests->render() !!}
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
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>




    </div>

@endsection
