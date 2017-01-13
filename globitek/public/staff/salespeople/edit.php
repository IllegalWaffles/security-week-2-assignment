<?php

	require_once('../../../private/initialize.php');

	if(!isset($_GET['id'])) {
	  redirect_to('index.php');
	}
	$salespeople_result = find_salesperson_by_id($_GET['id']);
	// No loop, only one result
	$salesperson = db_fetch_assoc($salespeople_result);

	$page_title = 'Staff: Edit Salesperson ' . $salesperson['first_name'] . " " . $salesperson['last_name']; 
	include(SHARED_PATH . '/header.php'); 
	
	$errors = array();
	
	$submitted = isset($_POST['submit']);
	
	if($submitted){
	
		$salesperson['first_name'] = 	isset($_POST['firstname'])?$_POST['firstname']:'';
		$salesperson['last_name'] = 	isset($_POST['lastname'])?$_POST['lastname']:'';
		$salesperson['phone'] = 		isset($_POST['phonenumber'])?$_POST['phonenumber']:'';
		$salesperson['email'] = 		isset($_POST['email'])?$_POST['email']:'';
	
		$result = update_salesperson($salesperson);
		if($result === true) {
			redirect_to('show.php?id=' . $salesperson['id']);
		} else 
			$errors = $result;
	
		
	}
	
?>

	<div id="main-content">
	<a href="edit.php">Back to Salespeople List</a><br />

	<h1>Edit Salesperson: <?php echo $salesperson['first_name'] . " " . $salesperson['last_name']; ?></h1>

	<?php echo display_errors($errors); ?>
  
		<form action="edit.php?id=<?php echo $salesperson['id']; ?>" method="post">

			First name: <br>
			<input type="text" name="firstname" value="<?php echo $salesperson['first_name']; ?>">
			<br>
			Last name: <br>
			<input type="text" name="lastname" value="<?php echo $salesperson['last_name']; ?>">
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
