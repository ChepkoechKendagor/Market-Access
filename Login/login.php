<?php
    session_start();

    $user = dataFilter($_POST['uname']);
    $pass = $_POST['pass'];
    $category = dataFilter($_POST['category']);

    require '../db.php';

if($category == 1)
{
    $sql = "SELECT * FROM farmer WHERE fusername='$user'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if($num_rows == 0)
    {
        $_SESSION['message'] = "Invalid User Credentialss!";
        header("location: error.php");
    }

    else
    {
        $User = $result->fetch_assoc();

        if (password_verify($_POST['pass'], $User['fpassword']))
        {
            $_SESSION['id'] = $User['fid'];
            $_SESSION['Hash'] = $User['fhash'];
            $_SESSION['Password'] = $User['fpassword'];
            $_SESSION['Email'] = $User['femail'];
            $_SESSION['Name'] = $User['fname'];
            $_SESSION['Username'] = $User['fusername'];
            $_SESSION['Mobile'] = $User['fmobile'];
            $_SESSION['Addr'] = $User['faddress'];
            $_SESSION['Active'] = $User['factive'];
            $_SESSION['picStatus'] = $User['picStatus'];
            $_SESSION['picExt'] = $User['picExt'];
            $_SESSION['logged_in'] = true;
            $_SESSION['Category'] = 0;
            $_SESSION['Rating'] = 0;

            if($_SESSION['picStatus'] == 0)
            {
                $_SESSION['picId'] = 0;
                $_SESSION['picName'] = "profile0.png";
            }
            else
            {
                $_SESSION['picId'] = $_SESSION['id'];
                $_SESSION['picName'] = "profile".$_SESSION['picId'].".".$_SESSION['picExt'];
            }
            //echo $_SESSION['Email']."  ".$_SESSION['Name'];

            header("location: profile.php");
        }
        else
        {
            //echo mysqli_error($conn);
            $_SESSION['message'] = "Invalid User Credentials!";
            header("location: error.php");
        }
    }
}
elseif($category == 2)
{
    $sql = "SELECT * FROM buyer WHERE busername='$user'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    if($num_rows == 0)
    {
        $_SESSION['message'] = "Invalid User Credentialss!";
        header("location: error.php");
    }

    else
    {
        $User = $result->fetch_assoc();

        if (password_verify($_POST['pass'], $User['bpassword']))
        {
            $_SESSION['id'] = $User['bid'];
            $_SESSION['Hash'] = $User['bhash'];
            $_SESSION['Password'] = $User['bpassword'];
            $_SESSION['Email'] = $User['bemail'];
            $_SESSION['Name'] = $User['bname'];
            $_SESSION['Username'] = $User['busername'];
            $_SESSION['Mobile'] = $User['bmobile'];
            $_SESSION['Addr'] = $User['baddress'];
            $_SESSION['Active'] = $User['bactive'];
            $_SESSION['logged_in'] = true;
            
            if ($_SESSION['Category'] === 'farmer') {
                $_SESSION['Category'] = 1; // Assuming 1 represents the category for farmers
            } elseif ($_SESSION['Category'] === 'buyer') {
                $_SESSION['Category'] = 2; // Assuming 2 represents the category for buyers
            } else {
                // Handle other roles or unexpected values if necessary
            }
            //echo $_SESSION['Email']."  ".$_SESSION['Name'];

            header("location: bprofile.php");
        }
    }
}
        elseif ($category == 3) { // Assuming 3 represents the Admin category
            $sql = "SELECT * FROM admin WHERE ausername='$user'";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);
        
            if ($num_rows == 0) {
                $_SESSION['message'] = "Invalid User Credentials!";
                header("location: error.php");
            }
            else {
                $User = $result->fetch_assoc();
        
                if (password_verify($pass, $User['apassword'])) {
                    // Set session variables for the admin
                    $_SESSION['id'] = $User['aid'];
                    $_SESSION['Hash'] = $User['ahash'];
                    $_SESSION['Password'] = $User['apassword'];
                    $_SESSION['Email'] = $User['aemail'];
                    $_SESSION['Name'] = $User['aname'];
                    $_SESSION['Username'] = $User['ausername'];
                    $_SESSION['Mobile'] = $User['amobile'];
                    $_SESSION['Addr'] = $User['aaddress'];
                    $_SESSION['Active'] = $User['aactive'];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['Category'] = 3; // Admin category
        
                    header("location: aprofile.php"); // Redirect to an admin dashboard page
                }
        else
        {
            //echo mysqli_error($conn);
            $_SESSION['message'] = "Invalid User Credentials!";
            header("location: error.php");
        }
    }
}
            

    function dataFilter($data)
    {
    	$data = trim($data);
     	$data = stripslashes($data);
    	$data = htmlspecialchars($data);
      	return $data;
    }

?>
