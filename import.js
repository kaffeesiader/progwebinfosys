/**
 * 
 */

var mongoose = require('mongoose');

mongoose.connect('mongodb://localhost/maps', function(error){
	if(error){
		console.log(error);
	} else{
		console.log('Connected to mongodb!');
		//createCollection(); // call this function only once to create the collection in db test!!!
	}
});

var schema = mongoose.Schema({
	name: String,
	address: String,
	link: String,
	lng: Number,
	lat: Number
});

var Unilocation = mongoose.model('unilocations', schema);


// call this function only once to create the db!
// collection will have the name "Unilocations"
function createCollection(){
	new Unilocation({
		name: 'Medzinische Universität',
		address: 'Innrain 52',
		link: 'http://www.i-med.ac.at',
		lng: 11.384639250000101,
		lat: 47.263178326999999
	}).save(function(error){if(error) throw error});
	new Unilocation({
		name: 'Universitätsbibliothek - Landesbibliothek',
		address: 'Innrain 50',
		link: 'http://www.uibk.ac.at/ulb/',
		lng: 11.385603041000101,
		lat: 47.263680170999997
	}).save(function(error){if(error) throw error});
	new Unilocation({
		name: 'Universität - Theologie',
		address: 'Karl-Rahner-Platz 1-3',
		link: 'http://www.uibk.ac.at',
		lng: 11.397502239000101,
		lat: 47.268575086000098
	}).save(function(error){if(error) throw error});
	new Unilocation({
		name: 'Universität',
		address: 'Innrain 52',
		link: 'http://www.uibk.ac.at',
		lng: 11.384355666000101,
		lat: 47.263062877000003
	}).save(function(error){if(error) throw error});
	new Unilocation({
		name: 'Universität - SOWI',
		address: 'Universitätsstraße 15',
		link: 'http://www.uibk.ac.at',
		lng: 11.398797304000100,
		lat: 47.269911301000000
	}).save(function(error){if(error) throw error});
	new Unilocation({
		name: 'OeH - HochschülerInnenschaft',
		address: 'Josef-Hirn-Straße 5-7',
		link: 'http://www.oehweb.at/',
		lng: 11.386427342999999,
		lat: 47.265096499000002
	}).save(function(error){if(error) throw error});	
	new Unilocation({
		name: 'Universität - Chemie, Pharmazie',
		address: 'Innrain 80-82',
		link: 'http://www.uibk.ac.at',
		lng: 11.381361813000099,
		lat: 47.260095664000097
	}).save(function(error){if(error) throw error});
	new Unilocation({
		name: 'Universität - Zentrum für alte Kulturen',
		address: 'Langer Weg 11',
		link: 'http://www.uibk.ac.at',
		lng: 11.424539434000099,
		lat: 47.266765538000101
	});
	new Unilocation({
		name: 'Universität - Botanik',
		address: 'Sternwartestraße 15',
		link: 'http://www.uibk.ac.at/botany/',
		lng: 11.378682894000100,
		lat: 47.268014967000099
	}).save(function(error){if(error) throw error});
	new Unilocation({
		name: 'Universitäts-Sportinstitut - USI',
		address: 'Fürstenweg 185',
		link: 'http://www.uibk.ac.at/usi/',
		lng: 11.356319720000000,
		lat: 47.256817980999998
	}).save(function(error){if(error) throw error});
	new Unilocation({
		name: 'Universität - Technik',
		address: 'Technikerstraße 15',
		link: 'http://www.uibk.ac.at',
		lng: 11.344137593000100,
		lat: 47.264472039000097
	}).save(function(error){if(error) throw error});
	console.log('Created db entries!');
}

createCollection();