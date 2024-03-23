<?php
session_start();
require 'db.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == 0) {
    $_SESSION['message'] = "You need to first login to access this page !!!";
    header("Location: Login/error.php");
}

function dataFilter($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['delete'])) {
    $delete_pid = dataFilter($_POST['delete']);
    // You may want to perform additional checks or validations here
    $delete_sql = "DELETE FROM fproduct WHERE pid = '$delete_pid'";
    $delete_result = mysqli_query($conn, $delete_sql);
    // Redirect back to the same page after deletion
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Market Access</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="login.css"/>
    <script src="js/jquery.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/skel-layers.min.js"></script>
    <script src="js/init.js"></script>
    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
    </noscript>
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
</head>
<body class>
    <?php
    require 'menu.php';
    ?>
    <section id="main" class="wrapper style1 align-center">
        <div class="container">
            <h2>Welcome to digital market</h2>
            <section id="two" class="wrapper style2 align-center">
                <div class="container">
                    <div class="row">
                        <?php
                        $sql = "SELECT * FROM fproduct";
                        $result = mysqli_query($conn, $sql);
                        while ($row = $result->fetch_array()):
                            $picDestination = "images/productImages/" . $row['pimage'];
                        ?>
                            <div class="col-md-4">
                                <section>
                                    <strong><h2 class="title" style="color:black;"><?php echo $row['product']; ?></h2></strong>
                                    <a href="review.php?pid=<?php echo $row['pid']; ?>"> <img class="image fit" src="<?php echo $picDestination; ?>" height="220px;" /></a>
                                    <div style="align: left">
                                        <blockquote><?php echo "Type : " . $row['pcat']; ?><br><?php echo "Price : " . $row['price'] . ' /-'; ?><br></blockquote>
                                        <!-- Delete form -->
                                        <form method="post">
                                            <input type="hidden" name="delete" value="<?php echo $row['pid']; ?>">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
        </div>
    </section>
</body>
</html>