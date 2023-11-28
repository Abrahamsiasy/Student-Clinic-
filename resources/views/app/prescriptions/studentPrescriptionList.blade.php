@extends('layouts.app')

@section('content')
    <div class="">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input id="indexSearch" type="text" name="search" placeholder="{{ __('crud.common.search') }}"
                                value="{{ $search ?? '' }}" class="form-control" autocomplete="off" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon ion-md-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    @can('create', App\Models\Prescription::class)
                        <a href="{{ route('prescriptions.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">
                        @lang('crud.prescriptions.index_title')
                    </h4>
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
                                {{-- <th class="text-left">
                                    @lang('crud.prescriptions.inputs.dose')
                                </th>
                                <th class="text-left">
                                    @lang('crud.prescriptions.inputs.frequency')
                                </th>
                                <th class="text-left">
                                    @lang('crud.prescriptions.inputs.duration')
                                </th>
                                <th class="text-left">
                                    @lang('crud.prescriptions.inputs.other_info')
                                </th>
                                <th class="text-left">
                                    @lang('crud.prescriptions.inputs.main_diagnosis_id')
                                </th> --}}
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prescriptions  as $key =>  $prescription)
                                <tr>

                                    <td> {{ $key + 1 }}
                                    <td>{{ $prescription->encounter->student->full_name ?? '-' }}</td>
                                    <td>{{ $prescription->encounter->student->id_number ?? '-' }}</td>
                                    <td>{{ $prescription->drug_name ?? '-' }}</td>
                                    {{-- <td>{{ $prescription->dose ?? '-' }}</td>
                                    <td>{{ $prescription->frequency ?? '-' }}</td>
                                    <td>{{ $prescription->duration ?? '-' }}</td>
                                    <td>{{ $prescription->other_info ?? '-' }}</td>
                                    <td>
                                        {{ optional($prescription->mainDiagnosis)->id ?? '-' }}
                                    </td> --}}
                                    <td class="text-center">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('pharmacy.prescriptions.view')
                                                <a href="{{ route('prescriptions.show', $prescription) }}">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="icon ion-md-eye"></i> Show
                                                    </button>
                                                </a>
                                            @endcan
                                            @can('pharmacy.prescriptions.view')
                                                <a href="{{ route('prescriptions.approve', $prescription) }}">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">

                                                        Approve
                                                    </button>
                                                </a>
                                            @endcan
                                            @can('pharmacy.prescriptions.view')
                                                <a href="{{ route('prescriptions.reject', $prescription) }}">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        Reject
                                                    </button>
                                                </a>
                                            @endcan

                                            {{-- @can('delete', $prescription)
                                                <form action="{{ route('prescriptions.destroy', $prescription) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger mx-1">
                                                        <i class="icon ion-md-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endcan --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    {!! $prescriptions->render() !!}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
