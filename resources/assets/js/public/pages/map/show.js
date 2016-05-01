SITE.map.show = function(){

    console.log('show');

    mapView.init();

    $('#button-info').click(function(){
        $('#map-info').addClass('show');
    });

    $('#close-panel').click(function(){
        $('#map-info').removeClass('show');
    });

}