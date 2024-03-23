<?php
session_start();
require 'db.php'; // Adjust the path as needed to connect to your database

// Example input from a form or API call
$productId = $_POST['pid']; // The ID of the product being sold
$soldQuantity = $_POST['quantity']; // The quantity of the product being sold

// Check product availability
$availabilityCheckSql = "SELECT quantity FROM fproduct WHERE product_id = ?";
$stmt = $conn->prepare($availabilityCheckSql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($product && $product['quantity'] >= $soldQuantity) {
    // Proceed with the sale
    // Here, you'd typically process payment before finalizing the sale
    // For simplicity, this step is assumed to be completed

    // Update product quantity
    $updateSql = "UPDATE fproduct SET quantity = quantity - ? WHERE product_id = ? AND quantity >= ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("iii", $soldQuantity, $productId, $soldQuantity);
    if ($updateStmt->execute()) {
        echo "Sale completed successfully. Product quantity updated.";
        // Optionally, redirect or perform additional actions
    } else {
        echo "Error updating product quantity.";
    }
} else {
    echo "Insufficient stock for this product.";
    // Handle the case where there isn't enough stock
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
