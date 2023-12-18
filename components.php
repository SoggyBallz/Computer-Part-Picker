<?php
// Suppress error reporting
error_reporting(0);

// Establish a connection to the database
$db = mysqli_connect('localhost', 'girts', '', 'pc_part_picker');
if (!$db) {
    echo 'Connection error: ' . mysqli_connect_error();
}

// Check if the component is set in the GET parameters
if (isset($_GET['component'])) {
    // Get the component from the GET parameters
    $component = $_GET['component'];
    // Define a list of valid components
    $valid_components = array('cpu', 'gpu', 'psu', 'motherboard', 'ram', 'pc_case', 'cooler');

    // Check if the selected component is valid
    if (in_array($component, $valid_components)) {
        // Display a selection message based on the chosen component
        $selection = ucwords($component) . " selected!";
        
        // Retrieve input values from POST data
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $price = mysqli_real_escape_string($db, $_POST['price']);
        
        // Check if the component with the same name already exists
        $chk_query = "SELECT * FROM $component WHERE name='$name'";
        $chk_res = mysqli_query($db, $chk_query);
        
        // If the component doesn't exist and the name is not empty, insert the new component
        if (mysqli_num_rows($chk_res) > 0) {
            $error = "Error: $component already exists in the database.";
        } elseif (!empty($name)) {
            $sql = "INSERT INTO $component (name, price) VALUES ('$name', '$price')";
            
            // Execute the SQL query
            if (mysqli_query($db, $sql)) {
                // Redirect to the components.php page after successful insertion
                header("Location: components.php");
            } else {
                // Display an error message if the insertion fails
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            }
        }
    } else {
        $error = "Invalid component selected";
    }

    // Close the database connection
    mysqli_close($db);
} else {
    $error = "Select a component";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Components</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="admin.php">Home</a></li>
                <li><a href="adminbuild.php">Build a Computer</a></li>
                <li><a href="components.php">Add Components</a></li>
                <li><a href="adminprebuilds.php">Pre-Builds</a></li>
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
    <div class="component_input">
        <!-- Form for selecting a component -->
        <form action="components.php" method="get">
            <label style="color:black; margin:10px 0 0 20px" for="component">Component:</label>
            <select style="margin:20px;font-size:16px; position: relative; display: inline-block;" name="component" id="component">
                <option value="select">Select a component</option>
                <option value="cpu">Cpu</option>
                <option value="gpu">Gpu</option>
                <option value="psu">Psu</option>
                <option value="motherboard">Motherboard</option>
                <option value="ram">Ram</option>
                <option value="pc_case">Case</option>
                <option value="cooler">Cooler</option>
            </select>
            <input style="padding:10px; margin:10px 0 0 20px" type="submit" value="Submit" />
        </form>

        <!-- Display messages based on selection and errors -->
        <div style="margin-left:20px; margin-bottom:10px; font-size:16px; color:#cc0000;"><?php if (isset($selection)) {echo $selection;}; ?></div>
        <div style="margin-left:20px; margin-bottom:10px; font-size:16px; color:#cc0000;"><?php if (isset($error)) {echo $error;}; ?></div>

        <!-- Form for adding a new component -->
        <form action="" method="post">
            <label for="name">Name of The Component:</label><br>
            <input type="name" name="name" class="box"><br>

            <label for="price">Component price:</label><br>
            <input type="price" name="price" class="box"><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>
