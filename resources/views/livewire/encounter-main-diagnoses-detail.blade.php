<div>
    <div class="mb-4">
        @can('create', App\Models\MainDiagnosis::class)
            <button class="btn btn-primary" wire:click="newMainDiagnosis">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\MainDiagnosis::class)
            <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="icon ion-md-trash"></i> Delete
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal id="encounter-main-diagnoses-modal" wire:model="showingModal">
        <div class="modal-content" style="width: 900px;">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    {{-- <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="mainDiagnosis.clinic_user_id" label="Doctor"
                            wire:model="mainDiagnosis.clinic_user_id">
                            <option value="null" disabled>Please select the Clinic User</option>
                            @foreach ($clinicUsersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group> --}}

                    {{-- <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="mainDiagnosis.student_id" label="Student"
                            wire:model="mainDiagnosis.student_id">
                            <option value="null" disabled>Please select the Student</option>
                            @foreach ($studentsForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group> --}}


                    <x-inputs.group class="col-sm-12">
                        <x-inputs.selecmodal name="mainDiagnosis.diagnosis_id" label="Diagnosis"
                            wire:model="mainDiagnosis.diagnosis_id">
                            <option value="null" disabled>-</option>

                            @foreach ($diagnosesForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.selecmodal>
                    </x-inputs.group>
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
                        @lang('crud.encounter_main_diagnoses.inputs.clinic_user_id')
                    </th>
                    {{-- <th class="text-left">
                        @lang('crud.encounter_main_diagnoses.inputs.student_id')
                    </th> --}}
                    <th class="text-left">
                        @lang('crud.encounter_main_diagnoses.inputs.diagnosis_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($mainDiagnoses as $mainDiagnosis)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">
                            <input type="checkbox" value="{{ $mainDiagnosis->id }}" wire:model="selected" />
                        </td>
                        <td class="text-left">
                            {{ optional($mainDiagnosis->Doctor)?->user->name ?? '-' }}
                        </td>
                        {{-- <td class="text-left">
                            {{ optional($mainDiagnosis->student)->first_name ?? '-' }}
                        </td> --}}
                        <td class="text-left">
                            {{ optional($mainDiagnosis->diagnosis)->name ?? '-' }}
                        </td>
                        <td class="text-right">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $mainDiagnosis)
                                    <button type="button" class="btn btn-light"
                                        wire:click="editMainDiagnosis({{ $mainDiagnosis->id }})">
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
                    <td colspan="4">{{ $mainDiagnoses->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
