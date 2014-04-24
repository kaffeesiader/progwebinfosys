<?php

class View {
	// Path to templates
	private $path = 'templates';
	// Template name
	private $template;
	
	/**
	 * Hold variables included into our view
	 */
	private $_ = array();
	
	/**
	 * Assign a given value to a given key
	 *
	*/
	public function assign($key, $value){
		$this->_[$key] = $value;
	}
	
	
	/**
	 * Set the name of the template
	 *
	 */
	public function setTemplate($template = 'default'){
		$this->template = $template;
	}
	
	/**
	 * Load template file and return output as string
	 *
	 */
	public function loadTemplate(){
		$tpl = $this->template;
		// check if template file exists and create path
		$file = $this->path . DIRECTORY_SEPARATOR . $tpl . '.php';
		$exists = file_exists($file);
	
		if ($exists){
			// store output in buffer
			ob_start();
	
			// load template file and store output in $output.
			include $file;
			$output = ob_get_contents();
			ob_end_clean();
	
			return $output;
		}
		else {
			// Display error
			return 'could not find template';
		}
	}
}

?>