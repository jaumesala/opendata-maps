SITE.map.show = function(){

    console.log('show');

    $window = $(window);
    $mapView = $('#map-view');
    $mapView.height($window.height() - 195);
    $window.resize(function() {
        // console.log($contentWrapper.height());
        $mapView.height($window.height() - 195);
    });

    mapView.init();

}