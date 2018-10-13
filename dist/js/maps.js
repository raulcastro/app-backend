$(document).ready(function()
{
	$('.update-region').click(function(){
		updateRegion();
	});
});

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 5,
      center: {lat: 24.886, lng: -70.268},
      mapTypeId: 'terrain'
    });

    // Define the LatLng coordinates for the polygon's path.
    var triangleCoords = [
      {lat: 25.774, lng: -80.190},
      {lat: 18.466, lng: -66.118},
      {lat: 32.321, lng: -64.757},
      {lat: 25.774, lng: -80.190}
    ];

    // Construct the polygon.
    var bermudaTriangle = new google.maps.Polygon({
      paths: triangleCoords,
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35
    });
    bermudaTriangle.setMap(map);
}

initialCoords = [];
updatedCoords = [];

//var myPolygon;
function initializeMap(locId) {
	
	$.ajax({
        type:   'POST',
        url:    '/ajax/categories.php',
        data:{  locId: 	locId,
        	option: 		8
             },
        success:
        function(info)
        {
            if (0 != info)
            {
            	obj 	= JSON.parse(info);
            	var pointsNumber = obj.locationInfo.length;
            	if (pointsNumber > 0)
            	{
            		initialCoords.length = 0;
            		
            		for (var i=0; i < obj.locationInfo.length; i++) { 
//            			initialCoords.push({
//            				obj.locationInfo[i].latitude, 
//            				obj.locationInfo[i].longitude
//            				});
            			initialCoords[i] = [Number(obj.locationInfo[i].latitude), Number(obj.locationInfo[i].longitude)];
        			}
            	}
            	else
            	{
            		initialCoords = [
            			[20.650735, -87.051027],
            			[20.669452, -87.079428],
            			[20.630712, -87.104407],
            			[20.615251, -87.104407]
            		];
            	}
            }
        }
    });
	
	//   Map Center
	var myLatLng = new google.maps.LatLng(20.656524, -87.082289);
	// General Options
	var mapOptions = {
		zoom: 12,
		center: myLatLng,
		mapTypeId: google.maps.MapTypeId.RoadMap
	};
	var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
	
	var points=[];
	
	for (var i=0; i<initialCoords.length; i++) { 
	  points.push({
	    lat: initialCoords[i][0],
	    lng: initialCoords[i][1]
	  });
	}
	
	// Polygon Coordinates
//	var triangleCoords = [
//		new google.maps.LatLng(20.650735, -87.051027),
//		new google.maps.LatLng(20.669452, -87.079428),
//		new google.maps.LatLng(20.630712, -87.104407),
//		new google.maps.LatLng(20.615251, -87.085788)
//	];
	// Styling & Controls
	myPolygon = new google.maps.Polygon({
		paths: 			points,
		draggable: 		true, // turn off if it gets annoying
		editable: 		true,
		strokeColor: 	'#FF0000',
		strokeOpacity: 	0.8,
		strokeWeight: 	2,
		fillColor: 		'#FF0000',
		fillOpacity: 	0.35
	});
	
	myPolygon.setMap(map);
	//google.maps.event.addListener(myPolygon, "dragend", getPolygonCoords);
	google.maps.event.addListener(myPolygon.getPath(), "insert_at", getPolygonCoords);
	//google.maps.event.addListener(myPolygon.getPath(), "remove_at", getPolygonCoords);
	google.maps.event.addListener(myPolygon.getPath(), "set_at", getPolygonCoords);
}

//Display Coordinates below map
function getPolygonCoords() {
	
	updatedCoords.length = 0;
	
	var len = myPolygon.getPath().getLength();
	var htmlStr = "";
	for (var i = 0; i < len; i++) {
		htmlStr += "<li>" + myPolygon.getPath().getAt(i).toUrlValue(5) + "</li>";
		
		coordSring 			= myPolygon.getPath().getAt(i).toUrlValue(5);
		locationArray 		= coordSring.split(",");
		companyLatitude 	= locationArray[0];
		companyLongitude	= locationArray[1];
		
		updatedCoords[i] = [companyLatitude, companyLongitude];
		
	    //Use this one instead if you want to get rid of the wrap > new google.maps.LatLng(),
	    //htmlStr += "" + myPolygon.getPath().getAt(i).toUrlValue(5);
	}
	document.getElementById('mapCoords').innerHTML = htmlStr;
}


function updateRegion()
{
	locId 	= $('#currentLocation').val();
	
	if (updatedCoords.length > 0)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/categories.php',
	        data:{  locId: 	locId,
	        	updatedCoords: updatedCoords,
	        	option: 		7
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	alert('La region se ha actualizado');
	            }
	        }
	    });
	}
	
}