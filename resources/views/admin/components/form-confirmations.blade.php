<div class="modal modal-danger fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteAction">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="#">
                <input name="_method" type="hidden" value="DELETE">
                <input id="id" name="id" type="hidden" value="">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Confirm delete action</h4>
                </div>
                <div class="modal-body">
                    <p>This operation cannot be undone. Would you like to proceed?</p>

                    @if($errors->has("confirmation")) <div class="form-group"> @else <div class="form-group"> @endif
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="confirmation"> Confirm delete
                            </label>
                            @if ($errors->has("confirmation"))
                                <p class="help-block">
                                    {{ $errors->first("confirmation") }}
                                </p>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline">Delete</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>