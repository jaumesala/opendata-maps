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

    $('.layerType').change(function(){
        var value = $(this).val();
        var paintRules = $(this).closest('.box-body').find('.paintRules .form-group');
        filterValues(value, paintRules);
    });
    $('.layerType').trigger('change');

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
        // console.log("getStyles");
        return $.get(  env.settings.mapbox.stylesApiUrl +
                    env.settings.mapbox.username +
                    '?access_token=' + env.settings.mapbox.accessToken, function(data){
                        mvEditor.styles = data;
                        env.settings.maps.defaultStyle = map.style;
                    });

    },

    initStylesSelector: function (){
        // console.log("initStylesSelector");
        for (var key in mvEditor.styles) {
            // skip loop if the property is from prototype
            if (!mvEditor.styles.hasOwnProperty(key)) continue;
            var obj = mvEditor.styles[key];
            $('<option/>').val(obj.id).text(obj.name).data('obj', obj).appendTo($('#style'));
        }

        $('#style').val(map.style).trigger("change");
    },

    initMap: function (){
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

        mvEditor.map.on('style.load', function () {
            console.log("Map Initialized");

            mvEditor.map.addControl(new mapboxgl.Navigation());

            mvEditor.bindControls();
            mvEditor.addMapSources();
            mvEditor.addMapLayers();

        });

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
    },

    addMapSources: function(){

        // get all layer sources
        sources = [];

        _.each(map.layers, function(layer){
            sources.push(layer.source);
        });

        // remove duplicates (multiple layers can use the same source)
        sources = _.uniq(sources, _.property('id'))

        //save into map object
        map.sources = sources;

        // Add each source synchronously
        _.each(map.sources, function(source){
            mvEditor.map.addSource('source-'+source.id, {
                'type': 'geojson',
                'data': '/sources/'+source.hash+'.geojson'
            });
            console.log('Source: '+source.id+' added');
        });

    },

    addMapLayers: function(){
        // Reverse the order so the first one is the one on the top (as in the editor view)
        layers = map.layers.reverse();

        // Add each layer synchronously
        _.each(layers, function(layer){

            var paintRules = {};

            switch(layer.type){
                case 'fill':
                    paintRules['fill-opacity'] =  layer.opacity/10;

                    if(layer['color'])
                        paintRules['fill-color'] = layer['color'];

                    if(layer['outline-color'])
                        paintRules['fill-outline-color'] = layer['outline-color'];

                    break;
                case 'line':
                    paintRules['line-opacity'] = layer.opacity/10;

                    if(layer['color'])
                        paintRules['line-color'] = layer['color'];

                    if(layer['wwidth'])
                        paintRules['line-widht'] = layer['widht'];

                    if(layer['gap-width'])
                        paintRules['line-gap-width'] = layer['gap-width'];

                    if(layer['blur'])
                        paintRules['line-blur'] = layer['blur'];

                    if(layer['dasharray']){
                        var values = layer['dasharray'].split(',');
                        paintRules['line-dasharray'] = [ parseInt(values[0]), parseInt(values[1]) ];
                    }

                    break;
                case 'circle':
                    paintRules['circle-opacity'] = layer.opacity/10;

                    if(layer['color'])
                        paintRules['circle-color'] = layer['color'];

                    if(layer['radius'])
                        paintRules['circle-radius'] = layer['radius'];

                    if(layer['blur'])
                        paintRules['circle-blur'] = layer['blur'];

                    break;
            }
            //opacity
            paintRules[layer.type+'-opacity'] = layer.opacity/10;

            console.log(paintRules);

            layoutRules = new Object();
            layoutRules['visibility'] = layer.visible ? 'visible' : 'none';

            console.log(layoutRules);


            mvEditor.map.addLayer({
                'id': 'layer-'+layer.id,
                'type': layer.type,
                'source': 'source-'+layer.source.id,
                'interactive': layer.interactive ? true : false,
                'paint': paintRules,
                'layout': layoutRules
            });
            console.log('Layer: '+layer.id+' added');
        });

    }

}