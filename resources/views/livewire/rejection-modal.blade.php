
<div wire:ignore.self class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectionModalLabel">Reason of Rejection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="rejectProductRequest">
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <textarea wire:model="reason" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('openRejectionModal', (productRequest) => {
            $('#rejectionModal').modal('show');
            Livewire.emit('setProductRequest', productRequest);
        });

        Livewire.on('closeRejectionModal', () => {
            $('#rejectionModal').modal('hide');
        });
    </script>
@endpush
