// Define the extent of the image
 var extent = [8566150.76848, 1232901.87763, 8568107.06848, 1235527.17763];

// Create the static image layer
var imageLayer = new ol.layer.Image({
  source: new ol.source.ImageStatic({
    url: "{{ asset('public/kovai/new/png1.png') }}", // Path to your static image
    imageExtent: extent
  })
});

                    var map = new ol.Map({
                        target: 'map',
                        layers: [
                            new ol.layer.Tile({
                                source: new ol.source.OSM()
                            }), imageLayer, vectorBuildingLayer,
                            vectorLayer
                        ],
                        view: new ol.View({
                            center: ol.extent.getCenter(extent),
                            projection: 'EPSG:3857',
                            zoom: 15
                        })
                    });
