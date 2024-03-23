<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tid'])) {
    $tid = $_POST['tid'];

    // Fetch the pid before updating the order status
    $fetchProductSql = "SELECT pid FROM transaction WHERE tid='$tid'";
    $productResult = mysqli_query($conn, $fetchProductSql);
    $productRow = mysqli_fetch_assoc($productResult);
    $pid = $productRow['pid'];

    // Update the order status to 'accepted'
    $updateOrderSql = "UPDATE transaction SET status='accepted' WHERE tid='$tid'";
    if (mysqli_query($conn, $updateOrderSql)) {
        // If order accepted successfully, then delete the product
        $deleteProductSql = "DELETE FROM fproduct WHERE pid='$pid'";
        if(mysqli_query($conn, $deleteProductSql)) {
            $_SESSION['message'] = "Order accepted and product removed successfully.";
            header('Location: viewOrders.php');
        } else {
            $_SESSION['message'] = "Order accepted but product removal failed.";
            header('Location: error.php');
        }
    } else {
        $_SESSION['message'] = "Error accepting order.";
        header('Location: error.php');
    }
} else {
    header('Location: viewOrders.php');
}
?>
