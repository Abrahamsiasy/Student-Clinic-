<div>
    <div class="mb-4">
        @can('create', App\Models\Clinic::class)
            <button class="btn btn-primary" data-toggle="modal" data-target="#clinicUserClinicModal">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.attach')
            </button>
        @endcan
        {{-- @dd($clinicUser) --}}

        <div class="modal fade" id="clinicUserClinicModal" tabindex="-1" role="dialog"
            aria-labelledby="clinicUserClinicModalLabel" aria-hidden="true">
            <form action="{{ route('clinic-change-user-clinic') }}" method="post">
                @csrf
                <div class="modal-dialog" role="document">
                    <!-- Your modal content goes here -->
                    <form action="{{ route('clinic-change-user-clinic') }}" method="post">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $modalTitle }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div>
                                    <div class="col-12">
                                        <label for="clinic_id">Clinic: </label>
                                        <input type="hidden" name="clinic_user_id" value="{{ $clinicUser->id }}" />
                                        <select name="clinic_id" id="clinic_id" class="form-control select2">
                                            <option value="null" disabled>Please select the Clinic</option>
                                            @foreach ($clinicsForSelect as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light float-left" data-dismiss="modal">
                                    <i class="icon ion-md-close"></i>
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="icon ion-md-save"></i>
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </form>
        </div>
    </div>



    <div class="table-responsive">
        <table class="table table-hover  table-sm table-condensed">
            <thead>
                <tr>
                    <th class="text-left">
                        @lang('crud.clinic_user_clinics.inputs.clinic_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            {{-- @dd($clinic_name); --}}
            @if ($clinic_name !== '-')
                <tbody class="text-gray-600">
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">{{ $clinic_name }}</td>
                        <td class="text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('delete-any', App\Models\Clinic::class)
                                    <button class="btn btn-sm btn-outline-danger mx-1"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach('{{ $clinic_id }}')">
                                        <i class="icon ion-md-trash"></i> Delete
                                        {{-- @lang('crud.common.detach') --}}
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                </tbody>
            @endif
            @if ($clinic_name === '-')
                <h2>Please atach clinic to the user </h2>
            @endif
            <tfoot>

            </tfoot>
        </table>
    </div>
</div>
