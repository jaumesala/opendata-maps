SITE.map.show = function(){

    console.log('show');

    $window = $(window);
    $mapView = $('#map-view');
    $mapView.height($window.height() - 195);
    $window.resize(function() {
        // console.log($contentWrapper.height());
        $mapView.height($window.height() - 195);
    });

    mapboxgl.accessToken = 'pk.eyJ1IjoiamF1bWVzYWxhIiwiYSI6ImNpanZ4dmlndDAwNWl2Mm00d3RpY2VweTkifQ.fh0cb8ZJhawwDnZUlZx47Q';
    var map = new mapboxgl.Map({
        container: 'map-view', // container id
        style: 'mapbox://styles/jaumesala/cikedqlyp00bbkqlxe7kzopov', //stylesheet location
        center: [4.390819, 51.926960], // starting position
        zoom: 13, // starting zoom
        pitch: 45, // pitch in degrees
        bearing: -20, // bearing in degrees
    });

    map.on('style.load', function () {
        console.log("Styles loaded!");

        map.addSource('neighbourhoods', {
            'type': 'geojson',
            'data': 'http://schiedam-map.app/datasets/neighbourhoods.geojson'
        });

        map.addSource('districts', {
            'type': 'geojson',
            'data': 'http://schiedam-map.app/datasets/districts.geojson'
        });

        map.addControl(new mapboxgl.Navigation());

        // neighbourhoods fill
        map.addLayer({
            'id': 'nFill',
            'type': 'fill',
            'source': 'neighbourhoods',
            'layout': {},
            'interactive': true,
            'paint': {
                'fill-color': '#088',
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

        // zones line
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

        // A simple test to add a filter to a already added layer
        // to show line only in "zones"
        // Buurt = neighbourhood
        // Wijk = zones
        // map.setFilter('nbhLine', ["==", "TYPE", "Wijk"]);

        // paint current hover position using "the hover layer"
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

    });

}