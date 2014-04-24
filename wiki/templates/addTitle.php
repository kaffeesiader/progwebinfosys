<script type="text/javascript">

	function validateForm()
	{
		var title = document.getElementById('title_input').value;
		if(title.length == 0) {
			alert('The title cannot be empty!');
			return false;
		}
		
		var content = document.getElementById('content_input').value;
		if(content.length == 0) {
			alert('No content provided!');
			return false;
		}
		
		return true;
	};
	
</script>

<h1>Create a new wiki entry</h1>
<form id="editTitle" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
	<div>
		<label for="wiki_image">Image filepath</label>
		<input id="title_input" type="text" name="wiki_title" placeholder="Enter a new title" />
	</div>
	<div>
		<label for="wiki_image">Image filepath</label>
		<input type="file" name="wiki_image" accept="image/*">
	</div>
	<div>
		<label for="wiki_allign">Image allignment</label>
		<select name="wiki_allign">
			<option value="left" selected="selected">left</option>
	      	<option value="right">right</option>
	    </select>
	</div>
	<div>
		<label for="wiki_content">Content</label>
		<textarea id="content_input" name="wiki_content" placeholder="enter content"></textarea>
	</div>
	<div>
		<input type="submit" name="wiki_submit" value="Submit"/>
		<input type="submit" name="cancel" value="Cancel"/>
	</div>
</form>