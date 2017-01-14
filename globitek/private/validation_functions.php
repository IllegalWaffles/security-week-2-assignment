<?php

// is_blank('abcd')
	function is_blank($value='') {
		return !isset($value) || trim($value) == '';
	}

	// has_length('abcd', ['min' => 3, 'max' => 5])
	function has_length($value, $options=array()) {
		$length = strlen($value);
		if(isset($options['max']) && ($length > $options['max'])) {
			return false;
		} elseif(isset($options['min']) && ($length < $options['min'])) {
			return false;
		} elseif(isset($options['exact']) && ($length != $options['exact'])) {
			return false;
		} else {
			return true;
		}
	}

	// has_valid_email_format('test@test.com')
	function has_valid_email_format($value) {
		// Function can be improved later to check for
		// more than just '@'.
		$pattern = '/^[^0-9.\_][A-Za-z0-9]+[@][A-Za-z0-9_]+[.][a-z]{3}$/';
		return preg_match($pattern, $value);
		
	}

	function has_valid_phone_format($value){
		
		$pattern = '/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/';
		return preg_match($pattern, $value);
		
	}
  
	function has_number_value($value, $options=array()){
		
		if(isset($options['max']) && ($value > $options['max'])) {
			return false;
		} elseif(isset($options['min']) && ($value < $options['min'])) {
			return false;
		} elseif(isset($options['exact']) && ($value != $options['exact'])) {
			return false;
		} else {
			return true;
		}
		
	}
	
?>
