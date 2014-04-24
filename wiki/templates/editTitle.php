<script type="text/javascript">

	function validateForm()
	{
		var content = document.getElementById('content_input').value;
		if(content.length == 0) {
			alert('No content provided!');
			return false;
		}
		
		return true;
	};
	
</script>


<h1><?= $this->_['title'] ?></h1>
<form id="editTitle" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
	<div>
		<label for="wiki_image">Image filepath</label>
		<input type="file" name="wiki_image" accept="image/*">
	</div>
	<div>
		<label for="wiki_allign">Image allignment</label>
		<select name="wiki_allign">
			<? if($this->_['allign'] == 'left') : ?>
				<option value="left" selected="selected">left</option>
	      		<option value="right">right</option>
			<? else : ?>
				<option value="left">left</option>
	      		<option value="right" selected="selected">right</option>
			<? endif; ?>
	      
	    </select>
	</div>
	<div>
		<label for="wiki_content">Content</label>
		<input type="hidden" name="wiki_title" value="<?= $this->_['title'] ?>" />
		<textarea id="content_input" name="wiki_content"><?= $this->_['content'] ?></textarea>
	</div>
	<div>
		<input type="submit" name="wiki_submit" value="Submit"/>
		<input type="submit" name="cancel" value="Cancel"/>
	</div>
</form>