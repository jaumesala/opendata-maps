SITE.heatmap.index = function(){

    console.log('index');

    mapboxgl.accessToken = 'pk.eyJ1IjoiamF1bWVzYWxhIiwiYSI6ImNpanZ4dmlndDAwNWl2Mm00d3RpY2VweTkifQ.fh0cb8ZJhawwDnZUlZx47Q';
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/jaumesala/cikedqlyp00bbkqlxe7kzopov', //stylesheet location
        center: [4.390819, 51.916960], // starting position
        zoom: 12, // starting zoom
        pitch: 45, // pitch in degrees
        bearing: -20, // bearing in degrees
    });

    map.on('style.load', function () {

        map.addControl(new mapboxgl.Navigation());

        // map.addSource('neighbourhoods', {
        //     'type': 'geojson',
        //     'data': 'http://schiedam-map.app/datasets/neighbourhoods.geojson'
        // });

        // map.addSource('districts', {
        //     'type': 'geojson',
        //     'data': 'http://schiedam-map.app/datasets/districts.geojson'
        // });

        $.getJSON( 'http://schiedam-map.app/datasets/complains.geojson', function(jsonData) {

                var complains = jsonData;

                // Takes a bounding box and a cell depth and returns a set of square polygons in a grid.
                var extent = [4.335995,51.889074, 4.430752,51.966349];
                var cellWidth = 0.2;
                var units = 'kilometers';
                var squareGrid = turf.squareGrid(extent, cellWidth, units);

                // calculates the number of points (complains) that fall within each cell of the grid
                var counted = turf.count(squareGrid, complains, 'pt_count');

                var pointGrid = {
                    "type": "FeatureCollection",
                    "features": []
                };

                // generate centroids collection with total points
                _.each(squareGrid.features, function(feature) {
                   // Calculate centroids
                   var featureWithCentroid = turf.centroid(feature);
                   // copy polygons properties
                   featureWithCentroid.properties = feature.properties;
                   // push the features that cointain its centroids to the featureCollection
                   pointGrid.features.push(featureWithCentroid);
                });

                console.log(pointGrid);



                map.addSource("complains", {
                    "type": "geojson",
                    "data": complains
                });

                map.addSource('square-grid', {
                    'type': 'geojson',
                    'data': squareGrid
                });

                map.addSource('point-grid', {
                    'type': 'geojson',
                    'data': pointGrid
                });

                // map.addLayer({
                //     "id": "heats",
                //     "type": "circle",
                //     "source": "complains",
                //     "paint": {
                //         "circle-color": "#ff442b",
                //         "circle-opacity" : 0.8,
                //         "circle-radius" : 5,
                //         "circle-blur" : 1
                //     }
                // });

                // // square-grid line
                // map.addLayer({
                //     'id': 'sgLine',
                //     'type': 'line',
                //     'source': 'square-grid',
                //     'layout': {},
                //     'paint': {
                //         'line-color': '#926ecc',
                //         'line-width': 2
                //     }
                // });

                // Color scale using chroma.js
                // var scale = chroma.scale('YlOrRd').colors(5); // ["#ffffcc", "#fed976", "#fd8d3c", "#e31a1c", "#800026"]
                var scale = chroma.scale('RdYlBu').colors(5).reverse(); // ["#a50026", "#f88d52", "#ffffbf", "#8fc3dd", "#313695"]

                console.log(scale);
                var breaks = turf.jenks(pointGrid, "pt_count", 4);
                console.log(breaks);
                var layers = _.zip(scale, breaks);
                console.log(layers);

                // for each color in palet, we create a layer with all the hoods.
                layers.forEach(function(layer, i) {
                    var radius = 50 - 8*i;
                    var opacity = 0.2 + (0.2 * i);
                    console.log(radius, opacity);
                    map.addLayer({
                        "id": "pgCircle-"+i,
                        "type": "circle",
                        "source": "point-grid",
                        "source-layer": "water",
                        "paint": {
                            "circle-color": layer[0],
                            "circle-opacity" : opacity,
                            "circle-radius" : radius,
                            "circle-blur" : 1
                        }
                    });
                });

                // Once we have the layers we have to filter each layer according to the palet value
                layers.forEach(function(layer, i) {
                    // filter all the areas "where pt_count is >= current layer value"
                    var filters = [
                        'all',
                        ['>', 'pt_count', layer[1]]
                    ];

                    // as we go down in the palet we have to add a "and < previous layer value"
                    //
                    // if (i !== 0) filters.push(['<', 'pt_count', layers[i - 1][1]]);
                    console.log(filters);

                    //the we finally add the filter to the layer
                    map.setFilter('pgCircle-' + i, filters);

                });



                // for(var i=5; i>0; i--){
                //     map.addLayer({
                //         "id": "pgCircle-"+i,
                //         "type": "circle",
                //         "source": "point-grid",
                //         "paint": {
                //             "circle-color": "#ff442b",
                //             "circle-opacity" : 0.8,
                //             "circle-radius" : 10*i,
                //             "circle-blur" : 1
                //         }
                //     });
                // }





        });

    });

}