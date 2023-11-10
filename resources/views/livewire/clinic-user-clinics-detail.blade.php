<div>
    <div class="mb-4">
        @can('create', App\Models\Clinic::class)
            <button class="btn btn-primary" wire:click="newClinic">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.attach')
            </button>
        @endcan
    </div>
    <x-modal id="clinic-user-clinics-modal" wire:model="showingModal">
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
                        <x-inputs.select name="clinic_id" label="Clinic" wire:model="clinic_id">
                            <option value="null" disabled>Please select the Clinic</option>
                            @foreach ($clinicsForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                </div>
            </div>

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
                    <th class="text-left">
                        @lang('crud.clinic_user_clinics.inputs.clinic_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            {{-- @dd($clinic_name); --}}
            <tbody class="text-gray-600">
                <tr class="hover:bg-gray-100">
                    <td class="text-left">{{ $clinic_name  }}</td>
                    <td class="text-right" style="width: 70px;">
                        <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                            @can('delete-any', App\Models\Clinic::class)
                                <button class="btn btn-danger"
                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                    wire:click="detach('{{ $clinic_id }}')">
                                    <i class="icon ion-md-trash"></i> Delete
                                    @lang('crud.common.detach')
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
</div>
