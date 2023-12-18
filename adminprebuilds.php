<?php
// Establish a connection to the database
$db = mysqli_connect('localhost', 'girts', '', 'pc_part_picker');
if (!$db) {
    die('Connection error: ' . mysqli_connect_error());
}

// Start the session
session_start();

// Define the SQL query to fetch pre-built computers with component details
$query = "SELECT pc.id, pc.name, cpu.name as cpu_name, 
            gpu.name as gpu_name, psu.name as psu_name, 
            motherboard.name as motherboard_name, ram.name as ram_name, 
            pc_case.name as case_name, cooler.name as cooler_name, cpu.price as cpu_price, gpu.price as gpu_price, psu.price as psu_price, motherboard.price as motherboard_price, 
            ram.price as ram_price, pc_case.price as case_price, cooler.price as cooler_price
          FROM pc
          INNER JOIN cpu ON pc.cpu_id = cpu.id
          INNER JOIN gpu ON pc.gpu_id = gpu.id
          INNER JOIN psu ON pc.psu_id = psu.id
          INNER JOIN motherboard ON pc.motherboard_id = motherboard.id
          INNER JOIN ram ON pc.ram_id = ram.id
          INNER JOIN pc_case ON pc.case_id = pc_case.id
          INNER JOIN cooler ON pc.cooler_id = cooler.id
          WHERE pre_build = 1";
          
// Execute the query
$result = mysqli_query($db, $query);

// Check for errors in the query
if (!$result) {
    die('Query error: ' . mysqli_error($db));
}

// Fetch all rows from the result set into an associative array
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

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
    <div class="container">
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
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) : ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['cpu_name']; ?></td>
                        <td><?php echo $row['gpu_name']; ?></td>
                        <td><?php echo $row['psu_name']; ?></td>
                        <td><?php echo $row['motherboard_name']; ?></td>
                        <td><?php echo $row['ram_name']; ?></td>
                        <td><?php echo $row['case_name']; ?></td>
                        <td><?php echo $row['cooler_name']; ?></td>
                        <?php
                        // Calculate the total price of components
                        $totalPrice = $row['cpu_price'] + $row['gpu_price'] + $row['psu_price'] +
                            $row['motherboard_price'] + $row['ram_price'] + $row['case_price'] +
                            $row['cooler_price'];
                        ?>
                        <td><?php echo number_format($totalPrice, 2); ?></td>
                        <td><a href="delete_build.php?id=<?php echo $row['id']; ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>