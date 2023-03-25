<?php
   define('DB_SERVER', 'localhost:3306');
   define('DB_EMAIL', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'pc-part-picker');
   $db = mysqli_connect(DB_SERVER,DB_EMAIL,DB_PASSWORD,DB_DATABASE);
?>