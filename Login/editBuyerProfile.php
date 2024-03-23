<?php
session_start();
require '../db.php';



$bid = $_GET['id']; // Get the buyer ID from the URL
// Fetch buyer data from the database
$sql = "SELECT * FROM buyer WHERE bid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bid);
$stmt->execute();
$result = $stmt->get_result();
$buyer = $result->fetch_assoc();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    // Update buyer data in the database
    $updateSql = "UPDATE buyer SET bname = ?, busername = ?, bemail = ?, bmobile = ?, baddress = ? WHERE bid = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sssssi", $name, $username, $email, $mobile, $address, $bid);
    
    if ($updateStmt->execute()) {
        $_SESSION['message'] = "Buyer profile updated successfully.";
        header("location: aprofile.php"); // Redirect back to the admin dashboard
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Buyer Profile</title>
</head>
<body>
    <h2>Edit Buyer Profile</h2>
    <form method="post" action="">
        Name: <input type="text" name="name" value="<?php echo htmlspecialchars($buyer['bname']); ?>"><br>
        Username: <input type="text" name="username" value="<?php echo htmlspecialchars($buyer['busername']); ?>"><br>
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($buyer['bemail']); ?>"><br>
        Mobile: <input type="text" name="mobile" value="<?php echo htmlspecialchars($buyer['bmobile']); ?>"><br>
        Address: <input type="text" name="address" value="<?php echo htmlspecialchars($buyer['baddress']); ?>"><br>
        <input type="submit" value="Update Profile">
    </form>
</body>
</html>
