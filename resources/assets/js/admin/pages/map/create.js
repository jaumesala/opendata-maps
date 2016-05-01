SITE.map.create = function(){

    console.log('create');

    var $select = $('.select2');
    $select.each(function(){
        $(this).css('width', '100%').select2( $(this).data('options') );
    });
    // var $oldValues = $select.data('old').toString().split(",");
    // $('.select2').css('width', '100%').select2().val($oldValues).trigger("change");

    $window = $(window);
    $mapView = $('#map-view');
    $controlsView = $('#controls-view');

    $mapView.height($window.height() - 195);
    $controlsView.height($window.height() - 175);

    $window.resize(function() {
        $mapView.height($window.height() - 195);
        $controlsView.height($window.height() - 175);
    });

    // mvCreator.init();
    mapView.editorInit();
}

