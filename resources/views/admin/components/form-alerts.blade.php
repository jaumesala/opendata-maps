@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Whoops! Something went wrong!</h4>
        <p>Something went wrong while processing your request. Please verify that all the information is correct.</p>
    </div>
@endif

@if(Session::get('status') == "create-success")
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Looks very nice</h4>
        <p>Your data has been saved successfully!</p>
    </div>
@endif

@if(Session::get('status') == "create-error")
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Whoops! Something went wrong!</h4>
        <p>We couldn't save your data. Please verify that all the information is correct and try again.</p>
    </div>
@endif

@if(Session::get('status') == "update-success")
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Looks very nice</h4>
        <p>Your data has been updated successfully!</p>
    </div>
@endif

@if(Session::get('status') == "update-error")
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Whoops! Something went wrong!</h4>
        <p>We couldn't update your data. Please verify that all the information is correct and try again.</p>
    </div>
@endif

@if(Session::get('status') == "destroy-success")
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Looks very nice</h4>
        <p>The data has been deleted successfully!</p>
    </div>
@endif

@if(Session::get('status') == "destroy-error")
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Whoops! Something went wrong!</h4>
        <p>We couldn't delete the data. Please try again.</p>
    </div>
@endif

@if(Session::get('status') == "destroy-refused")
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Operation not allowed!</h4>
        <p>You are not allowed to perform this operation.</p>
    </div>
@endif

@if(Session::get('status') == "sync-success")
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Looks very nice</h4>
        <p>The data has been synced successfully!</p>
    </div>
@endif

@if(Session::get('status') == "sync-error")
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Whoops! Something went wrong!</h4>
        <p>We couldn't sync the data. Please try again.</p>
    </div>
@endif

@if(Session::get('status') == "sync-triggered")
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Ready, set, go!</h4>
        <p>The data has been sent to the sync queue!</p>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
