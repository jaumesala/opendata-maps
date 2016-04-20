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

    mvEditor.init();
}

/*
|--------------------------------------------------------------------------
| Map View Editor Object
|--------------------------------------------------------------------------
*/

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
        // console.log(sources);

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
            // console.log('Source: '+source.id+' added');
        });
    },

    addChoroplethSource: function(jsonSource, layer){
        mvEditor.map.addSource('choropleth-layer-'+layer.id, {
            'type': 'geojson',
            'data': jsonSource
        });
    },

    getPaintRules: function(layer, rules){
        var paintRules = {};

        if(_.contains(rules, 'dasharray')){

            if(layer['dasharray'].length){
                //convert string to array
                var values = layer['dasharray'].split(',');
                var valuesInt = _.map(values, function(v){ return parseInt(v) });
                paintRules[layer.type+'-dasharray'] = valuesInt;
            }

            //remove property from array
            var index = rules.indexOf('dasharray');
            rules.splice(index, 1);
        }

        //rest of properties
        _.each(rules, function(rule){

            if(rule == 'opacity'){
                paintRules[layer.type+'-opacity'] =  layer.opacity/10;
                return; //continue loop
            }

            if(layer[rule]){
                paintRules[layer.type+'-'+rule] = layer[rule];
            }

        });

        // console.log("Paint rules:", paintRules);

        return paintRules;
    },

    getChoroplethClusters: function(layer, polygonData){
        var clusters = layer['clusters'];
        var schema = (layer['schema-color']) ? layer['schema-color'] : 'YlOrRd';

        // Color scale using chroma.js
        var scale = chroma.scale(schema).colors(clusters);

        // Check if we need to reverse the color schema
        if(layer['schema-reverse']){
            scale.reverse();
        }

        var breaks = turf.jenks(polygonData, "pt_count", clusters-1).reverse();
        // console.log(breaks);
        return _.zip(scale, breaks);
    },

    addLayer: function(layer, paintRules, layoutRules){
        mvEditor.map.addLayer({
            'id': 'layer-'+layer.id,
            'type': layer.type,
            'source': 'source-'+layer.source.id,
            'interactive': layer.interactive ? true : false,
            'paint': paintRules,
            'layout': layoutRules,
            'minzoom': layer.minzoom,
            'maxzoom': layer.maxzoom
        });
        console.log('Layer: layer-'+layer.id+' added');
    },

    addChoroplethLayers: function(colorLayers, layoutRules, layer, beforeLayer){

        var bl = undefined;
        if(typeof beforeLayer !== 'undefined') {
            bl = 'layer-'+beforeLayer.id;
        }

        _.each(colorLayers, function(colorLayer, i) {
            mvEditor.map.addLayer({
                'id': 'layer-' + layer.id + '-choropleth-' + i,
                // 'interactive': true,
                'type': 'fill',
                'source': 'choropleth-layer-'+layer.id,
                // 'source-layer': 'water',
                'paint': {
                    'fill-color': colorLayer[0], // this layer will be painted according to the color in the palet
                    'fill-opacity': layer.opacity/10
                },
                'layout': layoutRules,
                'minzoom': layer.minzoom,
                'maxzoom': layer.maxzoom
            }, bl );
            console.log('Layer: layer-' + layer.id + '-choropleth-' + i +' added');
        });
    },

    filterChoroplethLayers: function(colorLayers, layer){
        _.each(colorLayers, function(colorLayer, i) {
            // filter all the areas "where pt_count is >= current layer value"
            var filters = [
                'all',
                ['>=', 'pt_count', colorLayer[1]] //this is the breakpoint value
            ];

            // as we go down in the palet we have to add a "and < previous layer value"
            if (i !== 0) filters.push(['<', 'pt_count', colorLayers[i - 1][1]]);
            // console.log(filters);

            //finally, we add the filter to the layer
            mvEditor.map.setFilter('layer-' + layer.id + '-choropleth-' + i, filters);
        });
    },

    addHeatmapSource: function(jsonSource, layer){

        mvEditor.map.addSource('heatmap-layer-'+layer.id, {
            'type': 'geojson',
            'data': jsonSource,
            'cluster': true,
            'clusterMaxZoom': 15, // Max zoom to cluster points on
            'clusterRadius': 20 // Use small cluster radius for the heatmap look
        });
    },

    getHeatmapClusters: function(layer, polygonData){
        var clusters = layer['clusters'];
        var schema = (layer['schema-color']) ? layer['schema-color'] : 'YlOrRd';

        // Color scale using chroma.js
        var scale = chroma.scale(schema).colors(clusters);

        // Check if we need to reverse the color schema
        if(layer['schema-reverse']){
            scale.reverse();
        }

        var breaks = turf.jenks(polygonData, "pt_count", clusters-1); //.reverse();
        // console.log(breaks);
        return _.zip(scale, breaks);

    },

    addHeatmapLayers: function(colorLayers, layoutRules, layer, beforeLayer){
        var bl = undefined;
        if(typeof beforeLayer !== 'undefined') {
            bl = 'layer-'+beforeLayer.id;
        }

        colorLayers.forEach(function (colorLayer, i) {

            var filter = i === colorLayers.length - 1 ?
                ['>=', 'point_count', colorLayer[1]] :
                ['all',
                    ['>=', 'point_count', colorLayer[1]],
                    ['<', 'point_count', colorLayers[i + 1][1]]];

            // console.log(filter);

            mvEditor.map.addLayer({
                'id': 'layer-' + layer.id + '-cluster-no',
                'type': 'circle',
                'source': 'heatmap-layer-'+layer.id,
                'paint': {
                    'circle-color': colorLayers[0][0],
                    'circle-radius': layer.radius,
                    'circle-blur': layer.blur
                },
                'filter': ['!=', 'cluster', true]
            }, 'waterway-label');

            mvEditor.map.addLayer({
                'id': 'layer-' + layer.id + '-cluster-' + i,
                'type': 'circle',
                'source': 'heatmap-layer-'+layer.id,
                'paint': {
                    'circle-color': colorLayer[0],
                    'circle-radius': layer.radius,
                    'circle-blur': layer.blur // blur the circles to get a heatmap look
                },
                'filter':  filter
            }, 'waterway-label');



        });

    },

    filterHeatmapLayers: function(){

    },

    addMapLayers: function(){
        // Reverse the order so the first one is the one on the top (as in the editor view)
        layers = map.layers.reverse();
        // console.log(layers);
        // Add each layer synchronously
        _.each(layers, function(layer, layerIndex){

            var paintRules = {};
            var layoutRules = {};
            var layerType = layer.type;

            switch(layerType){
                case 'fill':
                    paintRules = mvEditor.getPaintRules(layer, ['opacity', 'color', 'outline-color']);

                    layoutRules['visibility'] = layer.visible ? 'visible' : 'none';

                    mvEditor.addLayer(layer, paintRules, layoutRules);

                    break;
                case 'line':
                    paintRules = mvEditor.getPaintRules(layer, ['opacity', 'color', 'width', 'gap-width', 'blur', 'dasharray']);

                    layoutRules['visibility'] = layer.visible ? 'visible' : 'none';

                    mvEditor.addLayer(layer, paintRules, layoutRules);

                    break;
                case 'circle':
                    paintRules = mvEditor.getPaintRules(layer, ['opacity', 'color', 'radius', 'blur']);

                    layoutRules['visibility'] = layer.visible ? 'visible' : 'none';

                    mvEditor.addLayer(layer, paintRules, layoutRules);
                    break;
                case 'choropleth':
                    layoutRules['visibility'] = layer.visible ? 'visible' : 'none';

                    //get points source
                    var points = $.getJSON( '/sources/'+layer.source.hash+'.geojson' );
                    // console.log(layer.source);

                    //get polygons source
                    var polygons = $.getJSON( '/sources/'+layer['choropleth-source']+'.geojson');

                    $.when( points, polygons ).done(function( jsonPoints, jsonPolygons ) {

                        // calculates the number of points that fall within each polygon
                        var jsonPolygonsCount = turf.count(jsonPolygons[0], jsonPoints[0], 'pt_count');

                        // choropleth = polygons + count(points within polygon)
                        mvEditor.addChoroplethSource(jsonPolygonsCount, layer);

                        // obtain the color schema and breakpoints of each one.
                        var colorClusters = mvEditor.getChoroplethClusters(layer, jsonPolygonsCount);
                        // console.log(colorClusters);

                        // for each color in the color schema, create a layer
                        // with all the polygons painted with this color.
                        var beforeLayer = layers[layerIndex+1];
                        mvEditor.addChoroplethLayers(colorClusters, layoutRules, layer, beforeLayer);

                        // Once we have the layers we have to filter each layer according to the palet value
                        mvEditor.filterChoroplethLayers(colorClusters, layer);

                    });

                    break;

                case 'heatmap':
                    layoutRules['visibility'] = layer.visible ? 'visible' : 'none';

                    //get points source
                    var points = $.getJSON( '/sources/'+layer.source.hash+'.geojson' );

                    $.when( points ).done(function( jsonPoints ) {

                        // Takes a bounding box and a cell depth and returns a set of square polygons in a grid.
                        var extent = turf.extent(jsonPoints);
                        var cellWidth = 0.2;
                        var units = 'kilometers';
                        var squareGrid = turf.squareGrid(extent, cellWidth, units);

                        // calculates the number of points (complains) that fall within each cell of the grid
                        var squareGridCount = turf.count(squareGrid, jsonPoints, 'pt_count');

                        // add the source with clustering
                        mvEditor.addHeatmapSource(jsonPoints, layer);

                        // obtain the color schema and breakpoints of each one.
                        var colorClusters = mvEditor.getHeatmapClusters(layer, squareGridCount);
                        console.log(colorClusters);

                        // for each color in the color schema create a layer:
                        // one for each cluster category, and one for non-clustered points
                        var beforeLayer = layers[layerIndex+1];
                        mvEditor.addHeatmapLayers(colorClusters, layoutRules, layer, beforeLayer);

                        // // Once we have the layers we have to filter each layer according to the palet value
                        // // mvEditor.filterHeatmapLayers(colorClusters, layer);

                    });



                    break;
            }

        });
    }

}