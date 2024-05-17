<div class="modal fade" id="editModal{{ $lead->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $lead->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal{{ $lead->id }}">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="taskForm{{ $lead->id }}" class="mt-4" action="{{ route($roleData['roleData']['leads_update'], ['lead'=> $lead->getKey()]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="fullname" class="col-form-label">fullname:</label>
                        <input class="form-control" id="fullname" name="fullname" value="{{$lead->fullname}}">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">phone:</label>
                        <input class="form-control" id="phone" name="phone" value="{{$lead->phone}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-primary">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
