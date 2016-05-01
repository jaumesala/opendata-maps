<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Share the map</h4>
            </div>
            <div class="modal-body">
                <p class="lead">Embed the map in a webpage</p>
                <pre>{{ '<iframe width="560" height="480" src="'.route('public.map.show', $map->hash).'?redirect=0" frameborder="0"></iframe>' }}</pre>

                <p class="lead">Share the url</p>
                <pre>{{ route('public.map.show', $map->hash) }}</pre>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>