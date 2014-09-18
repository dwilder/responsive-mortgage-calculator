<?php
/*	Input Class
 *
 */
class Input {
	
	// Attributes.
	protected $_label;
	protected $_name;
	protected $_placeholder;
	protected $_value;
	protected $_error; // An error message or false.
	
	// Constructor. Sets attributes.
	function __construct( $label, $name, $placeholder, $value = null, $error = null ) {
		
		$this->_label = $label;
		$this->_name = $name;
		$this->_placeholder = $placeholder;
		$this->_value = $value;
		$this->_error = $error;
		
	}
	
	// Method for setting the value.
	public function setValue( $value ) {
		$this->_value = $value;
	}
	
	// Method for setting the error message.
	public function setError( $error ) {
		$this->_error = $error;
	}
	
	// Method to create the input.
	public function getInput() {
		
		// Variable to build the input.
		$input = '
			<div class="lidd_rmc_input">';
		
		// Create the label.
		$input .= '
				<label for="' . $this->_name . '">' . $this->_label . '</label>';
		
		// Create the input.
		$input .= $this->buildInput();
		
		// Create the error span. This is used by JS even, too, so the span needs to always be include.
		$input .= '
				<span id="' . $this->_name . '-error"';
		
		// Check for an error.
		$input .= $this->_error ? ' class="lidd_rmc_error"' : '';
		
		$input .= '>' . $this->_error . '</span>';
		
		// Close the input.
		$input .= '
			</div>
		';
		
		echo $input;
		
	}
	
	// Method to build the input field.
	protected function buildInput() {
		return '<input type="text" name="' . $this->_name . '" id="' . $this->_name . '" placeholder="' . $this->_placeholder . '" value="' . $this->_value . '" />';
	}
	
}
?>