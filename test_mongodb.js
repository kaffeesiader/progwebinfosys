/**
 * 
 */

var mongojs = require('mongojs');
var db = mongojs('maps', ['sights', 'locations']);
var http = require('http');
var qs = require('querystring');


function getLocationInfo(latlng, callback) {
	
	var path = '/maps/api/geocode/json?latlng=' + latlng.lat + ',' + latlng.lng + '&sensor=false';
	console.log("Executing location request...");
	var options = {
		host : 'maps.googleapis.com',
		port : '80',
		path : path,
		method : 'GET',
	};
	// holds the result of the location request
	var result = {};

	http.get(options, function(res) {
		console.log("Got response: " + res.statusCode);
		var body = '';
	
		res.on('data', function(data) {
			body += data;
		});
		
		res.on('end', function() {
			var info = JSON.parse(body);
			if((info.status === 'OK') && (info.results.length > 0)) {
				var best = info.results[0];
				result.location = {
					address: best.formatted_address,
					address_latlng: best.geometry.location,
					latlng: latlng,
				};
				result.status = 'OK';
			} else {
				result.location = {
					address: 'Unknown address',
					address_latlng: latlng,
					latlng: latlng,
				};
				result.status = 'OK';
			}
			callback(result);
		});
	}).on('error', function(e) {
		console.log("Got error: " + e.message);
		result.status = 'FAILED';
		callback(result);
	});
}


function getLocationInfo(address, callback) {
	
	var path = '/maps/api/geocode/json?address=' + qs.escape(address) + '&sensor=false';
//	console.log("Executing location request..." + path);
	
	var options = {
		host : 'maps.googleapis.com',
		port : '80',
		path : path,
		method : 'GET',
	};
	// holds the result of the location request
	var result = {};

	http.get(options, function(res) {
//		console.log("Got response: " + res.statusCode);
		var body = '';
		res.on('data', function(data) {	body += data;});
		res.on('end', function() {
			var info = JSON.parse(body);
			if((info.status === 'OK') && (info.results.length > 0)) {
				result.location = info.results[0].geometry.location;
				result.success = true;
			} else {
				console.log("Status: " + info.status);
				result.success = false;
			}
			callback(result);
		});
	}).on('error', function(e) {
		console.log("Got error: " + e.message);
		result.success = false;
		callback(result);
	});
}

//getLocationInfo(" Redmond, WA", console.log);

db.sights.distinct('location', function(e, values) {
	if(!e) {
		var n = values.length;
		console.log("Database contains " + n + " different locations.");
		var arr = values.slice(0, 5).map(function(value) { return value.trim(); });
		arr.forEach(function(address) {
			getLocationInfo(address, function(result) {
				if(!result.success) {
					console.log("Failed to localize address '" + address + "'");
				}
			});
		});
//		for(var i = 0; i < 20; i++) {
//			var address = values[i].trim();
//			console.log(address);
//			getLocationInfo(address, function(result) {
//				if(!result.success) {
//					console.log("Failed to localize address '" + address + "'");
//				}
//			});
//		}
	}
});

//db.sights.distinct('location', function(e, l) {
//	console.log(l.length);
//});
//
//db.sights.find({
//	location_id: id
//}, function(err, sight) {
//	if (err || !sight)
//		console.log("No sight found");
//	else
//		sight.forEach(function(s) {
//			console.log(s);
//		});
//});
