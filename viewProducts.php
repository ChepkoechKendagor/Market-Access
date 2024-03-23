<?php
session_start();

// Check if the user is logged in and redirect if not
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in to view this page!";
    header("Location: Login/error.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Products</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include other CSS files as needed -->
</head>
<body>

<div class="container">
    <h2>My Purchases</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($_SESSION['Purchases']) && is_array($_SESSION['Purchases'])): ?>
                <?php foreach ($_SESSION['Purchases'] as $purchase): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($purchase['productName']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['price']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No purchases found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap JS and other scripts as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
