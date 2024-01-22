<form action="{{route('gate.store')}}" method="post">
    @csrf
    <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create new gate</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputName">Gate Name</label>
                        <input type="text" class="form-control" name="gate_name" id="exampleInputName" placeholder="Enter name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputID">Scanner ID</label>
                        <input type="text" class="form-control" name="scanner_id" id="exampleInputID" placeholder="Enter ScannerID" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputCampus">Campus</label>
                        <select class="form-control" name="campus_id" required>
                            <option value="">Select Campus</option>
                            @foreach ($campuses as $campus)
                                <option value="{{$campus->id}}">{{$campus->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputID">Location</label>
                        <input type="text" class="form-control" name="location" id="exampleInputLocation" placeholder="Enter Location" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
    
        </div>
    
    </div>
</form>

