<?php

	require_once('../../../private/initialize.php');

	$page_title = 'Staff: New State'; 
	include(SHARED_PATH . '/header.php'); 

	$submitted = isset($_POST['submit']);
	
	$errors = array();
	$state = array(
	
		'name' => 		isset($_POST['name']) 		&& $submitted?$_POST['name']:'',
		'code' => 		isset($_POST['code']) 		&& $submitted?$_POST['code']:'',
		'country_id' => isset($_POST['country_id']) && $submitted?$_POST['country_id']:''
	
	);
	
	if($submitted){
		
		$result = insert_state($state);
		if($result === true) {
		
			$new_id = db_insert_id($db);
			redirect_to('show.php?id=' . ur($new_id));
		
		} else 
			$errors = $result;
		
	}
	
?>

	<div id="main-content">
	<a href="index.php">Back to States List</a><br />

	<h1>New State</h1>

	<?php echo display_errors($errors); ?>

		<form action="new.php" method="post">

			Name: <br>
			<input type="text" name="name" value="<?php echo ht($state['name']);?>">
			<br>
			Code: <br>
			<input type="text" name="code" value="<?php echo ht($state['code']);?>">
			<br>
			Country: <br>
			<input type="number" name="country_id" value="<?php echo ht($state['country_id']);?>"> (1 for USA, 2 for Canada)
			<br><br>
			<input type="submit" name="submit" value="Submit">
			
		</form>
	
	</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
