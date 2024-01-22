@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">


                    <div class="card-body">


                        <section class="content">
                            <div class="container-fluid">

                                <div class="row">


                                    <div class="col-md-9">


                                        <form method="GET" action="">
                                            <div class="row">


                                                <div class="col-md-3">
                                                    <select name="dept" class="form-control select2" required>
                                                        <option value="">Filter by receptions</option>

                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->user->id }}">{{ $user->user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="col-md-3">
                                                    <select name="dept" class="form-control select2" required>
                                                        <option value="">Filter by physician</option>

                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->user->id }}">{{ $user->user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="col-md-3">
                                                    <select name="dept" class="form-control select2" required>
                                                        <option value="">Filter by duration</option>

                                                        <option value="1">Today</option>
                                                        <option value="2">Last week</option>
                                                        <option value="3">Last month</option>
                                                        <option value="4">Last 3 months</option>
                                                        <option value="4">Last 6 months</option>
                                                        <option value="5">Last Year</option>
                                                    </select>

                                                </div>



                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary mx-1">Apply
                                                        Filters</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>




                                </div>
                            </div>


                            <div class="row m-3">
                                <div class="col-md-8 offset-md-2">
                                    <form action="{{ route('encounter-list') }}" method="GET">
                                        <div class="input-group">
                                            <input type="search" class="form-control form-control-lg" id="search"
                                                name="search" placeholder="Enter name or ID">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{--

                            <div class="card-body">
                                <form action="{{ route('encounter-list') }}" method="GET">
                                    <div class="form-group">
                                        <div class="col-md-6 mb-3">
                                            <label for="search">Search by Name or ID:</label>
                                            <input type="text" class="form-control" id="search" name="search"
                                                placeholder="Enter name or ID">
                                        </div>
                                        <div class="input-group-append">

                                            <button type="submit" class="btn btn-sm btn-outline-primary ml-2">
                                                <i class="fa fa-search"></i>Search
                                        </div>
                                    </div>
                                </form>
                            </div> --}}
                        </section>

                        <br><br>
                        <h5>&nbsp;<i class="fa fa-list"> </i> List Patient Visits </h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm table-condensed">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        <th class="text-left">Student ID </th>
                                        <th class="text-left">Patient Name</th>
                                        <th class="text-left">Age </th>
                                        <th class="text-left">Gender</th>
                                        <th class="text-left"> Date of visit </th>
                                        <th class="text-left">Status </th>
                                        <th class="text-left"> Mapped RFID</th>
                                        <th class="text-center">
                                            @lang('crud.common.actions')
                                        </th>
                                    </tr>
                                </thead>



                                <tbody id="encounterTableBody">
                                    @foreach ($encounterLists as $key => $encounter)
                                        <tr>

                                            <td> {{ $key + 1 }}

                                            <td>{{ $encounter->student->id_number ?? '-' }}</td>
                                            <td>{{ $encounter->student?->fullName ?? '-' }}</td>
                                            <td>
                                                @php
                                                    try {
                                                        $age = \Carbon\Carbon::parse($encounter->student->date_of_birth)
                                                            ->diff(\Carbon\Carbon::now())
                                                            ->format('%y years old');
                                                    } catch (\Exception $e) {
                                                        $age = '<span style="color: red;">Error</span>';
                                                    }
                                                    echo $age;
                                                @endphp
                                            </td>
                                            <td>{{ optional($encounter->student)->sex ?? '-' }}</td>

                                            <td>{{ $encounter->created_at->format('M d, Y') }}
                                            </td>
                                            <td>


                                                <span class="badge badge-info">

                                                    @if ($encounter->status == 1)
                                                        <span class="typcn typcn-input-checked-outline"> Checked-in</span>
                                                    @else
                                                        <span class="typcn typcn-input-checked-outline"> Called by Doctor
                                                        </span>
                                                    @endif





                                            </td>
                                            <td>{{ $encounter->student?->rfid ?? '-' }} </td>

                                            <td class="text-right">
                                                <div role="group" aria-label="Row Actions" class="btn-group">




                                                    @can('map-rfid')
                                                        @if ($encounter->student?->rfid === null)
                                                            <form method="post" action="{{ route('map-rfid') }}">
                                                                @csrf
                                                                <input type="hidden" name="student_id"
                                                                    value="{{ $encounter?->student?->id }}">
                                                                <input type="text" required class="form-control-sm"
                                                                    autocomplete="off" name="rfid" placeholder="Enter RFID">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-primary mr-1">
                                                                    <i class="icon fa fa-plus"></i> Map RFID</button>
                                                            </form>
                                                        @else
                                                            <form method="post" action="{{ route('unmap-rfid') }}"
                                                                onsubmit="return confirm('Are you sure to unmap this RFID from the student?');">
                                                                @csrf

                                                                <input hidden name="remove_mapping" value="true">
                                                                <input hidden name="rfid"
                                                                    value="{{ $encounter->student->rfid }}">
                                                                <button class="btn btn-sm btn-outline-primary mx-1"
                                                                    type="submit">
                                                                    <i class="icon fa fa-book"></i> UnMap Rfid</button>
                                                            </form>
                                                        @endif
                                                    @endcan




                                                    @if ($encounter->status == 1)
                                                        @can('delete', $encounter)
                                                            <form data-route="{{ route('encounters.destroy', $encounter) }}"
                                                                method="POST" id="deletebtnid">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger mr-1">
                                                                    <i class="fa fa-user-minus"></i> Uncheck
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    @elseif($encounter->status == 2)
                                                        <form>
                                                            <button type="submit" class="btn btn-sm btn-outline-info mr-1">
                                                                <i class="fa fa-user"></i> In-Process
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-info mr-1">
                                                                <i class="fa fa-user"></i> Closed case
                                                            </button>
                                                        </form>
                                                    @endif


                                                    @can('view', $encounter)
                                                        <a href="{{ route('encounters.show', $encounter) }}">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-primary mr-1">
                                                                <i class=" fa fa-user"></i> Profile
                                                            </button>
                                                        </a>
                                                    @endcan


                                            </td>
                                        </tr>
                                    @endforeach
                        </div>

                        @if ($encounterLists->isEmpty())
                            <tr>
                                <td colspan="12" style="color:red;">
                                    No check-in records today!
                                </td>
                            </tr>
                        @endif

                        </tbody>

                        </table>


                        <div class="float-right" style="text-align: right;">
                            {{ $encounterLists->links() }}
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
