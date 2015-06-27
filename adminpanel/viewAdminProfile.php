<?php 
    include_once "includes/database.php";
    echo $db -> ifLogin();
            $id = $_SESSION['empID'];

?>



<!DOCTYPE html>
<html>
    <head>
        <?php 
            $icon = '<i class="fa fa-user"></i>';
            $title = "View Profile";
            include_once "includes/head.php";
           

            global $dbh;

            try {
                $query = $dbh -> prepare("SELECT CONCAT(firstName,' ',lastName) as `name`, contactNum as `c`, email as `e`, address as `a`, bday as `b`, picture as  `p` FROM employee WHERE employeeID = :empid");
                $query -> bindParam(":empid", $id);
                $query -> execute();

                $row = $query->fetch();
                    $name = $row['name'];
                    $contact = $row['c'];
                    $add = $row['a'];
                    $eadd = $row['e'];
                    $pic = $row['p'];
                    $d = $row['b'];

                    $birth = date("F d, Y",strtotime($d));

                $query4 = $dbh -> prepare("SELECT username, password, type FROM account WHERE empID = :empid");
                $query4 -> bindParam(":empid", $id);
                $query4 -> execute();

                $row4 = $query4->fetch();
                    $user = $row4['username'];
                    $password = $row4['password'];
                    $type = $row4['type'];
                
                


                
                   
            
                



        ?>
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700|Lato:400,300' rel='stylesheet' type='text/css'>

    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php"; ?>

                <!-- Main content -->
                <section class="content">

                <div class="row">
                    
               

                    <form id="msform" method="POST" style="width:80%; ">
                        <fieldset style="margin-bottom:50px;">

                            <div id="cv" class="instaFade">
                            <div class="mainDetails">
                                <div id="headshot" class="quickFade">
                                    <img src="<?php echo $pic?>"/>
                                </div>
                                
                                <div id="name">
                                    <h1 class="quickFade delayTwo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $name;?></h1>
                                    <h2 class="quickFade delayThree">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $type;?></h2>
                                </div>
                                
                                
                                <div class="clear"></div>
                            </div>
                            
                            <div id="mainArea" class="quickFade delayFive">
                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Address</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $add;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>
                                
                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Email Address</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $eadd;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>

                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Contact Number</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $contact;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>

                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Birthdate</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $birth;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>

                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Username</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $user;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>
                                
                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Password</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php $hidden_password = preg_replace("|.|","*",$password); echo $hidden_password;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>
                                
                            </div>
                        </div>
                            <a href="editAdminProfile.php">Edit Profile</button></a>

                        </fieldset>
                        
                    <!-- progressbar -->
                        

                   
               

                
                </div><!-- /.row -->

                </section><!-- /.content -->

        <!-- add new calendar event modal -->

    </body>
</html>

<?php
            
                
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                die();
                
            } 

        
        
    ?>
