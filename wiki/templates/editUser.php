
<script type="text/javascript">

	function validateForm()
	{
		var username = document.getElementById('username').value;
		if(username.length == 0) {
			alert('The field username cannot be empty!');
			return false;
		}
		
		if(!username.match(/^\w+$/)) {
			alert('The username can only contain alphanumeric characters!');
			return false;
		}

		var email = document.getElementById('email').value;
		if(email.length == 0) {
			alert('No email address provided!');
			return false;
		}
		
		var password = document.getElementById('password').value;
		var confirm = document.getElementById('confirm').value;

		if(password.length < 8) {
			alert('The password has to be at least 8 characters long!');
			return false;
		}

		if(!password == confirm) {
			alert('The password confirmation does not match the password!');
			return false;
		}
		
		return true;
	};
	
</script>

<h1>Create a new user</h1>
<form id="createUser" action="/wiki/user/add" method="POST" onsubmit="return validateForm();">
	<div>
		<label for="user_name">Username</label> 
		<input id="username" type="text" name="user_name" placeholder="username" value="<?=$this->_['username'] ?>"/>
	</div>
	<div>
		<label for="user_email">E-Mail</label> 
		<input id="email" type="email"	name="user_email" placeholder="e-mail" value="<?=$this->_['email'] ?>"/>
	</div>
	<div>
		<label for="user_password">Password</label>
		<input id="password" type="password" name="user_password" placeholder="password" />
	</div>
	<div>
		<label for="confirm_password">Confirm</label>
		<input id="confirm" type="password" name="confirm_password" placeholder="confirm password" />
	</div>
	<div>
		<input id="submit" type="submit" name="user_submit" value="Submit" /> 
		<input id="cancel" type="submit" name="cancel" value="Cancel" />
	</div>
</form>