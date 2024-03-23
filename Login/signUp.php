<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = dataFilter($_POST['name']);
    $mobile = dataFilter($_POST['mobile']);
    $user = dataFilter($_POST['uname']);
    $email = dataFilter($_POST['email']);
    $pass = dataFilter(password_hash($_POST['pass'], PASSWORD_BCRYPT));
    $hash = dataFilter(md5(rand(0, 1000)));
    $category = dataFilter($_POST['category']);
    $addr = dataFilter($_POST['addr']);

    $_SESSION['Email'] = $email;
    $_SESSION['Name'] = $name;
    $_SESSION['Password'] = $pass;
    $_SESSION['Username'] = $user;
    $_SESSION['Mobile'] = $mobile;
    $_SESSION['Category'] = $category;
    $_SESSION['Hash'] = $hash;
    $_SESSION['Addr'] = $addr;
    $_SESSION['Rating'] = 0;
}

require '../db.php';

$length = strlen($mobile);

if ($length != 10) {
    $_SESSION['message'] = "Invalid Mobile Number !!!";
    header("location: error.php");
    die();
}

if ($category == 1) {
    $sql = "SELECT * FROM farmer WHERE femail='$email'";

    $result = mysqli_query($conn, "SELECT * FROM farmer WHERE femail='$email'") or die($mysqli->error());

    if ($result->num_rows > 0 )
    {
        $_SESSION['message'] = "User with this email already exists!";
        //echo $_SESSION['message'];
        header("location: error.php");
    }
    else
    {
    	$sql = "INSERT INTO farmer (fname, fusername, fpassword, fhash, fmobile, femail, faddress)
    			VALUES ('$name','$user','$pass','$hash','$mobile','$email','$addr')";

    	if (mysqli_query($conn, $sql))
    	{
    	    $_SESSION['Active'] = 0;
            $_SESSION['logged_in'] = true;

            $_SESSION['picStatus'] = 0;
            

            $sql = "SELECT * FROM farmer WHERE fusername='$user'";
            $result = mysqli_query($conn, $sql);
            $User = $result->fetch_assoc();
            $_SESSION['id'] = $User['fid'];

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

            $_SESSION['message'] ="Farmer account created successfully!";

            header("location: profile.php");
    	}
    	else
    	{
    	    //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    	    $_SESSION['message'] = "Registration failed!";
            header("location: error.php");
    	}
    }
}

else if ($category == 2) {
    $sql = "INSERT INTO buyer (bname, busername, bpassword, bhash, bmobile, bemail, baddress)
    			VALUES ('$name','$user','$pass','$hash','$mobile','$email','$addr')";

    	if (mysqli_query($conn, $sql))
    	{
    	    $_SESSION['Active'] = 0;
            $_SESSION['logged_in'] = true;

            $sql = "SELECT * FROM buyer WHERE busername='$user'";
            $result = mysqli_query($conn, $sql);
            $User = $result->fetch_assoc();
            $_SESSION['id'] = $User['bid'];

            $_SESSION['message'] = "Retailer account created successfully!";

            header("location: bprofile.php");
        }
    }

            elseif ($category == 3) { // Assuming 3 represents the Admin category
                $sql = "SELECT * FROM admin WHERE aemail='$email'";
                $result = mysqli_query($conn, $sql) or die($mysqli->error());
        
                if ($result->num_rows > 0) {
                    $_SESSION['message'] = "User with this email already exists!";
                    header("location: error.php");
                }
    

     else {
        $sql = "INSERT INTO admin (aname, ausername, apassword, ahash, amobile, aemail, aaddress)
                VALUES ('$name', '$user', '$pass', '$hash', '$mobile', '$email', '$addr')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['Active'] = 0;
            
            $sql = "SELECT * FROM admin WHERE ausername='$user'";
            $result = mysqli_query($conn, $sql);
            $User = $result->fetch_assoc();
            $_SESSION['id'] = $User['aid']; // Assuming 'aid' is the admin ID field

            $_SESSION['message'] = "Admin account created successfully!";
            header("location: aprofile.php"); // Redirect to an admin profile or dashboard page
        } else {
            $_SESSION['message'] = "Registration failed!";
            header("location: error.php");
        }
    }
}

function dataFilter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
