/**
 * Server side module for the chat application
 */

var usernames = [];
var supernames = [];
var nicknameId = 0;
var topic = 'No topic set';

exports.startServer = function(server, app) {
	console.log("Launching chat application server");
	var io = require('socket.io')(server);

	// all io.socket code goes inside here
	io.sockets.on('connection', function(socket){

		console.log(usernames);
		
		socket.on('new user', function(callback){
			socket.username = generateGuestName();
			addUser(socket.username);		
			if(usernames.length === 1){
				addSuperUser(socket.username);
			}
			callback(socket.username);
			updateClients();
			console.log(usernames);
		});

		socket.on('change username', function(name, callback){
			callback(changeUserName(socket.username, name));
			updateClients();
			console.log(usernames);
		});

		socket.on('new superuser', function(name, callback){
			console.log("superusers", supernames);
			if(isSuperUser(socket.username)){
				callback(addSuperUser(name));
			} else {
				callback(false);
			}
		});

		socket.on('kick user', function(name, callback){
			if(isSuperUser(socket.username)){
				io.sockets.emit('kicked', name);
				callback(true);
			} else {
				callback(false);
			}
		});

		socket.on('new topic', function(name, callback){
			if(isSuperUser(socket.username)){
				topic = name;
				updateClients();
				callback(true);
			} else {
				callback(false);
			}
		});

		socket.on('send message', function(data){
			io.sockets.emit('new message', {msg: data, nick: socket.username});
		});

		socket.on('disconnect', function(data){
			removeSuperUser(socket.username);
			removeUser(socket.username);
			updateClients();
			if(usernames.length === 1){
				addSuperUser(usernames[0]);
			}
			console.log(usernames);
		});

		function generateGuestName() {
			nick = "Guest" + nicknameId;
			nicknameId++;
			return nick;
		}

		function updateClients(){
			io.sockets.emit('usernames', usernames);
			io.sockets.emit('topic', topic);
		}

		function isUser(name){
			if(usernames.indexOf(name) != -1){
				return true;
			} else {
				return false;
			}
		}

		function addUser(name){
			if(usernames.indexOf(name) == -1){
				usernames.push(name);
				console.log("Added User " + name);
				return true;
			} else {
				return false;
			}
		}

		function removeUser(name){
			if(isUser(name)){
				usernames.splice(usernames.indexOf(name), 1);
				console.log("Removed User " + name);
				return true;
			} else {
				return false;
			}
		}

		function isSuperUser(name){
			if(supernames.indexOf(name) != -1){
				return true;
			} else {
				return false;
			}
		}

		function addSuperUser(name){
			if(usernames.indexOf(name) != -1 && supernames.indexOf(name) == -1){
				supernames.push(name);
				console.log("Added Super User " + name);
				return true;
			} else {
				return false;
			}
		}

		function removeSuperUser(name){
			if(isSuperUser(name)){
				supernames.splice(supernames.indexOf(name), 1);
				console.log("Removed Super User " + name);
				return true;
			} else {
				return false;
			}
		}

		function changeUserName(oldname, newname){
			if(addUser(newname)){
				removeUser(oldname);
				socket.username = newname;
				if(addSuperUser(newname)){
					removeSuperUser(oldname);
				}
				return true;
			} else {
				return false;
			}
		}

	});
}

