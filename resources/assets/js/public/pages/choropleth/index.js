SITE.choropleth.index = function(){

    console.log('index');

    mapboxgl.accessToken = 'pk.eyJ1IjoiamF1bWVzYWxhIiwiYSI6ImNpanZ4dmlndDAwNWl2Mm00d3RpY2VweTkifQ.fh0cb8ZJhawwDnZUlZx47Q';
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/jaumesala/cikedqlyp00bbkqlxe7kzopov', //stylesheet location
        center: [4.390819, 51.916960], // starting position
        zoom: 13, // starting zoom
        // pitch: 45, // pitch in degrees
        // bearing: -20, // bearing in degrees
    });



    map.on('style.load', function () {

        console.log("Styles loaded!");

        map.addControl(new mapboxgl.Navigation());

        $.getJSON( 'http://schiedam-map.app/datasets/neighbourhoods.geojson', function(jsonData) {
            var nbh = jsonData;
            // console.log("Hoods",nbh);
            $.getJSON( 'http://schiedam-map.app/datasets/complains.geojson', function(jsonData) {
                var cmp = jsonData;
                // console.log(cmp);

                // calculates the number of points (complains) that fall within each hood
                var counted = turf.count(nbh, cmp, 'pt_count');
                // console.log("Counted:", counted);

                var result = {
                    "type": "FeatureCollection",
                    "features": []
                };

                // generate centroids collection with total points
                _.each(nbh.features, function(feature) {
                   // Calculate centroids
                   var featureWithCentroid = turf.centroid(feature);
                   // copy polygons properties
                   featureWithCentroid.properties = feature.properties;
                   // push the features that cointain its centroids to the featureCollection
                   result.features.push(featureWithCentroid);
                });
                // console.log("centroids:", result);

                // points = centroid(hood) + count(complains in hoods)
                map.addSource('centroidsCount', {
                    'type': 'geojson',
                    'data': result
                });

                // polygons = geometry + count(complains in hoods)
                map.addSource('neighbourhoods', {
                    'type': 'geojson',
                    'data': counted
                });

                // polygons = geometry
                map.addSource('districts', {
                    'type': 'geojson',
                    'data': 'http://schiedam-map.app/datasets/districts.geojson'
                });



                // neighbourhoods fill
                map.addLayer({
                    'id': 'nFill',
                    'type': 'fill',
                    'source': 'neighbourhoods',
                    'interactive': true,
                    'layout': {},
                    'paint': {
                        // 'fill-color': '#000',
                        'fill-opacity': 0,
                    }
                });

                // neighbourhoods hover
                map.addLayer({
                    'id': 'nFill-hover',
                    'type': 'fill',
                    'source': 'neighbourhoods',
                    'layout': {},
                    'paint': {
                        'fill-color': '#930',
                        'fill-opacity': 0.2
                    },
                    'filter': [ 'all',
                        ['==', 'ID', 'NONE' ]
                    ]
                });

                map.on('mousemove', function (e) {
                    // query the map for the under the mouse
                    map.featuresAt(e.point, { radius: 5, layer: 'nFill', includeGeometry: true }, function (err, features) {
                        if (err) throw err
                        // console.log(e.point, features)

                        var ids = features.map(function (feat) { return feat.properties.SLEUTEL })
                        // console.log(ids)

                        // set the filter on the hover style layer to only select the features
                        // currently under the mouse
                        map.setFilter('nFill-hover', [ 'all',
                            [ 'in', 'SLEUTEL' ].concat(ids)
                        ])
                    });
                });

                // Add a label in the middle of each hood using the calculated centroid
                map.addLayer({
                    'id': 'nSymbol',
                    'type': 'symbol',
                    'source': 'centroidsCount',
                    'layout': {
                        'text-field': '{pt_count}'
                    },
                    'paint': {}
                });

                // Add a line to the zones boundaries
                map.addLayer({
                    'id': 'distLine',
                    'type': 'line',
                    'source': 'districts',
                    'layout': {},
                    'paint': {
                        'line-color': '#926ecc',
                        'line-width': 2
                    }
                });

                // Color scale using chroma.js
                var scale = chroma.scale('YlOrBr').colors(7);
                // console.log(scale);
                var breaks = turf.jenks(counted, "pt_count", 6);
                console.log(breaks);

                var layers = _.zip(scale, breaks).reverse();
                console.log(layers);

                // simple color palet
                // var layers = [
                //     ['red', 1000],
                //     ['orange', 500],
                //     ['green', 0]
                // ];

                // for each color in palet, we create a layer with all the hoods.
                layers.forEach(function(layer, i) {
                    map.addLayer({
                        "id": "layer-" + i,
                        "interactive": true,
                        "type": "fill",
                        "source": "neighbourhoods",
                        // "source-layer": "water",
                        "paint": {
                            "fill-color": layer[0], // this layer will be painted according to the color in the palet
                            "fill-opacity": 0.2
                        }
                    });
                });

                // Once we have the layers we have to filter each layer according to the palet value
                layers.forEach(function(layer, i) {
                    // filter all the areas "where pt_count is >= current layer value"
                    var filters = [
                        'all',
                        ['>=', 'pt_count', layer[1]]
                    ];

                    // as we go down in the palet we have to add a "and < previous layer value"
                    //
                    if (i !== 0) filters.push(['<', 'pt_count', layers[i - 1][1]]);
                    // console.log(filters);

                    //the we finally add the filter to the layer
                    map.setFilter('layer-' + i, filters);

                });



            });
        });


    });

}