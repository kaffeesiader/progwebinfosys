
/* define all necessary dependencies */
var express = require('express');
var app = express();
var http = require('http');
var path = require('path');

var server = require('http').createServer(app);
server.listen(8080);

/* configure express */
app.use(express.logger('dev'));
app.use(express.bodyParser());
app.use(express.static(path.join(__dirname, 'public')));

//development only
if ('development' === app.get('env')) {
	app.use(express.errorHandler());
}

// start a chat server
var chat = require("./chatmodule");
chat.startServer(server, app);

// start a maps server
var maps = require("./mapsmodule");
maps.startServer(app);
