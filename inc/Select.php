<?php
/*	Select Class
 *	This class alters the Input class by overriding it's constructor and buildInput methods.
 *	It adds the 'options' attribute.
 *	It also accepts an array of key/value pairs in order to build the options list.
 */
class Select extends Input {
	
	// New attribute.
	protected $_options = array();
	
	// Constructor. Sets attributes. $options is a variation on the Input class.
	function __construct( $label, $name, $options, $value = null, $error = null ) {
		
		$this->_label = $label;
		$this->_name = $name;
		$this->_options = $options;
		$this->_value = $value;
		$this->_error = $error;
		
	}
	
	// Method for setting the value.
	public function setValue( $value ) {
		$this->_value = $value;
	}
	
	// Override the buildInput method.
	protected function buildInput() {
		$select = '';
		
		// Create a container.
		$select .= '<span class="lidd_rmc_select">';
		
		// Open the select box.
		$select .= '<select name="' . $this->_name . '">';
		
		// Create the options.
		foreach ( $this->_options as $k => $v ) {
			$select .= '<option value="' . $k . '"';
			$select .= ( $k == $this->_value ) ? ' selected="selected"' : '';
			$select .= '>' . $v . '</option>';
		}
		
		// Close the select box.
		$select .= '</select>';
		
		// Close the container.
		$select .= '</span>';
		
		return $select;
		
	}
	
}
?>