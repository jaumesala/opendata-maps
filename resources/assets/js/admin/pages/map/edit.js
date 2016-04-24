SITE.map.edit = function(){

    console.log('edit');

    // Select2 logic
    var $select = $('.select2');
    $select.each(function(){
        $(this).css('width', '100%').select2( $(this).data('options') );
    });

    // Views height logic
    $window = $(window);
    $mapView = $('#map-view');
    $controlsView = $('#controls-view');

    $mapView.height($window.height() - 195);
    $controlsView.height($window.height() - 175);

    $controlsView.find('.tab-content').height($window.height() - 175 - 64);

    $window.resize(function() {
        $mapView.height($window.height() - 195);
        $controlsView.height($window.height() - 175);
    });

    // Layers scroll logic
    $('#tab-layers > .tab-wrapper').slimScroll({
        height: 'auto',
        distance: '2px',
    });

    $('.sublist-wrapper').slimScroll({
        height: '80px',
        distance: '2px',
        size: '3px'
    });

    // Confirm delete (layer) popup
    $('#confirmDelete').on('show.bs.modal', function (event) {
        var button  = $(event.relatedTarget) // Button that triggered the modal
        var action  = button.data('action') // Extract info from data-* attributes
        var id      = button.data('id') // Extract info from data-* attributes

        var modal = $(this)
        modal.find('form').attr('action', action);
        modal.find('input[name=id]').attr('value', id);
    });

    // XSRF config ajax request
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Sort layers
    $('#layers').sortable({
        axis: 'y',
        cursor: 'move',
        placeholder: "sort-highlight",
        handle: ".box-header",
        forcePlaceholderSize: true,
        zIndex: 999999,
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                type: 'POST',
                url: $(this).data('sort-url')
            });
        }
    });

    // init color and layout properties filter
    $('.layerType').change(function(){
        var value = $(this).val();
        var paintRules = $(this).closest('.box-body').find('.paintRules .form-group');
        var layoutRules = $(this).closest('.box-body').find('.layoutRules .form-group');
        filterValues(value, paintRules);
        filterValues(value, layoutRules);
    });

    $('.layerType').trigger('change');

    // init color pickers
    $(".colorpicker").colorpicker({
        format: 'hex',
        colorSelectors: {
            '#000000': '#000000',
            '#ffffff': '#ffffff',
            '#5bc0de': '#5bc0de',
            '#337ab7': '#337ab7',
            '#5cb85c': '#5cb85c',
            '#f0ad4e': '#f0ad4e',
            '#d9534f': '#d9534f'
        }
    });

    // filter properties
    function filterValues(value, list){
        list.each(function(){
            var filter = $(this).data('filter');
            if(filter.indexOf(value) > -1){
                $(this).addClass('show').removeClass('hide');
            } else {
                $(this).addClass('hide').removeClass('show');
            }
        });
    }

    mapView.editorInit('editor');
}
