/**
 * Server side module for the maps application
 */


var mongojs = require('mongojs');
var db = mongojs('maps', ['sights', 'unilocations']);

exports.startServer = function(app) {
	console.log("Lauching maps application server");
	
	app.get('/api/unilocations', function(request, response) {
		db.unilocations.find({}, function(error, documents){
			if(error){
				console.log(error);
				response.send(500, {error: error});
			} else{
				response.json(documents);
			}
		});
	});

	// only return the sight's location and id to avoid to send too much data
	app.get('/api/sights', function(req, res) {
		db.sights.find({}, { latlng: 1 }, function(error, locations){
			if(error){
				console.log(error);
				res.send(500, {error: error});
			} else{
				res.json(locations);
			}
		});
	});

	app.get('/api/sights/:id', function(req, res) {
		console.log('GET sight with id ' + req.params.id);
		var id = mongojs.ObjectId(req.params.id);
		db.sights.findOne({_id: id}, function(error, match) {
			if(error) {
				console.log(error);
				res.send(500, {error: error});
			} else {
				if(match) {
					res.json(match);
				} else {
					res.send(404, "No matching document found!");
				}
			}
		});
	});

	app.post('/api/sights', function(req, res) {
		var sight = req.body;
		if(sight) {
			if(!sight.name) {
				sight.name = "ANONYMOUS";
			}
			sight.reported_at = new Date();
			sight.sighted_at = new Date(sight.sighted_at);
			db.sights.save(sight, function(err, saved) {
				if(err) {
					console.log('Error saving sight: ' +  err);
					res.send(500, {error: err});
				} else {
					console.log('Sight saved!');
					res.json(saved);
				}
			});
		}
	});
};