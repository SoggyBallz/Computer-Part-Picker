<?php
// Suppress error reporting for cleaner output
error_reporting(0);

// Establish a connection to the database
$db = mysqli_connect('localhost', 'girts', '', 'pc_part_picker');
if (!$db) {
    echo 'Connection error: ' . mysqli_connect_error();
}

// Start the session
session_start();

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather selected components from the form
    $selectedComponents = array(
        $_POST['cpu_name'],
        $_POST['gpu_name'],
        $_POST['psu_name'],
        $_POST['motherboard_name'],
        $_POST['ram_name'],
        $_POST['pc_case_name'],
        $_POST['cooler_name']
    );

    // Check if 'select' is present in selected components
    if (in_array('select', $selectedComponents)) {
        $error = "All Components must be selected!";
    } else if ($_POST['pc_name'] == null) {
        // Check if the computer name is empty
        $pc_error = "You need to name the computer!";
    } else {
        // Prepare and bind parameters for inserting a new build into the database
        $stmt = $db->prepare("INSERT INTO pc (name, user_id, cpu_id, gpu_id, psu_id, motherboard_id, ram_id, case_id, cooler_id, pre_build) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiiiiiii", $pc_name, $user_id, $cpu_id, $gpu_id, $psu_id, $motherboard_id, $ram_id, $case_id, $cooler_id, $pre_build);

        // Retrieve user ID based on the logged-in user's email
        $myemail = $_SESSION['login_user'];
        $res = mysqli_query($db, "SELECT id FROM users WHERE email = '$myemail'");
        $user_id = mysqli_fetch_assoc($res)['id'];

        // Assign form values to variables for database insertion
        $pc_name = $_POST['pc_name'];
        $cpu_id = $_POST['cpu_name'];
        $gpu_id = $_POST['gpu_name'];
        $psu_id = $_POST['psu_name'];
        $motherboard_id = $_POST['motherboard_name'];
        $ram_id = $_POST['ram_name'];
        $case_id = $_POST['pc_case_name'];
        $cooler_id = $_POST['cooler_name'];
        $pre_build = 0; // 0 indicates a custom build

        // Execute the prepared statement
        if ($stmt->execute()) {
            $success = "New build created successfully";
            header("Location: build.php"); // Redirect to the build page after successful insertion
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close(); // Close the prepared statement
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Main Page</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="main.php">Home</a></li>
                <li><a href="build.php">Build a Computer</a></li>
                <li><a href="prebuilds.php">Pre-Builds</a></li>
                <li><a href="mybuilds.php">My Computers</a></li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Profile</button>
                        <div class="dropdown-content">
                            <a href="profile.php">Profile</a>
                            <a href="index.php">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <form style="margin-top:20px; margin-left:10px" action="build.php" method="post">
        <label style="margin-top:20px; margin-left:10px; color:white" for="pc_name">Name of The Computer:</label><br>
        <input style="width: 20%;" type="text" name="pc_name" class="box" id="pc_name"><br>
        <div style="margin:10px 0 10px 20px; font-size:16px; color:#cc0000;"><?php if (isset($pc_error)) {echo $pc_error;}; ?></div>
        <div style="margin:10px 0 10px 20px; font-size:16px; color:#cc0000;"><?php if (isset($success)) {echo $success;}; ?></div>
        <?php
        // Define an array of components and their corresponding names
        $components = array(
            'cpu' => 'Cpu',
            'gpu' => 'Gpu',
            'psu' => 'Psu',
            'motherboard' => 'Motherboard',
            'ram' => 'RAM',
            'pc_case' => 'Case',
            'cooler' => 'Cooler'
        );
        // Loop through each component to generate a dropdown list
        foreach ($components as $component => $name) {
            $query = "SELECT id, name FROM {$component}";
            $result = $db->query($query);
        ?>
            <select name="<?php echo $component; ?>_name" id="<?php echo $component; ?>_name">
                <option value="select">Select <?php echo $name; ?></option>
                <?php
                if ($result->num_rows > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $component_name = $data['name'];
                        $component_id = $data['id'];
                ?>
                        <option value="<?php echo $component_id; ?>"><?php echo $component_name; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        <?php
        }
        ?>
        <input type="submit" name="submit">
    </form>
    <div style="margin-left:20px; margin-bottom:10px; font-size:16px; color:#cc0000;"><?php if (isset($error)) {echo $error;}; ?></div>
</body>

</html>