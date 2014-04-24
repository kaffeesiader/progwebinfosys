<h1>Edit settings</h1>
<form id="editSettings" action="" method="POST">
	
	<div>
		<label for="title">Items per page:</label> 
		<input type="number" name="settings_items_per_page" value="<?= $this->_['items_per_page'] ?>" />
	</div>
	<div>
		<label>Database settings:</label>
		<input type="checkbox" name="settings_optimized" value="optimized" <?= $this->_['optimized'] ? 'checked' : '' ?>>Use optimized database access
	</div>
	<div>
		<label for="profile">Profile settings:</label>
		<input type="checkbox" name="settings_profile" value="profile" <?= $this->_['profile'] ? 'checked' : '' ?>>Show profile information
	</div>
	<div>
		<input type="submit" name="settings_submit" value="Submit"/>
		<input type="submit" name="settings_cancel" value="Cancel"/>
	</div>
</form>