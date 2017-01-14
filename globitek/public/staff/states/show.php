<?php 

	require_once('../../../private/initialize.php'); 

	if(!isset($_GET['id'])) {
		redirect_to('index.php');
	}
	
	$id = $_GET['id'];
	$state_result = find_state_by_id($id);
	// No loop, only one result
	$state = db_fetch_assoc($state_result);

	$page_title = 'Staff: State of ' . ht($state['name']);
	include(SHARED_PATH . '/header.php'); 

?>

	<div id="main-content">
	<a href="index.php">Back to States List</a><br />

	<h1>State: <?php echo ht($state['name']); ?></h1>

	<table id="state">
		<tr>
			<td>Name: </td>
			<td><?php echo ht($state['name']); ?></td>
		</tr>
		<tr>
			<td>Code: </td>
			<td><?php echo ht($state['code']); ?></td>
		</tr>
		<tr>
			<td>Country ID: </td>
			<td><?php echo ht($state['country_id']); ?></td>
		</tr>
	</table>

	<br />
	<a href="edit.php?id= <?php echo ur($state['id']); ?>">Edit</a><br />
	<hr />

	<h2>Territories</h2>
	<br />
	<a href="../territories/new.php?id=<?php echo ur($id);?>">Add a Territory</a><br />

<?php

	$territory_result = find_territories_for_state_id($state['id']);

	echo "<ul id=\"territories\">";
	
	while($territory = db_fetch_assoc($territory_result)) {
		
		echo "<li>";
		echo "<a href=\"../territories/show.php?id=" . ur($territory['id']) . "\">";
		echo ht($territory['name']);
		echo "</a>";
		echo "</li>";
		
	} // end while $territory

	db_free_result($territory_result);
	echo "</ul>"; // #territories

	db_free_result($state_result);

	echo "</div>";

	include(SHARED_PATH . '/footer.php'); 

?>
