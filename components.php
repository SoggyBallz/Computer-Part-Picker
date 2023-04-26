<?php
error_reporting (0);
$db = mysqli_connect('localhost','girts','','pc_part_picker');
if(!$db)
{
  echo 'Connection error: '. mysqli_connect_error();
}
$cpu_name = mysqli_real_escape_string($db,$_POST['cpu_name']);
$cpu_description = mysqli_real_escape_string($db,$_POST['cpu_description']);
$cpu_price = mysqli_real_escape_string($db,$_POST['cpu_price']);
$chk_query = "SELECT * FROM cpu WHERE name='$cpu_name'";
$chk_res = mysqli_query($db, $chk_query);

if(mysqli_num_rows($chk_res) > 0){
    $error = "Error: Cpu already exists in the database.";
}
else if(($_POST['cpu_name']) != null)
{
    $sql = "INSERT INTO cpu (name, description, price) VALUES ('$cpu_name', '$cpu_description', '$cpu_price')";

    if (mysqli_query($db, $sql))
    {
      header("Location: components.php");
    }
    else
    {
      echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
}
mysqli_close($db);
?>
<html>
<head>
  <title>Components</title>
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
        <li><a href="index.php">Log Out</a></li>
      </ul>
    </nav>
  </header>
  <form action="" method="post">
		<label for="cpu_name">Name of The CPU:</label><br>
		<input type="text" name="cpu_name" class = "box"><br>

		<label for="cpu_description">Cpu's description:</label><br>
		<input type="text" name="cpu_description" class = "box"><br><br>

        <label for="cpu_price">Cpu's price:</label><br>
		<input type="text" name="cpu_price" class = "box"><br><br>

		<input type="submit" value="Submit">
	</form>
  </html>