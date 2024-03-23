<?php
session_start();
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['upload'])) {
        $pic = $_FILES['profilePic'];
        $picName = $pic['name'];
        $picTmpName = $pic['tmp_name'];
        $picSize = $pic['size'];
        $picError = $pic['error'];
        $picType = $pic['type'];

        $picExt = explode('.', $picName);
        $picActualExt = strtolower(end($picExt));
        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($picActualExt, $allowed)) {
            if ($picError === 0) {
                $picId = $_SESSION['id'];
                $picNameNew = "profile" . $picId . "." . $picActualExt;
                $picDestination = "../images/profileImages/" . $picNameNew;
                if (move_uploaded_file($picTmpName, $picDestination)) {
                    $sql = "UPDATE members SET picStatus=?, picExt=? WHERE id=?;";
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "isi", $picStatus, $picActualExt, $picId);
                        $picStatus = 1; // Assuming '1' means 'picture uploaded'
                        
                        if (mysqli_stmt_execute($stmt)) {
                            $_SESSION['message'] = "Profile picture updated successfully!";
                            $_SESSION['picName'] = $picNameNew;
                            $_SESSION['picExt'] = $picActualExt;
                            header("Location: ../profileView.php");
                        } else {
                            $_SESSION['message'] = "There was an error in updating your profile picture! Please try again!";
                            header("Location: ../Login/error.php");
                        }
                    } else {
                        $_SESSION['message'] = "There was an error preparing the database query! Please try again!";
                        header("Location: ../Login/error.php");
                    }
                } else {
                    $_SESSION['message'] = "There was an error in moving your uploaded file! Please try again!";
                    header("Location: ../Login/error.php");
                }
            } else {
                $_SESSION['message'] = "There was an error in uploading your image! Please try again!";
                header("Location: ../Login/error.php");
            }
        } else {
            $_SESSION['message'] = "You cannot upload files with this extension!";
            header("Location: ../Login/error.php");
        }
    } elseif (isset($_POST['remove']) && $_SESSION['picId'] != 0) {
        $picToRemove = "../images/profileImages/" . $_SESSION['picName'];
        if (unlink($picToRemove)) {
            $id = $_SESSION['id'];
            $sql = "UPDATE members SET picStatus=0, picExt='png' WHERE id=?;";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['message'] = "The profile picture was successfully deleted!";
                    $_SESSION['picId'] = 0;
                    $_SESSION['picExt'] = "png";
                    $_SESSION['picName'] = "profile0.png";
                    header("Location: ../profileView.php");
                } else {
                    $_SESSION['message'] = "There was an error in updating your profile picture status in the database!";
                    header("Location: ../Login/error.php");
                }
            } else {
                $_SESSION['message'] = "There was an error preparing the database query for picture removal! Please try again!";
                header("Location: ../Login/error.php");
            }
        } else {
            $_SESSION['message'] = "There was an error in deleting the profile picture!";
            header("Location: ../Login/error.php");
        }
    } else {
        header("Location: ../profileView.php");
    }
}

function dataFilter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
