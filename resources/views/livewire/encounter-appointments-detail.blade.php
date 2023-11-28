<div>
    <div class="mb-4">
        @can('create', App\Models\Appointment::class)
            <button class="btn btn-primary" wire:click="newAppointment">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\Appointment::class)
            <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="icon ion-md-trash"></i>
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal id="encounter-appointments-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.datetime name="appointment.a_date" label="A Date" wire:model="appointment.a_date"
                            max="255"></x-inputs.datetime>


                        {{-- <script>
                            $(function() {
                                $('#appointment_a_date').datepicker();
                            });
                        </script> --}}


                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="appointment.reason" label="Reason" wire:model="appointment.reason"
                            maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="appointment.status" label="Status" wire:model="appointment.status"
                            maxlength="255" placeholder="Status"></x-inputs.text>
                    </x-inputs.group>
                    {{-- 
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="appointment.clinic_user_id" label="Doctor"
                            wire:model="appointment.clinic_user_id">
                            <option value="null" disabled>Please select the Clinic User</option>
                            @foreach ($clinicUsersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="appointment.student_id" label="Student"
                            wire:model="appointment.student_id">
                            <option value="null" disabled>Please select the Student</option>
                            @foreach ($studentsForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group> --}}
                </div>
            </div>

            @if ($editing)
            @endif

            <div class="modal-footer">
                <button type="button" class="btn btn-light float-left" wire:click="$toggle('showingModal')">
                    <i class="icon ion-md-close"></i>
                    @lang('crud.common.cancel')
                </button>

                <button type="button" class="btn btn-primary" wire:click="save">
                    <i class="icon ion-md-save"></i>
                    @lang('crud.common.save')
                </button>
            </div>
        </div>
    </x-modal>

    <div class="table-responsive">
        <table class="table table-hover  table-sm table-condensed">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_appointments.inputs.a_date')
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_appointments.inputs.reason')
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_appointments.inputs.status')
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_appointments.inputs.clinic_user_id')
                    </th>
                    <th class="text-left">
                        @lang('crud.encounter_appointments.inputs.student_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($appointments as $appointment)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">
                            <input type="checkbox" value="{{ $appointment->id }}" wire:model="selected" />
                        </td>
                        <td class="text-left">{{ $appointment->a_date ?? '-' }}</td>
                        <td class="text-left">{{ $appointment->reason ?? '-' }}</td>
                        <td class="text-left">{{ $appointment->status ?? '-' }}</td>
                        <td class="text-left">
                            {{ optional($appointment->Doctor)->id ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ optional($appointment->student)->first_name ?? '-' }}
                        </td>
                        <td class="text-right">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $appointment)
                                    <button type="button" class="btn btn-light"
                                        wire:click="editAppointment({{ $appointment->id }})">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">{{ $appointments->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
