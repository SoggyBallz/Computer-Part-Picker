<?php
// Establish a connection to the database
$db = mysqli_connect('localhost', 'girts', '', 'pc_part_picker');

// Get the PC ID from the GET parameters
$pc_id = $_GET['id'];

// Check if the PC is a pre-build or not
$is_pre_build = mysqli_query($db, "SELECT pre_build FROM pc WHERE id = '$pc_id'")->fetch_assoc()['pre_build'];

// Delete the PC from the database based on the ID
mysqli_query($db, "DELETE FROM pc WHERE id = '$pc_id'");

// Redirect to the appropriate page after deletion
header("Location: " . ($is_pre_build ? "adminprebuilds.php" : "mybuilds.php"));
exit;
?>
