<?php
    session_start();

    if ( $_SESSION['logged_in'] != 1 )
    {
      $_SESSION['message'] = "You must log in before viewing your profile page!";
      header("location: error.php");
    }
    else
    {

       $email =  $_SESSION['Email'];
       $name =  $_SESSION['Name'];
       $user =  $_SESSION['Username'];
       $mobile = $_SESSION['Mobile'];
       $active = $_SESSION['Active'];
    }
?>

<!DOCTYPE html>
    <html >
     <head>
        <title>Market Access</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="../bootstrap\css\bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="../bootstrap\js\bootstrap.min.js"></script>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="../js/jquery.min.js"></script>
		<script src="../js/skel.min.js"></script>
		<script src="../js/skel-layers.min.js"></script>
		<script src="../js/init.js"></script>
		<link rel="stylesheet" href="../css/skel.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/style-xlarge.css" />
    </head>

    <body>
        <?php
            require 'menu.php';
        ?>

        <section id="banner" class="wrapper">
            <div class="container">
                <header class="major">
                    <h2>Welcome</h2>
                </header>
                <p>
                <?php
                    if ( isset($_SESSION['message']) )
                    {
                        echo $_SESSION['message'];
                        unset( $_SESSION['message'] );
                    }
                ?>
                </p>

                <?php
                    if ( !$active )
                    {
                        echo
                        "<div>
                          
                        </div>";
                    }
                ?>
                  <h2><?php echo $name; ?></h2>
                  <p><?= $email ?></p>

                  
                    
                
                    <div class="row uniform">
                        <div class="6u 12u$(xsmall)">
                            <a href=../Login/monitorFarmer.php class="button special">Monitor Farmers</a>
                        </div>
                    
                        <div class="6u 12u$(xsmall)">
                            <a href=../Login/monitorBuyer.php class="button special">Monitor Buyers</a>
                        </div>
                        
                        <div class="6u 12u$(xsmall)">
                            <a href=../Login/productListed.php class="button special">Listed Products</a>
                        </div>
                        
                        <div class="6u 12u$(xsmall)">
                            <a href=../Login/orders.php class="button special">Orders Made</a>
                        </div>

                        <div class="6u 12u$(xsmall)">
                            <a href="logout.php" class="button special">LOG OUT</a>
                        </div>
                    </div>
                    

    </body>
</html>
