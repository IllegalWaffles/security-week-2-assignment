<?php
	require_once('../../../private/initialize.php');

	if(!isset($_GET['id'])) {
		redirect_to('index.php');
	}
	
	$id = $_GET['id'];
	$salespeople_result = find_salesperson_by_id($id);
	// No loop, only one result
	$salesperson = db_fetch_assoc($salespeople_result);

	$page_title = 'Staff: Salesperson ' . ht($salesperson['first_name'] . " " . $salesperson['last_name']); 
	include(SHARED_PATH . '/header.php'); 

?>

	<div id="main-content">
	<a href="index.php">Back to Salespeople List</a><br />

	<h1>Salesperson: <?php echo ht($salesperson['first_name'] . " " . $salesperson['last_name']); ?></h1>

	<table id="salesperson">
		<tr>
			<td>Name: </td>
			<td><?php echo ht($salesperson['first_name'] . " " . $salesperson['last_name']); ?></td>
		</tr>
		<tr>
			<td>Phone: </td>
			<td><?php echo ht($salesperson['phone']); ?></td>
		</tr>
		<tr>
			<td>Email: </td>
			<td><?php echo ht($salesperson['email']); ?></td>
		</tr>
	</table>

<?php
	
	db_free_result($salespeople_result);

?>

	<br />
	<a href="edit.php?id= <?php echo $salesperson['id']; ?>">Edit</a><br />
	</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
