SITE.map.edit = function(){

    console.log('edit');

    var $select = $('.select2');
    $select.each(function(){
        $(this).css('width', '100%').select2( $(this).data('options') );
    });

    $window = $(window);
    $mapView = $('#map-view');
    $controlsView = $('#controls-view');

    $mapView.height($window.height() - 195);
    $controlsView.height($window.height() - 175);

    $window.resize(function() {
        $mapView.height($window.height() - 195);
        $controlsView.height($window.height() - 175);
    });

    mvEditor.init();

}



mvEditor = {

    styles: {},
    mv: this,

    init: function(){

        $.when( mvEditor.getStyles() ).then(function(){
            mvEditor.initStylesSelector();
            mvEditor.initMap();
        });
    },

    getStyles: function (){
        console.log("getStyles");
        return $.get(  env.settings.mapbox.stylesApiUrl +
                    env.settings.mapbox.username +
                    '?access_token=' + env.settings.mapbox.accessToken, function(data){
                        mvEditor.styles = data;
                        env.settings.maps.defaultStyle = map.style;
                    });

    },

    initStylesSelector: function (){
        console.log("initStylesSelector");
        for (var key in mvEditor.styles) {
            // skip loop if the property is from prototype
            if (!mvEditor.styles.hasOwnProperty(key)) continue;
            var obj = mvEditor.styles[key];
            $('<option/>').val(obj.id).text(obj.name).data('obj', obj).appendTo($('#style'));
        }

        $('#style').val(map.style).trigger("change");
    },

    initMap: function (){
        console.log("initMap");
        mapboxgl.accessToken = env.settings.mapbox.accessToken;

        mvEditor.map = new mapboxgl.Map({
            container: 'map-view', // container id
            style: 'mapbox://styles/'+env.settings.mapbox.username+'/' + map.style, //stylesheet location
            center: [map.longitude, map.latitude], // starting position
            zoom: map.zoom, // starting zoom
            pitch: 0, //map.Pitch, // pitch in degrees
            bearing: map.bearing, // bearing in degrees
            attributionControl: false,
        });

        mvEditor.map.addControl(new mapboxgl.Navigation());

        mvEditor.bindControls();
    },

    bindControls: function(){
        $('#style').on("change", function(){
            // var style = $(this).find(":selected").data('obj');
            mvEditor.map.setStyle('mapbox://styles/'+env.settings.mapbox.username+'/' + $(this).val());
        });

        mvEditor.map.on('move', function(){
            var latLng = mvEditor.map.getCenter();
            $('#latitude, #latitudeDisabled').val(latLng.lat);
            $('#longitude, #longitudeDisabled').val(latLng.lng);
        });

        mvEditor.map.on('zoom', function(){
            var zoom = mvEditor.map.getZoom();
            $('#zoom, #zoomDisabled').val(Math.round(zoom));
        });

        mvEditor.map.on('rotate', function(){
            var bearing = mvEditor.map.getBearing();
            $('#bearing, #bearingDisabled').val(Math.round(bearing));
        });

    }

}