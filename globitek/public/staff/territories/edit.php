<?php

	require_once('../../../private/initialize.php');

	if(!isset($_GET['id'])) {
		redirect_to('index.php');
	}
	$territories_result = find_territory_by_id($_GET['id']);
	// No loop, only one result
	$territory = db_fetch_assoc($territories_result);

	$page_title = 'Staff: Edit Territory ' . ht($territory['name']);
	include(SHARED_PATH . '/header.php'); 

	$errors = array();
	$submitted = isset($_POST['submit']);
	
	if($submitted){
		
		$territory['position'] = isset($_POST['position'])?$_POST['position']:'';	
		$territory['name'] = isset($_POST['name'])?$_POST['name']:'';
		
		$result = update_territory($territory);
		if($result === true) {
			redirect_to('show.php?id=' . $territory['id']);
		} else 
			$errors = $result;
		
	}
	
?>

	<div id="main-content">
	<a href="../states/show.php?id= <?php echo trim($territory['state_id']); ?>">Back to State Details</a><br />

	<h1>Edit Territory: <?php echo ht($territory['name']); ?></h1>

	<form action="edit.php?id= <?php echo $territory['id']; ?>" method="post">

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
