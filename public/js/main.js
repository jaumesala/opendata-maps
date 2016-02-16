/* @preserve 
 *
 * Author:  Jaume Sala
 * Website: jaumesala.net
 *
 */


/* ---------- SITE OBJECT ---------- */

SITE = {
    common: {
        init: function() {
            
        }
    },

    home: {
        init: function() {
            console.log('home');
        }
    },

    neighborhoods: {
        init: function() {
            console.log('neighborhoods');
        }
    }

}



/* ---------------------------------------------------------------------------------------------------- */
UTIL = {
    exec: function(controller, action) {
        var ns = SITE,
            action = (action === undefined) ? "init" : action;

        if (controller !== "" && ns[controller] && typeof ns[controller][action] == "function") {
            ns[controller][action]();
        }
    },

    init: function() {
        var body = document.body,
            controller = body.getAttribute("data-controller"),
            action = body.getAttribute("data-action");

        UTIL.exec("common");
        UTIL.exec(controller);
        UTIL.exec(controller, action);
    }
};
/* ---------------------------------------------------------------------------------------------------- */


//Let's go baby!
$(document).ready(UTIL.init);
SITE.home.index = function(){

    console.log('index');
}
SITE.neighborhoods.index = function(){

	console.log('index');

    mapboxgl.accessToken = 'pk.eyJ1IjoiamF1bWVzYWxhIiwiYSI6ImNpanZ4dmlndDAwNWl2Mm00d3RpY2VweTkifQ.fh0cb8ZJhawwDnZUlZx47Q';
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/jaumesala/cikedqlyp00bbkqlxe7kzopov', //stylesheet location
        center: [4.390819, 51.926960], // starting position
        zoom: 13, // starting zoom
        pitch: 45, // pitch in degrees
        bearing: -20, // bearing in degrees
    });

    map.on('style.load', function () {
        console.log("Styles loaded!");

        map.addSource('neighborhoods', {
            'type': 'geojson',
            'data': 'http://schiedam-map.app/datasets/neighborhoods.geojson'
        });

        

        map.addControl(new mapboxgl.Navigation());

        // neighbourhoods fill
        map.addLayer({
            'id': 'nbhFill',
            'type': 'fill',
            'source': 'neighborhoods',
            'layout': {},
            'interactive': true,
            'paint': {
                'fill-color': '#088',
                'fill-opacity': 0.5,
            },
            'filter': [ 'all', 
                ['==', 'TYPE', 'Buurt' ]
            ]
        });
        // neighbourhoods hover
        map.addLayer({
            'id': 'nbhFill-hover',
            'type': 'fill',
            'source': 'neighborhoods',
            'layout': {},
            'paint': {
                'fill-color': '#930',
                'fill-opacity': 0.5,
            },
            'filter': [ 'all', 
                ['==', 'ID', 'NONE' ]
            ]
        });

        // zones line
        map.addLayer({
            'id': 'nbhLine',
            'type': 'line',
            'source': 'neighborhoods',
            'layout': {},
            'paint': {
                'line-color': '#000'
            }
        });

        // A simple test to add a filter to a already added layer 
        // to show line only in "zones"
        // Buurt = neighbourhood
        // Wijk = zones
        map.setFilter('nbhLine', ["==", "TYPE", "Wijk"]);

        // paint current hover position using "the hover layer"
        map.on('mousemove', function (e) {
            // query the map for the under the mouse
            map.featuresAt(e.point, { radius: 5, layer: 'nbhFill', includeGeometry: true }, function (err, features) {
                if (err) throw err
                // console.log(e.point, features)
                
                var ids = features.map(function (feat) { return feat.properties.ID })
                // console.log(ids)
                
                // set the filter on the hover style layer to only select the features
                // currently under the mouse
                map.setFilter('nbhFill-hover', [ 'all',
                    [ 'in', 'ID' ].concat(ids)
                ])
            });
        });

    });

}
//# sourceMappingURL=main.js.map
