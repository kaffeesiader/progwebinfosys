/* some global accessible variables */
var ADDSIGHTURL = '/api/sights';
var UNILOCURL = '/api/unilocations';
var UFOSIGHTURL = '/api/sights';
var MAPURL = 'https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png';
var OSMURL = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
var ATTRIBUTION = 'Map data &copy; OpenStreetMap';

/* event handlers */
function showSaveForm(e) {
	$('#sight-form').trigger('reset');
	$('#input-lat').val(e.latlng.lat);
	$('#input-lng').val(e.latlng.lng);
	
	$('#sight-form input, textarea').attr("readonly", false);
	$('.modal-footer').show();
	
	$('#sightFormModal').modal({backdrop: true});
}

function showSight(sight) {
	// disable all inputs
	$('#sight-form input, textarea').attr("readonly", 'readonly');
	// hide save button
	$('.modal-footer').hide();
	
	$('#input-lat').val(sight.latlng.lat);
	$('#input-lon').val(sight.latlng.lng);
	$('#input-who').val(sight.who);
	$('#input-duration').val(sight.duration);
	$('#input-description').val(sight.description);
	$('#input-shape').val(sight.shape);
	$('#input-date').val(sight.sighted_at);
	
	$('#sightFormModal').modal();
}

function onMarkerClick(e) {
	if(!this.sight) {
		var target = UFOSIGHTURL + '/' + this.id;
		$.getJSON(target, function(sight) {
			this.sight = sight;
			console.log('sight data loaded.');
			showSight(sight);
		});	
	} else {
		showSight(this.sight);
	}
}

function saveSight(sightsLayer) {
	var data = {
		"latlng": {lat: $('#input-lat').val(), lng: $('#input-lng').val()},
		"who": $('#input-who').val(),
		"sighted_at": new Date($('#input-date').val()),
		"shape": $('#input-shape').val(),
		"duration": $('#input-duration').val(),
		"description": $('#input-description').val()
	};
	
	$.post(ADDSIGHTURL, JSON.stringify(data), function(saved) {
		var marker = L.marker([saved.latlng.lat, saved.latlng.lng]);
		marker.id = saved._id;
		marker.on('click', onMarkerClick);
		sightsLayer.addLayer(marker);
		console.log("Sight saved");
	}, 'json');
}

function validateSaveForm() {
	if(!$('#input-who').val()) {
		alert("Please enter your name.");
		$('#sight-who').select();
		return false;
	}
	if(!$('#input-date').val()) {
		alert("Please enter the date of the sight.");
		$('#sight-date').select();
		return false;
	}
	if(!$('#input-shape').val()) {
		alert("Please describe the shape of the object.");
		$('#sight-shape').select();
		return false;
	}
	if(!$('#input-duration').val()) {
		alert("Please specify an approximate duration.");
		$('#sight-duration').select();
		return false;
	}
	if(!$('#input-description').val()) {
		alert("Please give a short description of the incident.");
		$('#sight-description').select();
		return false;
	}
	return true;
}

$(document).ready(function() {
	// global ajax configuration
	$.ajaxSetup({
		error: function(x, status, error) {
			console.log("Ajax error: " + error);
			alert("Error[" + x.status + "] during ajax request: " + x.responseText + ", " + error);
		},
		contentType: "application/json; charset=utf-8"
	});
	
	// create the layers
	var mapbox = L.tileLayer(MAPURL, { maxZoom: 18, attribution: ATTRIBUTION, id: 'examples.map-i86knfo3' });
	var osm = L.tileLayer(OSMURL, { maxZoom: 18, attribution: ATTRIBUTION });
	// create the map
	var map = L.map('map', {center: [47.2, 10.89], zoom: 8, layers: [mapbox], });
	// uncomment the following line if you want to center the map based on users current location
	// map.locate({setView: true, maxZoom: 7});
	
	var layerControl = L.control.layers({ "Mapbox": mapbox, "OSM": osm }, []);
	layerControl.addTo(map);
	
	var searchControl = new L.Control.GeoSearch({provider: new L.GeoSearch.Provider.OpenStreetMap()});
	searchControl.addTo(map);
	
	var uniMarkers = new L.MarkerClusterGroup();

	// load the uni locations from the server and create markers
	$.getJSON(UNILOCURL, function(unis) {
		for(var i = 0; i < unis.length; i++) {
			var uni = unis[i];
			var marker = L.marker([uni.lat, uni.lng]).bindPopup(uni.name + '<br>' + uni.address + '<br><a href="' + uni.link + '">' + uni.link + '</a>');
			uniMarkers.addLayer(marker);
		}
		layerControl.addOverlay(uniMarkers, "Unis in Innsbruck");
		uniMarkers.addTo(map);
	});
	
	var sightsLayer = new L.MarkerClusterGroup();
	
	// load the ufo sight locations from the server and create markers
	$.getJSON(UFOSIGHTURL, function(sights) {
		for(var i = 0; i < sights.length; i++) {
			var s = sights[i];
			var marker = L.marker([s.latlng.lat, s.latlng.lng]);
			marker.id = s._id;
			marker.on('click', onMarkerClick);
			sightsLayer.addLayer(marker);
		}
		layerControl.addOverlay(sightsLayer, "Ufo sights");
		sightsLayer.addTo(map);
	});
	
	// make the date input field a JQuery.UI datepicker
	$('#input-date').datepicker();
	
	// some event handling stuffs
	$('#sight-save').click(function(e) {
		if(validateSaveForm()) {
			saveSight(sightsLayer);
		}
		$('#basicModal').modal('hide');
	});

	$('#mnu-sights').click(function() {
		sightsLayer.addTo(map);
	});
	
	$('#mnu-unis').click(function() {
		uniMarkers.addTo(map);
	});
	map.on('click', showSaveForm);
	
});