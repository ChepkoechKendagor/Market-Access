<?php
session_start();
require 'db.php';

// Check if the farmer is logged in and has a valid fid in the session
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1 || !isset($_SESSION['id'])) {
    $_SESSION['message'] = "You must log in to view your orders";
    header("location: error.php");
    exit();
}

$fid = $_SESSION['id']; // Assuming the farmer's ID is stored in session under 'id'

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders | Market Access</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <?php require 'menu.php'; ?>

    <div class="container">
        <h2>Your Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Buyer Name</th>
                    <th>City</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to get the farmer's orders
                $sql = "SELECT t.*, p.product FROM transaction t
                        INNER JOIN fproduct p ON t.pid = p.pid
                        WHERE p.fid = '$fid'";
                $result = mysqli_query($conn, $sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        // Inside the loop that displays each order
echo "<tr>
<td>".$row["tid"]."</td>
<td>".$row["product"]."</td>
<td>".$row["name"]."</td>
<td>".$row["city"]."</td>
<td>".$row["mobile"]."</td>
<td>".$row["email"]."</td>
<td>".$row["addr"]."</td>
<td>".$row["status"]."</td> <!-- Display the status -->
<td>
    <form action='acceptOrder.php' method='post'>
        <input type='hidden' name='tid' value='".$row["tid"]."'>
        <input type='submit' value='Accept Order' ".($row["status"] == "accepted" ? "disabled" : "").">
    </form>
</td>
</tr>";

                    }
                } else {
                    echo "<tr><td colspan='7'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
