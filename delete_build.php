<?php
$db = mysqli_connect('localhost','girts','','pc_part_picker');

$pc_id = $_GET['id'];
$is_pre_build = mysqli_query($db, "SELECT pre_build FROM pc WHERE id = '$pc_id'")->fetch_assoc()['pre_build'];

mysqli_query($db, "DELETE FROM pc WHERE id = '$pc_id'");
header("Location: " . ($is_pre_build ? "adminprebuilds.php" : "mybuilds.php"));
exit;
?>