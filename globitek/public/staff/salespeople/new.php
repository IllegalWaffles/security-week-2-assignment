<?php

	require_once('../../../private/initialize.php');
	$page_title = 'Staff: New Salesperson'; 
	include(SHARED_PATH . '/header.php'); 
	
	// Check if it's submitted
	$submitted = isset($_POST["submit"]);
	
	// Define the stuff we need
	$errors = array();
	$salesperson = array(
		'firstName' => isset($_POST["firstname"]) && $submitted?$_POST["firstname"]:'',
		'lastName' => isset($_POST["lastname"]) && $submitted?$_POST["lastname"]:'',
		'phone' => isset($_POST["phonenumber"]) && $submitted?$_POST["phonenumber"]:'',
		'email' => isset($_POST["email"]) && $submitted?$_POST["email"]:''
	);
	
	if($submitted){
		
		// If its submitted, try to insert it into the database
		$result = insert_salesperson($salesperson);
		if($result === true) {
			$new_id = db_insert_id($db);
			redirect_to('show.php?id=' . $new_id);
		} else 
			$errors = $result;
		
	}
	
?>

	<div id="main-content">
		<a href="index.php">Back to Salespeople List</a><br />

		<h1>New Salesperson</h1>

		<?php echo display_errors($errors); ?>
		
		<form action="new.php" method="post">

			First name: <br>
			<input type="text" name="firstname" value="<?php echo $salesperson['firstName']; ?>">
			<br>
			Last name: <br>
			<input type="text" name="lastname" value="<?php echo $salesperson['lastName']; ?>">
			<br>
			Phone number: <br>
			<input type="text" name="phonenumber" value="<?php echo $salesperson['phone']; ?>">
			<br>
			Email: <br>
			<input type="text" name="email" value="<?php echo $salesperson['email']; ?>">
			
			<br><br>
			<input type="submit" name="submit" value="Submit">
			
			
		</form>

	</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
