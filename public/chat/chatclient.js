$(document).ready(function(){
	var socket = io();
	var nickname;
	var usernames = [];
	var topic;
	var $username = $('#username');
	var $topic = $('#topic');
	var $users = $('#users');
	var $messageForm = $('#send-message');
	var $messageBox = $('#message');
	var $chat = $('#chat');

	socket.on('connect', function(){ 
		console.log('user connected');
		socket.emit('new user', function(nick){
			nickname = nick;
			$username.html("You are logged in as " + nick);
		});
	});

	socket.on('message', function(msg){
		console.log(msg);
	});

	socket.on('disconnect', function() {
		console.log('disconnected');
	});

	socket.on('error', function (error) {
		console.log(error);
	});

	socket.on('kicked', function (name) {
		console.log('kick user ' + name);
		if(nickname === name){
			socket.disconnect();
		}
	});

	socket.on('usernames', function(data){
		usernames = data;
		var html = '';
		for(i=0; i < data.length; i++){
			html += data[i] + '<br/>';
		}
		$users.html(html);
	});

	socket.on('topic', function(name){
		topic = name;
		$topic.html(topic);
	});

	$messageForm.submit(function(event){
		event.preventDefault();
		var msg = $messageBox.val();
		var token =  msg.split(/[/:]/);
		if(/\/help/.test(msg)){
			$chat.append(getHelpHtml());
		} else if(/\/name:/.test(msg)){
			var newname = token[2];
			changeUserName(newname);
		} else if(/\/super:/.test(msg)){
			var newsuper = token[2];
			addSuperUser(newsuper);
		} else if(/\/kick:/.test(msg)){
			var kickuser = token[2];
			kickUser(kickuser);
		} else if(/\/quit/.test(msg)){
			quit();
		} else if(/\/users/.test(msg)){
			listUsers();
		} else if(/\/topic:/.test(msg)){
			var newtopic = token[2];
			changeTopic(newtopic);
		} else if(/\/topic/.test(msg)){
			$chat.append('Current topic: ' + topic + '<br/>');
		} else {
			socket.emit('send message', msg);
		}
		$messageBox.val('');
	});

	socket.on('new message', function(data){
		$chat.append('<b>' + data.nick + ': </b>' + data.msg + '<br/>');
		$chat.scrollTop($chat.prop("scrollHeight"));
	});

	function getHelpHtml() {
		var html = '';
		html += '<b>/help</b> - show all commands<br/>';
		html += '<b>/name:myname</b> - change your name to myname<br/>';
		html += '<b>/super:myname</b> - user myname gets super rights (super rights required)<br/>';
		html += '<b>/kick:myname</b> - kick user myname (super rights required)<br/>';
		html += '<b>/quit</b> - quit chat<br/>';
		html += '<b>/users</b> - list all active users<br/>';
		html += '<b>/topic:mytopic</b> - change chat topic to mytopic (super rights required)<br/>';
		html += '<b>/topic</b> - show current chat topic<br/>';
		return html;
	}

	function changeUserName(newname){
		socket.emit('change username', newname, function(data){
			if(data){
				nickname = newname;
				$username.html("You are logged in as " + newname);
			} else {
				$chat.append('Username already in use<br/>');
			}
		});
	}

	function addSuperUser(newsuper){
		socket.emit('new superuser', newsuper, function(response){
			if(response){
				socket.emit('send message', '<b>' + newsuper + ' is now a Super User!</b><br/>');
			} else {
				$chat.append(newsuper + ' is offline or you are not a super user!<br/>');
			}
		});
	}

	function kickUser(kickuser){
		socket.emit('kick user', kickuser, function(response){
			if(response){
				socket.emit('send message', '<b>' + kickuser + ' was kicked by ' + nickname + '!</b><br/>');
			} else {
				$chat.append(kickuser + ' is offline or you are not a super user!<br/>');
			}
		});
	}

	function quit(){
		socket.emit('send message', '<b> left chat!</b><br/>');
		socket.disconnect();
	}

	function listUsers(){
		var html = '';
		for(i=0; i < usernames.length; i++){
			html += usernames[i] + '<br/>';
		}
		$chat.append(html);
	}

	function changeTopic(newtopic){
		socket.emit('new topic', newtopic, function(data){
			if(data){
				topic = newtopic;
				$topic.html("Chat topic: " + topic);
				socket.emit('send message', '<b>Chat topic changed to ' + topic + '!</b><br/>');
			} else {
				$chat.append('Super user privileges needed to change chat topic!<br/>');
			}
		});
	}
});
