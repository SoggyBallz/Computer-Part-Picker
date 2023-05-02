<?php
error_reporting (0);
$db = mysqli_connect('localhost','girts','','pc_part_picker');
if(!$db)
{
  echo 'Connection error: '. mysqli_connect_error();
}
if(isset($_GET['component'])) {
  $component = $_GET['component'];
  $valid_components = array('cpu', 'gpu', 'psu', 'motherboard', 'ram', 'pc_case', 'cooler');
  
  if(in_array($component, $valid_components)) {
    $selection = ucwords($component) . " selected!";
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $price = mysqli_real_escape_string($db, $_POST['price']);
    
    $chk_query = "SELECT * FROM $component WHERE name='$name'";
    $chk_res = mysqli_query($db, $chk_query);
    
    if(mysqli_num_rows($chk_res) > 0) {
      $error = "Error: $component already exists in the database.";
    } else if(!empty($name)) {
      $sql = "INSERT INTO $component (name, description, price) VALUES ('$name', '$description', '$price')";
      
      if(mysqli_query($db, $sql)) {
        header("Location: components.php");
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
      }
    }
  } else {
    $error = "Invalid component selected";
  }
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
        <li><a href="index.php">Log Out</a></li>
      </ul>
    </nav>
  </header>
  <div class="component_input">
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
  <div style = "margin-left:20px; margin-bottom:10px; font-size:16px; color:#cc0000;"><?php if (isset($selection)){echo $selection;}; ?></div>
  <div style = "margin-left:20px; margin-bottom:10px; font-size:16px; color:#cc0000;"><?php if (isset($error)){echo $error;}; ?></div>
    <form action="" method="post">
		  <label for="name">Name of The Component:</label><br>
		  <input type="name" name="name" class = "box"><br>

		  <label for="description">Component description:</label><br>
		  <input type="description" name="description" class = "box"><br><br>

      <label for="price">Component price:</label><br>
		  <input type="price" name="price" class = "box"><br><br>

		  <input type="submit" value="Submit">
	  </form>
  </div>
  </html>