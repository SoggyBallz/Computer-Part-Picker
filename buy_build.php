<?php
$db = mysqli_connect('localhost','girts','','pc_part_picker');
session_start();

$stmt = $db->prepare("INSERT INTO pc (Name, user_id, cpu_id, gpu_id, psu_id, motherboard_id, ram_id, case_id, cooler_id, pre_build) VALUES (?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("siiiiiiiii", $pc_name, $user_id, $cpu_id, $gpu_id, $psu_id, $motherboard_id, $ram_id, $case_id, $cooler_id, $pre_build);

$myemail = $_SESSION['login_user'];
$res = mysqli_query($db, "SELECT id FROM users WHERE email = '$myemail'");
$user_id = mysqli_fetch_assoc($res)['id'];

$pc_id = $_GET['id'];
$query = "SELECT * FROM pc WHERE id = '$pc_id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_assoc($result);

$pc_name = $row['Name'];
$cpu_id = $row['cpu_id'];
$gpu_id = $row['gpu_id'];
$psu_id = $row['psu_id'];
$motherboard_id = $row['motherboard_id'];
$ram_id = $row['ram_id'];
$case_id = $row['case_id'];
$cooler_id = $row['cooler_id'];
$pre_build = 0;

if ($stmt->execute()) {
    header("Location: prebuilds.php");
} 
else {
    echo "Error: " . $stmt->error;
    }
$stmt->close();
exit;
?>