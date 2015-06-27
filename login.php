<?php
    include "includes/database.php";
    session_start(); 


    if(isset($_SESSION['users']) && isset($_SESSION['passs']))
      {
      echo '<script>windows: location="login.php";</script>';
      }

    if(isset($_SESSION['type'])){
     if($_SESSION['type'] == 'Admin')
     {
         echo '<script>windows: location="adminpanel/index.php";</script>';
     }elseif($_SESSION['type'] == 'Tutorial'){
        echo '<script>windows: location="tutorialpanel/index.php"</script>';
    }elseif($_SESSION['type'] == "Draftsman/Tutor" || $_SESSION['type'] == "draftsman/tutor"){
        echo '<script>windows: location="dualtypepanel/index.php"</script>';
    }elseif(($_SESSION['type'] == "draftsman" || $_SESSION['type'] == "Draftsman")){
        $eid = $_SESSION['empID'];
        //echo '<script>windows: location="draftsmanpanel/index.php"</script>';
        $query2 = $dbh->prepare("SELECT id, proj_id as `pid`, status as `to` FROM projWork WHERE eID = ? AND `id` = (SELECT MAX(id) ) ORDER BY id DESC LIMIT 1");
               $passval2= array($eid);
               $query3 = $dbh->prepare("SELECT COUNT(timeOut) as `count` FROM projWork WHERE eID = ? AND `id` = (SELECT MAX(id) ) ORDER BY id DESC LIMIT 1");
               $query2 ->execute($passval2);
               $query3 ->execute($passval2);
               $row2 = $query2 ->fetch();
               $row3 = $query3 ->fetch();
               $timout = $row2['to'];
               $count = $row3['count'];
               
               if($timout == NULL){
                    echo '<script>windows: location="draftsmanpanel/index.php"</script>';
               }elseif($timout == 1){
                    echo '<script>windows: location="draftsmanpanel/index2.php?pid='.$row2['pid'].'"</script>';
               }elseif($count == 0){
                    echo '<script>windows: location="draftsmanpanel/index.php"</script>';
               }else{
                    echo '<script>windows: location="draftsmanpanel/index.php"</script>';
               }
             
    }
}

?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>OLOL | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="adminpanel/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="adminpanel/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="adminpanel/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">User Login</div>
            <form action="" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="userid" class="form-control" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          

                </div>
                <div class="footer">                                                               
                    <button type="submit" name="oks" class="btn bg-olive btn-block">Sign me in</button>  
                    
                    <p><a href="index.php">Go back to Homepage</a></p>

                </div>
            </form>

        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="adminpanel/js/bootstrap.min.js" type="text/javascript"></script>

    <?php
        if(isset($_POST['oks'])) {
            $users = $_POST['userid'];
            $passs = $_POST['password'];
            
            echo $db->checkLogins($users, $passs);
        }
    ?>     

    </body>
</html>