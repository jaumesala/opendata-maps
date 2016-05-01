SITE.complains.index = function(){

	console.log('index');

    mapboxgl.accessToken = 'pk.eyJ1IjoiamF1bWVzYWxhIiwiYSI6ImNpanZ4dmlndDAwNWl2Mm00d3RpY2VweTkifQ.fh0cb8ZJhawwDnZUlZx47Q';
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/jaumesala/cikedqlyp00bbkqlxe7kzopov', //stylesheet location
        center: [4.390819, 51.916960], // starting position
        zoom: 13, // starting zoom
        pitch: 45, // pitch in degrees
        bearing: -20, // bearing in degrees
    });

    map.on('style.load', function () {

        map.addControl(new mapboxgl.Navigation());

        map.addSource('neighbourhoods', {
            'type': 'geojson',
            'data': 'http://schiedam-map.app/datasets/neighbourhoods.geojson'
        });

        map.addSource('districts', {
            'type': 'geojson',
            'data': 'http://schiedam-map.app/datasets/districts.geojson'
        });

        map.addSource("markers", {
            "type": "geojson",
            "data": 'http://schiedam-map.app/datasets/complains.geojson'

            // "data": {
            //     "type": "FeatureCollection",
            //     "features": [
            //     {
            //       "type": "Feature",
            //       "properties": {
            //         "ZAAKNUMMER": "145185",
            //         "ZAAKTYPECODE": "UB.07.04",
            //         "KANAAL": "TELEFOON",
            //         "OMSCHRIJVING": "Verkeers- of straatnaambord/paal; Verkee",
            //         "REGISTRATIEDATUM": "20150401085208",
            //         "STARTDATUM": "20150402",
            //         "EINDDATUM": "20150403",
            //         "GEPLANDE EINDDATUM": "20150409",
            //         "CASE_TYPE_ID": "715",
            //         "NIVEAU1CASE": "Straatmeubilair",
            //         "NIVEAU2CASE": "Verkeers- of straatnaambord/paal",
            //         "NIVEAU3CASE": "Verkeersbord beschadigd/kapot/verdwenen",
            //         "STRAATNAAM": "Harreweg",
            //         "HUISNUMMER": "85",
            //         "POSTCODE": "3123KA",
            //         "BUURTCODE": "99",
            //         "BUURT": "Noordkethelpolder",
            //         "WIJKCODE": "90",
            //         "WIJK": "Woudhoek en Spaland/Sveaparken",
            //         "WOONPLAATS": "Schiedam",
            //         "BAG_STRAATNAAM": "Harreweg",
            //         "PC6_BRON": "melding",
            //         "PC6": "3123KA"
            //       },
            //       "geometry": {
            //         "type": "Point",
            //         "coordinates": [
            //           4.36618616734647,
            //           51.9581790268373
            //         ]
            //       }
            //     }
            //   ]
            // }

        });


        map.addLayer({
            "id": "markers",
            "type": "circle",
            "source": "markers",
            "paint": {
                "circle-radius": 2,
                "circle-color": "#ff442b",
                "circle-opacity": 0.6
            }

            // 'type': 'symbol',
            // 'source': 'markers',
            // 'layout': {
            //     "icon-image": "marker-15",
            //     "text-field": "{ZAAKNUMMER}",
            // },
            // 'paint': {}

        });
    });

}