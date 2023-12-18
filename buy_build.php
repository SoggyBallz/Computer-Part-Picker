<?php
// Establish a connection to the database
$db = mysqli_connect('localhost', 'girts', '', 'pc_part_picker');
session_start();

// Prepare the SQL statement for inserting into the pc table
$stmt = $db->prepare("INSERT INTO pc (Name, user_id, cpu_id, gpu_id, psu_id, motherboard_id, ram_id, case_id, cooler_id, pre_build) VALUES (?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("siiiiiiiii", $pc_name, $user_id, $cpu_id, $gpu_id, $psu_id, $motherboard_id, $ram_id, $case_id, $cooler_id, $pre_build);

// Retrieve the user ID based on the logged-in user's email
$myemail = $_SESSION['login_user'];
$res = mysqli_query($db, "SELECT id FROM users WHERE email = '$myemail'");
$user_id = mysqli_fetch_assoc($res)['id'];

// Retrieve the PC ID from the GET parameters
$pc_id = $_GET['id'];

// Query the database to get the details of the specified PC
$query = "SELECT * FROM pc WHERE id = '$pc_id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_assoc($result);

// Assign values from the retrieved row to variables
$pc_name = $row['Name'];
$cpu_id = $row['cpu_id'];
$gpu_id = $row['gpu_id'];
$psu_id = $row['psu_id'];
$motherboard_id = $row['motherboard_id'];
$ram_id = $row['ram_id'];
$case_id = $row['case_id'];
$cooler_id = $row['cooler_id'];
$pre_build = 0;

// Execute the prepared statement to insert a new PC entry
if ($stmt->execute()) {
    // Redirect to the prebuilds.php page after successful insertion
    header("Location: prebuilds.php");
} else {
    // Display an error message if the insertion fails
    echo "Error: " . $stmt->error;
}

// Close the prepared statement
$stmt->close();
// Exit to prevent further execution of the script
exit;
?>