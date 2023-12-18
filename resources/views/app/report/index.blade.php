@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="{{ asset('assets/calendar/css/redmond.calendars.picker.css') }}">

    <div class="">
        <div class="searchbar mt-0 mb-4">
            <form action="{{ route('report.show', 0) }}" method="get">
                @csrf
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Start date:</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" required="required" placeholder=""
                                    autocomplete="off" name="sdate" size="3" id="start" />
                            </div>
                            <!-- /.input group -->
                        </div>


                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>End date:</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" required="required" placeholder=""
                                    autocomplete="off" name="edate" size="3" id="endD" />
                            </div>
                            <!-- /.input group -->
                        </div>


                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label> </label>
                            <div class="input-group" style="width:fit-content">
                                <input type="submit" class="form-control btn btn-primary" value="Apply filter" />

                            </div>
                            <!-- /.input group -->
                        </div>


                    </div>

                    <div class="col text-right " style="align-self: self-end">
                        <div class="form-group">
                            <a href="{{ route('opd-report.exportExcel',['startDate' => $startDate,'endDate' => $endDate]) }}" class="btn btn-primary">
                                <i class="far fa-file-excel mr-2"></i> Export to Excel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                {{-- <h3 class="card-title">OPD Service Report</h3> --}}
                <div class="user-block">
                    <h3 class="text-secondary">OPD Service Report</h3>
                    <strong class="description ml-0">
                        <i class="far fa-calendar-alt mr-2"></i>
                        {{$reportDate}}
                    </strong>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover  table-sm table-condensed">
                        <thead>
                            <tr>
                                <th colspan="15" class="text-center">Health Facility Monthly OPD Service Report Form</th>
                            </tr>
                            <tr>
                                <th colspan="15" class="text-center" style="text-align:center;">
                                        Zone ____  Woreda  ___  Name of  Health Facility ___Jumc healt center__Year_______ Month_______  Date ____________
                                </th>
                            </tr>
                            <tr>
                                <th rowspan="2">S.No</th>
                                <th rowspan="2">National classification of Disease(NCoD)</th>
                                <th rowspan="2">Min. NCoD Code</th>
                                <th colspan="6" class="text-center" style="background:#d2d6de">Male</th>
                                <th colspan="6" class="text-center" style="background:#a8c7fa">Female</th>
                            </tr>
                            <tr>
                                <th style="background:#d2d6de">
                                    <1 yr</th>
                                <th style="background:#d2d6de">1-4 yrs</th>
                                <th style="background:#d2d6de">5-14 yrs</th>
                                <th style="background:#d2d6de">15-29 yrs</th>
                                <th style="background:#d2d6de">30-64 yrs</th>
                                <th style="background:#d2d6de">>=65 yrs</th>
                                <th style="background:#a8c7fa">
                                    <1 yr</th>
                                <th style="background:#a8c7fa">1-4 yrs</th>
                                <th style="background:#a8c7fa">5-14 yrs</th>
                                <th style="background:#a8c7fa">15-29 yrs</th>
                                <th style="background:#a8c7fa">30-64 yrs</th>
                                <th style="background:#a8c7fa">>=65 yrs</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($diagnoses as $code => $diagnosisData)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $diagnosisData['code'] }}</td>
                                    <td>{{ $diagnosisData['description'] }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        @if ($diagnosisData['sex_data']['M']['15'])
                                            {{ $diagnosisData['sex_data']['M']['15'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($diagnosisData['sex_data']['M']['30'])
                                            {{ $diagnosisData['sex_data']['M']['30'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($diagnosisData['sex_data']['M']['65'])
                                            {{ $diagnosisData['sex_data']['M']['65'] }}
                                        @endif
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        @if ($diagnosisData['sex_data']['F']['15'])
                                            {{ $diagnosisData['sex_data']['F']['15'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($diagnosisData['sex_data']['F']['30'])
                                            {{ $diagnosisData['sex_data']['F']['30'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($diagnosisData['sex_data']['F']['65'])
                                            {{ $diagnosisData['sex_data']['F']['65'] }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src=" {{ asset('assets/calendar/js/jquery.plugin.js') }}"></script>
    <script src=" {{ asset('assets/calendar/js/jquery.calendars.js') }}"></script>
    <script src=" {{ asset('assets/calendar/js/jquery.calendars.plus.js') }}"></script>
    <script src=" {{ asset('assets/calendar/js/jquery.calendars.picker.js') }}"></script>
    <script src=" {{ asset('assets/calendar/js/jquery.calendars.ethiopian.js') }}"></script>
    <script src=" {{ asset('assets/calendar/js/jquery.calendars.ethiopian-am.js') }}"></script>
    <script src=" {{ asset('assets/calendar/js/jquery.calendars.picker-am.js') }}"></script>

    <script>
        $(function() {
            var calendar = $.calendars.instance('ethiopian', 'am');
            $('#start').calendarsPicker({
                calendar: calendar
            });
            $('#endD').calendarsPicker({
                calendar: calendar
            });
        });
    </script>
@endsection
