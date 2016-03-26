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

    mapView.init();

}


mapView = {

    elem: null,
    styles: {},
    mv: this,

    init: function(elem){
        // this.elem = elem;
        $.when( mapView.getStyles() ).then(function(){
            mapView.initStylesSelector();
            mapView.initMap();
        });
    },

    getStyles: function (){
        console.log("getStyles");
        return $.get(  env.settings.mapbox.stylesApiUrl +
                    env.settings.mapbox.username +
                    '?access_token=' + env.settings.mapbox.accessToken, function(data){
                        mapView.styles = data;
                        env.settings.maps.defaultStyle = data[0]['id'];
                    });

    },

    initStylesSelector: function (){
        console.log("initStylesSelector");
        for (var key in mapView.styles) {
            // skip loop if the property is from prototype
            if (!mapView.styles.hasOwnProperty(key)) continue;
            var obj = mapView.styles[key];
            $('<option/>').val(obj.id).text(obj.name).data('obj', obj).appendTo($('#style'));
        }

        $('#style').trigger("change");
    },

    initMap: function (){
        console.log("initMap");
        mapboxgl.accessToken = env.settings.mapbox.accessToken;

        mapView.map = new mapboxgl.Map({
            container: 'map-view', // container id
            style: 'mapbox://styles/'+env.settings.mapbox.username+'/' + env.settings.maps.defaultStyle, //stylesheet location
            center: [env.settings.maps.defaultLongitude, env.settings.maps.defaultLatitude], // starting position
            zoom: env.settings.maps.defaultZoom, // starting zoom
            pitch: 0, //env.settings.maps.defaultPitch, // pitch in degrees
            bearing: env.settings.maps.defaultBearing, // bearing in degrees
            attributionControl: false,
        });

        mapView.map.addControl(new mapboxgl.Navigation());

        mapView.bindControls();
    },


    bindControls: function(){
        $('#style').on("change", function(){
            // var style = $(this).find(":selected").data('obj');
            mapView.map.setStyle('mapbox://styles/'+env.settings.mapbox.username+'/' + $(this).val());
        });

        mapView.map.on('move', function(){
            var latLng = mapView.map.getCenter();
            $('#latitude, #latitudeDisabled').val(latLng.lat);
            $('#longitude, #longitudeDisabled').val(latLng.lng);
        });

        mapView.map.on('zoom', function(){
            var zoom = mapView.map.getZoom();
            $('#zoom, #zoomDisabled').val(Math.round(zoom));
        });

        mapView.map.on('rotate', function(){
            var bearing = mapView.map.getBearing();
            $('#bearing, #bearingDisabled').val(Math.round(bearing));
        });

    }

};

