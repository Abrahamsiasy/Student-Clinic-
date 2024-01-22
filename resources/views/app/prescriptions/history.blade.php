@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <div class="d-flex justify-content-between">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="schedule-tab" data-toggle="pill" href="#approved-tabs"
                                role="tab" aria-controls="custom-tabs-one-tabs" aria-selected="true"
                                onclick="setTabCookie(0)">Approved</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="on-progress-tab" data-toggle="pill" href="#rejected-tabs" role="tab"
                                onclick="setTabCookie(1)" aria-controls="tabs-on-progress" aria-selected="false">Rejected
                            </a>
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
                                Approved Prescriptions
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
                                            Student ID
                                        </th>
                                        <th class="text-left">
                                            Student Name
                                        </th>
                                        <th class="text-left">
                                            @lang('crud.prescriptions.inputs.drug_name')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse($prescriptions as $prescription)
                                        <tr>
                                            <td> {{ $i++ }}</td>
                                            <td>{{ $prescription->encounter->student->full_name ?? '-' }}</td>
                                            <td>{{ $prescription->encounter->student->id_number ?? '-' }}</td>
                                            <td>{{ $prescription->drug_name ?? '-' }}</td>


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
                                            {!! $prescriptions->render() !!}
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
                                Rejected Prescriptions
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
                                        <th>#</th>
                                        <th class="text-left">
                                            Student ID
                                        </th>
                                        <th class="text-left">
                                            Student Name
                                        </th>
                                        <th class="text-left">
                                            @lang('crud.prescriptions.inputs.drug_name')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse($rejectedPrescriptions as $prescription)
                                        <tr>
                                            <td> {{ $i++ }}</td>
                                            <td>{{ $prescription->encounter->student->full_name ?? '-' }}</td>
                                            <td>{{ $prescription->encounter->student->id_number ?? '-' }}</td>
                                            <td>{{ $prescription->drug_name ?? '-' }}</td>


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
                                            {!! $rejectedPrescriptions->render() !!}
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
