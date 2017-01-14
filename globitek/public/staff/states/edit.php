<?php
	
	require_once('../../../private/initialize.php');

	if(!isset($_GET['id']))
		redirect_to('index.php');

	$states_result = find_state_by_id($_GET['id']);
	// No loop, only one result
	$state = db_fetch_assoc($states_result);

	$page_title = 'Staff: Edit State ' . ht($state['name']);
	include(SHARED_PATH . '/header.php'); 
	
	$errors = array();
	
	$submitted = isset($_POST['submit']);
	
	if($submitted){
		
		$state['name'] = 		isset($_POST['name'])?		$_POST['name']:'';
		$state['code'] =		isset($_POST['code'])?		$_POST['code']:'';
		$state['country_id'] = 	isset($_POST['country_id'])?$_POST['country_id']:'';
		
		$result = update_state($state);
		if($result === true) {
			redirect_to('show.php?id=' . ur($state['id']));
		} else 
			$errors = $result;
		
	}
	
?>

<div id="main-content">
  <a href="index.php">Back to States List</a><br />

  <h1>Edit State: <?php echo ht($state['name']); ?></h1>
  <?php echo display_errors($errors);?>
  
	<form action="edit.php?id=<?php echo ur($state['id']); ?>" method="post">

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
