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

    mvCreator.init();

}


mvCreator = {

    elem: null,
    styles: {},
    mv: this,

    init: function(elem){
        // this.elem = elem;
        $.when( mvCreator.getStyles() ).then(function(){
            mvCreator.initStylesSelector();
            mvCreator.initMap();
        });
    },

    getStyles: function (){
        console.log("getStyles");
        return $.get(  env.settings.mapbox.stylesApiUrl +
                    env.settings.mapbox.username +
                    '?access_token=' + env.settings.mapbox.accessToken, function(data){
                        mvCreator.styles = data;
                        env.settings.maps.defaultStyle = data[0]['id'];
                    });

    },

    initStylesSelector: function (){
        console.log("initStylesSelector");
        for (var key in mvCreator.styles) {
            // skip loop if the property is from prototype
            if (!mvCreator.styles.hasOwnProperty(key)) continue;
            var obj = mvCreator.styles[key];
            $('<option/>').val(obj.id).text(obj.name).data('obj', obj).appendTo($('#style'));
        }

        $('#style').trigger("change");
    },

    initMap: function (){
        console.log("initMap");
        mapboxgl.accessToken = env.settings.mapbox.accessToken;

        mvCreator.map = new mapboxgl.Map({
            container: 'map-view', // container id
            style: 'mapbox://styles/'+env.settings.mapbox.username+'/' + env.settings.maps.defaultStyle, //stylesheet location
            center: [env.settings.maps.defaultLongitude, env.settings.maps.defaultLatitude], // starting position
            zoom: env.settings.maps.defaultZoom, // starting zoom
            pitch: 0, //env.settings.maps.defaultPitch, // pitch in degrees
            bearing: env.settings.maps.defaultBearing, // bearing in degrees
            attributionControl: false,
        });

        mvCreator.map.addControl(new mapboxgl.Navigation());

        mvCreator.bindControls();
    },


    bindControls: function(){
        $('#style').on("change", function(){
            // var style = $(this).find(":selected").data('obj');
            mvCreator.map.setStyle('mapbox://styles/'+env.settings.mapbox.username+'/' + $(this).val());
        });

        mvCreator.map.on('move', function(){
            var latLng = mvCreator.map.getCenter();
            $('#latitude, #latitudeDisabled').val(latLng.lat);
            $('#longitude, #longitudeDisabled').val(latLng.lng);
        });

        mvCreator.map.on('zoom', function(){
            var zoom = mvCreator.map.getZoom();
            $('#zoom, #zoomDisabled').val(Math.round(zoom));
        });

        mvCreator.map.on('rotate', function(){
            var bearing = mvCreator.map.getBearing();
            $('#bearing, #bearingDisabled').val(Math.round(bearing));
        });

    }

};

