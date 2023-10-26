<?php
$db = mysqli_connect('localhost','girts','','pc_part_picker');
if(!$db)
{
  echo 'Connection error: '. mysqli_connect_error();
}
session_start();

$query = "SELECT pc.id, pc.name, cpu.name as cpu_name, 
            gpu.name as gpu_name, psu.name as psu_name, 
            motherboard.name as motherboard_name, ram.name as ram_name, 
            pc_case.name as case_name, cooler.name as cooler_name FROM pc
          INNER JOIN cpu ON pc.cpu_id = cpu.id
          INNER JOIN gpu ON pc.gpu_id = gpu.id
          INNER JOIN psu ON pc.psu_id = psu.id
          INNER JOIN motherboard ON pc.motherboard_id = motherboard.id
          INNER JOIN ram ON pc.ram_id = ram.id
          INNER JOIN pc_case ON pc.case_id = pc_case.id
          INNER JOIN cooler ON pc.cooler_id = cooler.id
          WHERE pre_build = 1";
$result = mysqli_query($db, $query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
  <div class=container>
    <h2 style="text-align: center;">Pre Built Computers</h2>
  <table>
  <thead class='li'>
    <tr>
      <th>Name</th>
      <th>CPU</th>
      <th>GPU</th>
      <th>PSU</th>
      <th>Motherboard</th>
      <th>RAM</th>
      <th>Case</th>
      <th>Cooler</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($data as $row): ?>
      <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['cpu_name']; ?></td>
        <td><?php echo $row['gpu_name']; ?></td>
        <td><?php echo $row['psu_name']; ?></td>
        <td><?php echo $row['motherboard_name']; ?></td>
        <td><?php echo $row['ram_name']; ?></td>
        <td><?php echo $row['case_name']; ?></td>
        <td><?php echo $row['cooler_name']; ?></td>
        <td><a href="delete_build.php?id=<?php echo $row['id']; ?>">Delete</a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</body>