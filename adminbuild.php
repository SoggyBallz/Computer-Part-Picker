<?php
error_reporting (0);
$db = mysqli_connect('localhost','girts','','pc_part_picker');
if(!$db)
{
  echo 'Connection error: '. mysqli_connect_error();
}
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $selectedComponents = array($_POST['cpu_name'], $_POST['gpu_name'], $_POST['psu_name'], $_POST['motherboard_name'], $_POST['ram_name'], $_POST['pc_case_name'], $_POST['cooler_name']);

  if (in_array('select', $selectedComponents)) {
      $error = "All Components must be selected!";
  }
  else if($_POST['pc_name'] == null){
      $pc_error = "You need to name the computer!";
  }
  else{
      $stmt = $db->prepare("INSERT INTO pc (name, user_id, cpu_id, gpu_id, psu_id, motherboard_id, ram_id, case_id, cooler_id, pre_build) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("siiiiiiiii", $pc_name, $user_id, $cpu_id, $gpu_id, $psu_id, $motherboard_id, $ram_id, $case_id, $cooler_id, $pre_build);
      
      $myemail = $_SESSION['login_user'];
      $res = mysqli_query($db, "SELECT id FROM users WHERE email = '$myemail'");
      
      $user_id = mysqli_fetch_assoc($res)['id'];
      $pc_name = $_POST['pc_name'];
      $cpu_id = $_POST['cpu_name'];
      $gpu_id = $_POST['gpu_name'];
      $psu_id = $_POST['psu_name'];
      $motherboard_id = $_POST['motherboard_name'];
      $ram_id = $_POST['ram_name'];
      $case_id = $_POST['pc_case_name'];
      $cooler_id = $_POST['cooler_name'];
      $pre_build = 1;
  
      if ($stmt->execute()) {
        $success="New build created successfully";
        header("Location: adminbuild.php");
      } else {
        echo "Error: " . $stmt->error;
      }
      $stmt->close();
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Page</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<header>
    <nav>
      <ul>
        <li><a href="admin.php">Home</a></li>
        <li><a href="adminbuild.php">Build a Computer</a></li>
        <li><a href="components.php">Add Components</a></li>
        <li><a href="adminprebuilds.php">Pre-Builds</a></li>
        <li><div class="dropdown">
            <button class="dropbtn">Profile</button>
            <div class="dropdown-content">
            <a href="profile.php">Profile</a>
            <a href="cart.php">My Cart</a>
            <a href="index.php">Logout</a>
            </div>
        </li>
      </ul>
    </nav>
  </header>
    <form style="margin-top:20px; margin-left:10px" action="adminbuild.php" method="post">
        <label style="margin-top:20px; margin-left:10px; color:white" for="pc_name">Name of The Computer:</label><br>
		<input style="width: 20%;" type="text" name="pc_name" class="box" id="pc_name"><br>
    <div style = "margin:10px 0 10px 20px; font-size:16px; color:#cc0000;"><?php if (isset($pc_error)){echo $pc_error;}; ?></div>
    <div style = "margin:10px 0 10px 20px; font-size:16px; color:#cc0000;"><?php if (isset($success)){echo $success;}; ?></div>
    <?php
        $components = array(
        'cpu' => 'Cpu',
        'gpu' => 'Gpu',
        'psu' => 'Psu',
        'motherboard' => 'Motherboard',
        'ram' => 'RAM',
        'pc_case' => 'Case',
        'cooler' => 'Cooler'
        );
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
    <div style = "margin-left:20px; margin-bottom:10px; font-size:16px; color:#cc0000;"><?php if (isset($error)){echo $error;}; ?></div>
</body>
</html>