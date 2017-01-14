<?php

	//
	// COUNTRY QUERIES
	//

	// Find all countries, ordered by name
	function find_all_countries() {
		global $db;
		$sql = "SELECT * FROM countries ORDER BY name ASC;";
		$country_result = db_query($db, $sql);
		return $country_result;
	}

	//
	// STATE QUERIES
	//

	// Find all states, ordered by name
	function find_all_states() {
		global $db;
		$sql = "SELECT * FROM states ";
		$sql .= "ORDER BY name ASC;";
		$state_result = db_query($db, $sql);
		return $state_result;
	}

	// Find all states, ordered by name
	function find_states_for_country_id($country_id=0) {
		global $db;
		$sql = "SELECT * FROM states ";
		$sql .= "WHERE country_id='" . $country_id . "' ";
		$sql .= "ORDER BY name ASC;";
		$state_result = db_query($db, $sql);
		return $state_result;
	}

	// Find state by ID
	function find_state_by_id($id=0) {
		global $db;
		$sql = "SELECT * FROM states ";
		$sql .= "WHERE id='" . $id . "';";
		$state_result = db_query($db, $sql);
		return $state_result;
	}

	function validate_state($state, $errors=array()) {
		
		if (is_blank($state['name'])) 
			$errors[] = "State name cannot be blank.";
		elseif (!has_length($state['name'], array('min' => 2, 'max' => 255))) 
			$errors[] = "Name must be between 2 and 255 characters.";
		
		if (is_blank($state['code'])) 
			$errors[] = "Code cannot be blank.";
		elseif (!has_length($state['code'], array('exact' => 2))) 
			$errors[] = "Code must be a two character sequence.";
		
		if (is_blank($state['country_id']))
			$errors[] = "Country cannot be blank.";
		elseif(!has_number_value($state['country_id'], array('min' => 1, 'max' => 2)))
			$errors[] = "Invalid country code.";
		
		
		return $errors;
		
	}

	// Add a new state to the table
	// Either returns true or an array of errors
	function insert_state($state) {
		global $db;

		$errors = validate_state($state);
		if (!empty($errors)) {
			return $errors;
		}

		// Prepared statements are sanitized. Lets use those instead.
		$stmt = $db->prepare("INSERT INTO states (name, code, country_id) VALUES (?, ?, ?);");
		$stmt->bind_param('ssi', $state['name'], $state['code'], $state['country_id']);
		$result = $stmt->execute();
		
		if($result)
			return true;
		else{
			
			// The SQL INSERT statement failed.
			// Just show the error, not the form
			echo db_error($db);
			db_close($db);
			exit;
		
		}
		
	}

	// Edit a state record
	// Either returns true or an array of errors
	function update_state($state) {
		global $db;

		$errors = validate_state($state);
		
		if (!empty($errors)) {
			return $errors;
		}

		// Prepared statements are sanitized. Lets use those instead.
		$stmt = $db->prepare("UPDATE states SET name = ?, code = ?, country_id = ? WHERE id = ? LIMIT 1");
		$stmt->bind_param('ssii', $state['name'], $state['code'], $state['country_id'], $state['id']);
		$result = $stmt->execute();
		
		// For update_user statments, $result is just true/false
		//$result = db_query($db, $sql);
		if($result) {
			return true;
		} else {
			// The SQL UPDATE statement failed.
			// Just show the error, not the form
			echo db_error($db);
			db_close($db);
			exit;
		}
	}

	//
	// TERRITORY QUERIES
	//

	// Find all territories, ordered by state_id
	function find_all_territories() {
		global $db;
		$sql = "SELECT * FROM territories ";
		$sql .= "ORDER BY state_id ASC, position ASC;";
		$territory_result = db_query($db, $sql);
		return $territory_result;
	}

	// Find all territories whose state_id (foreign key) matches this id
	function find_territories_for_state_id($state_id=0) {
		global $db;
		$sql = "SELECT * FROM territories ";
		$sql .= "WHERE state_id='" . $state_id . "' ";
		$sql .= "ORDER BY position ASC;";
		$territory_result = db_query($db, $sql);
		return $territory_result;
	}

	// Find territory by ID
	function find_territory_by_id($id=0) {
		global $db;
		$sql = "SELECT * FROM territories ";
		$sql .= "WHERE id='" . $id . "';";
		$territory_result = db_query($db, $sql);
		return $territory_result;
	}

	function validate_territory($territory, $errors=array()) {
		
		if (is_blank($territory['name'])) 
			$errors[] = "Name cannot be blank.";
		elseif (!has_length($territory['name'], array('min' => 2, 'max' => 255))) 
			$errors[] = "Name must be between 2 and 255 characters.";

		if (is_blank($territory['position']) || is_int($territory['position'])) 
			$errors[] = "Position cannot be blank and must be a number.";

		return $errors;
	}

	// Add a new territory to the table
	// Either returns true or an array of errors
	function insert_territory($territory) {
		global $db;

		$errors = validate_territory($territory);
		if (!empty($errors)) {
			return $errors;
		}

		$stmt = $db->prepare('INSERT INTO territories (name, position, state_id) VALUES (?, ?, ?);'); 
		$stmt->bind_param('ssi', $territory['name'], $territory['position'], $territory['state_id']);
		
		// For INSERT statments, $result is just true/false
		$result = $stmt->execute();
		if($result) {
			return true;
		} else {
			// The SQL INSERT territoryment failed.
			// Just show the error, not the form
			echo db_error($db);
			db_close($db);
			exit;
		}
	}

	// Edit a territory record
	// Either returns true or an array of errors
	function update_territory($territory) {
		global $db;

		$errors = validate_territory($territory);
		if (!empty($errors)) {
			return $errors;
		}

			$sql = ""; // TODO add SQL
			// For update_territory statments, $result is just true/false
			$result = db_query($db, $sql);
		if($result) {
			return true;
		} else {
			// The SQL UPDATE territoryment failed.
			// Just show the error, not the form
			echo db_error($db);
			db_close($db);
			exit;
		}
	}

	//
	// SALESPERSON QUERIES
	//

	// Find all salespeople, ordered last_name, first_name
	function find_all_salespeople() {
		global $db;
		$sql = "SELECT * FROM salespeople ";
		$sql .= "ORDER BY last_name ASC, first_name ASC;";
		$salespeople_result = db_query($db, $sql);
		return $salespeople_result;
	}

	// To find salespeople, we need to use the join table.
	// We LEFT JOIN salespeople_territories and then find results
	// in the join table which have the same territory ID.
	function find_salespeople_for_territory_id($territory_id=0) {
		global $db;
		$sql = "SELECT * FROM salespeople ";
		$sql .= "LEFT JOIN salespeople_territories
		ON (salespeople_territories.salesperson_id = salespeople.id) ";
		$sql .= "WHERE salespeople_territories.territory_id='" . $territory_id . "' ";
		$sql .= "ORDER BY last_name ASC, first_name ASC;";
		$salespeople_result = db_query($db, $sql);
		return $salespeople_result;
	}

	// Find salesperson using id
	function find_salesperson_by_id($id=0) {
		global $db;
		$sql = "SELECT * FROM salespeople ";
		$sql .= "WHERE id='" . $id . "';";
		$salespeople_result = db_query($db, $sql);
		return $salespeople_result;
	}

	function validate_salesperson($salesperson, $errors=array()) {
		
		if (is_blank($salesperson['first_name'])) 
			$errors[] = "First name cannot be blank.";
		elseif (!has_length($salesperson['first_name'], array('min' => 2, 'max' => 255))) 
			$errors[] = "First name must be between 2 and 255 characters.";


		if (is_blank($salesperson['last_name'])) 
			$errors[] = "Last name cannot be blank.";
		elseif (!has_length($salesperson['last_name'], array('min' => 2, 'max' => 255))) 
			$errors[] = "Last name must be between 2 and 255 characters.";


		if (is_blank($salesperson['email'])) 
			$errors[] = "Email cannot be blank.";
		elseif (!has_valid_email_format($salesperson['email'])) 
			$errors[] = "Email must be a valid format.";


		if (is_blank($salesperson['phone'])) 
			$errors[] = "Phone number cannot be blank.";
		elseif (!has_valid_phone_format($salesperson['phone'])) 
			$errors[] = "Phone must be of valid format.";

		return $errors;
	}

	// Add a new salesperson to the table
	// Either returns true or an array of errors
	function insert_salesperson($salesperson) {
		global $db;

		$errors = validate_salesperson($salesperson);
		if (!empty($errors)) {
			return $errors;
		}

		// Prepared statements are sanitized. Lets use those instead.
		$stmt = $db->prepare("INSERT INTO salespeople (first_name, last_name, phone, email) VALUES (?, ?, ?, ?);");
		$stmt->bind_param('ssss', $salesperson['first_name'], $salesperson['last_name'], $salesperson['phone'], $salesperson['email']);
		$result = $stmt->execute();
		
		if($result) {
			return true;
		} else {
			// The SQL INSERT statement failed.
			// Just show the error, not the form
			echo db_error($db);
			db_close($db);
			exit;
		}
	}

	// Edit a salesperson record
	// Either returns true or an array of errors
	function update_salesperson($salesperson) {
		global $db;

		$errors = validate_salesperson($salesperson);
		if (!empty($errors)) {
			return $errors;
		}
		
		// Prepared statements are sanitized. Lets use those instead.
		$stmt = $db->prepare('UPDATE salespeople SET first_name=?, last_name=?, phone=?, email=? WHERE id=? LIMIT 1;');
		$stmt->bind_param('ssssi', $salesperson['first_name'], $salesperson['last_name'], $salesperson['phone'], $salesperson['email'], $salesperson['id']);
		$result = $stmt->execute();
		
		if($result) {
			return true;
		} else {
			// The SQL UPDATE statement failed.
			// Just show the error, not the form
			echo db_error($db);
			db_close($db);
			exit;
		}
	}
	
	// To find territories, we need to use the join table.
	// We LEFT JOIN salespeople_territories and then find results
	// in the join table which have the same salesperson ID.
	function find_territories_by_salesperson_id($id=0) {
		global $db;
		$sql = "SELECT * FROM territories ";
		$sql .= "LEFT JOIN salespeople_territories
		ON (territories.id = salespeople_territories.territory_id) ";
		$sql .= "WHERE salespeople_territories.salesperson_id='" . $id . "' ";
		$sql .= "ORDER BY territories.name ASC;";
		$territories_result = db_query($db, $sql);
		return $territories_result;
	}

	//
	// USER QUERIES
	//

	// Find all users, ordered last_name, first_name
	function find_all_users() {
		global $db;
		$sql = "SELECT * FROM users ";
		$sql .= "ORDER BY last_name ASC, first_name ASC;";
		$users_result = db_query($db, $sql);
		return $users_result;
	}

	// Find user using id
	function find_user_by_id($id=0) {
		global $db;
		$sql = "SELECT * FROM users WHERE id='" . $id . "' LIMIT 1;";
		$users_result = db_query($db, $sql);
		return $users_result;
	}

	function validate_user($user, $errors=array()) {
		if (is_blank($user['first_name'])) {
			$errors[] = "First name cannot be blank.";
		} elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
			$errors[] = "First name must be between 2 and 255 characters.";
		}

		if (is_blank($user['last_name'])) {
			$errors[] = "Last name cannot be blank.";
		} elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
			$errors[] = "Last name must be between 2 and 255 characters.";
		}

		if (is_blank($user['email'])) {
			$errors[] = "Email cannot be blank.";
		} elseif (!has_valid_email_format($user['email'])) {
			$errors[] = "Email must be a valid format.";
		}

		if (is_blank($user['username'])) {
			$errors[] = "Username cannot be blank.";
		} elseif (!has_length($user['username'], array('max' => 255))) {
			$errors[] = "Username must be less than 255 characters.";
		}
		return $errors;
	}

	// Add a new user to the table
	// Either returns true or an array of errors
	function insert_user($user) {
		global $db;

		$errors = validate_user($user);
		if (!empty($errors)) {
			return $errors;
		}

		$created_at = date("Y-m-d H:i:s");
		
		$stmt = $db->prepare('INSERT INTO users (first_name, last_name, email, username, created_at) VALUES (?, ?, ?, ?, ?)');
		$stmt->bind_param('sssss', $user['first_name'], $user['last_name'], $user['email'], $user['username'], $created_at);
		$result = $stmt->execute();
		
		if($result) {
			return true;
		} else {
			// The SQL INSERT statement failed.
			// Just show the error, not the form
			echo db_error($db);
			db_close($db);
			exit;
		}
	}

	// Edit a user record
	// Either returns true or an array of errors
	function update_user($user) {
		global $db;

		$errors = validate_user($user);
		if (!empty($errors)) {
			return $errors;
		}
		
		$stmt = $db->prepare('UPDATE users SET first_name=?, last_name=?, email=?, username=? WHERE id=? LIMIT 1;');
		$stmt->bind_param('ssssi', $user['first_name'], $user['last_name'], $user['email'], $user['username'], $user['id']);
		$result = $stmt->execute();
		
		if($result) {
			return true;
		} else {
			// The SQL UPDATE statement failed.
			// Just show the error, not the form
			echo db_error($db);
			db_close($db);
			exit;
		}
	}

?>
