<?php

	require_once('../../../private/initialize.php');
	$page_title = 'Staff: New Territory'; 
	include(SHARED_PATH . '/header.php'); 

	if(!isset($_GET['id'])) {
		redirect_to('index.php');
	}

	$stateID = trim($_GET['id']);
	$errors = array();
	$submitted = isset($_POST['submit']);
	
	$territory = array(
	
		'name'=>		isset($_POST['name']) && $submitted?$_POST['name']:'',
		'state_id'=>	$stateID,
		'position'=>	isset($_POST['position']) && $submitted?$_POST['position']:''
	
	);
	
	if($submitted){
		
		// If its submitted, try to insert it into the database
		$result = insert_territory($territory);
		if($result === true) {
			$new_id = db_insert_id($db);
			redirect_to('show.php?id=' . $new_id);
		} else 
			$errors = $result;
		
	}
	
?>

	<div id="main-content">
	<a href="../states/show.php?id= <?php echo trim($stateID); ?>">Back to State Details</a><br />

	<h1>New Territory</h1>

	<?php echo display_errors($errors); ?>

	<form action="new.php?id= <?php echo $stateID; ?>" method="post">

		Territory name: <br>
		<input type="text" name="name" value="<?php echo ht($territory['name']); ?>">
		<br>
		
		Territory position: <br>
		<input type="number" name="position" value="<?php echo ht($territory['position']); ?>">
		<br>
		<br>
		<input type="submit" name="submit" value="Submit">
	
	</form>
	
	</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
