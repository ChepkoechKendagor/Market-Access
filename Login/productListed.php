<?php
    session_start();

    if ( $_SESSION['logged_in'] != 1 )
    {
      $_SESSION['message'] = "You must log in before viewing your profile page!";
      header("location: error.php");
    }
    else
    {

       $email =  $_SESSION['Email'];
       $name =  $_SESSION['Name'];
       $user =  $_SESSION['Username'];
       $mobile = $_SESSION['Mobile'];
       $active = $_SESSION['Active'];
    }
?>

<!DOCTYPE html>
    <html >
     <head>
        <title>Products</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="../bootstrap\css\bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="../bootstrap\js\bootstrap.min.js"></script>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="../js/jquery.min.js"></script>
		<script src="../js/skel.min.js"></script>
		<script src="../js/skel-layers.min.js"></script>
		<script src="../js/init.js"></script>
		<link rel="stylesheet" href="../css/skel.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/style-xlarge.css" />
    </head>

    
        <?php
            require 'menu.php';
        ?>

       
        <?php

require '../db.php';
// Fetch data function
function fetchData($conn, $table) {
    $sql = "SELECT * FROM $table";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "Error fetching data: " . mysqli_error($conn);
        return [];
    }
}
// Fetching buyers
$products = fetchData($conn, 'fproduct');
?>  
<body>
        <section id="one" class="wrapper style1 align-center" style="background-color:red">
				<div class="container">
        <h2>Products Listed by Farmers</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Information</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['product']) ?></td>
                        <td><?= htmlspecialchars($product['pcat']) ?></td>
                        <td><?= htmlspecialchars($product['pinfo']) ?></td>
                        <td><?= htmlspecialchars($product['price']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
                
                <div class="6u 12u$(xsmall)">
                <button onclick="location.href='logout.php'" class="btn btn-primary">LOG OUT</button>
                        </div>
                </section>
                </div>
                        </body>
</html>