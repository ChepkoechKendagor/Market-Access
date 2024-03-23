<?php
session_start();
require '../db.php';



$fid = $_GET['id']; // Get the farmer ID from the URL
// Fetch farmer data from the database
$sql = "SELECT * FROM farmer WHERE fid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $fid);
$stmt->execute();
$result = $stmt->get_result();
$farmer = $result->fetch_assoc();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    // Update farmer data in the database
    $updateSql = "UPDATE farmer SET fname = ?, fusername = ?, femail = ?, fmobile = ?, faddress = ? WHERE fid = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sssssi", $name, $username, $email, $mobile, $address, $fid);
    
    if ($updateStmt->execute()) {
        $_SESSION['message'] = "Farmer profile updated successfully.";
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
    <title>Edit Farmer Profile</title>
    <style>
        body{
            background-color:pink;
        }
        </style>
</head>
<body>
    <h2>Edit Farmer Profile</h2>
    <form method="post" action="">
        Name: <input type="text" name="name" value="<?php echo $farmer['fname']; ?>"><br>
        Username: <input type="text" name="username" value="<?php echo $farmer['fusername']; ?>"><br>
        Email: <input type="email" name="email" value="<?php echo $farmer['femail']; ?>"><br>
        Mobile: <input type="text" name="mobile" value="<?php echo $farmer['fmobile']; ?>"><br>
        Address: <input type="text" name="address" value="<?php echo $farmer['faddress']; ?>"><br>
        <input type="submit" value="Update Profile">
    </form>
</body>
</html>
