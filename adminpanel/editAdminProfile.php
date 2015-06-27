<?php 
    include_once "includes/database.php";
    echo $db -> ifLogin();
            $id = $_SESSION['empID'];

            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d");

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
                $query = $dbh -> prepare("SELECT firstName as `fn`, lastName as `ln`, contactNum as `c`, email as `e`, address as `a`, bday as `b`, picture as  `p` FROM employee WHERE employeeID = :empid");
                $query -> bindParam(":empid", $id);
                $query -> execute();

                $row = $query->fetch();
                    $fname = $row['fn'];
                    $lname = $row['ln'];
                    $contact = $row['c'];
                    $add = $row['a'];
                    $eadd = $row['e'];
                    $pic = $row['p'];
                    $d = $row['b'];

                    //$birth = date("F d, Y",strtotime($d));

                $query4 = $dbh -> prepare("SELECT username, password, type FROM account WHERE empID = :empid");
                $query4 -> bindParam(":empid", $id);
                $query4 -> execute();

                $row4 = $query4->fetch();
                    $user = $row4['username'];
                    $password = $row4['password'];
                    $type = $row4['type'];
                
                


                
                   
            
                



        ?>


    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php"; ?>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <form id="msform" name="form" method="POST" enctype="multipart/form-data">
                            <fieldset style="margin-bottom:50px;">
                                <h2 class="fs-title">Profile Details</h2>
                            <?php 
                                if(isset($_GET['s'])){
                                    $s = $_GET['s'];
                                    if($s == 'updated'){
                                        echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                                <a href="#" class="close" data-dismiss="alert">×</a></strong>Profile Updated</strong>
                                            </div>';
                                    }               
                                }
                            ?>
                                <label for="name" style="float: left;"><i class="fa fa-user"></i>&nbsp;Employee Name</label>
                                    
                                    <input type="text" name="fname" value="<?php echo $fname ?>" id="firstName" maxlength="25" pattern="[A-Za-z].{0,}" required/>
                                    <input type="text" name="lname" value="<?php echo $lname ?>" id="lastName" maxlength="25" pattern="[A-Za-z].{0,}" required/>

                                    <label for="address" style="float: left;"><i class="fa fa-road"></i>&nbsp;  Address</label>
                                    <input type="address" name="address" value="<?php echo $add ?>" id="address" maxlength="100" pattern="[A-Za-z].{0,}" required/>

                                    <label for="contact" style="float: left;"><i class="fa fa-mobile-phone"></i>&nbsp;Contact</label>
                                    <input type="text" name="contact" value="<?php echo $contact ?>" id="contact" maxlength="11" pattern="[^a-zA-Z][0-9]{6,}" required/>
                                    
                                    <label for="email" style="float: left;"><i class="fa fa-envelope-o"></i>&nbsp;Email</label>
                                    <input type="email" name="email" value="<?php echo $eadd ?>" id="email" required/>
                                    
                                    <label for="birthdate" style="float: left;"><i class="fa fa-calendar"></i>&nbsp;Birthdate</label>
                                    <input type="date" name="birthdate" value="<?php echo $d ?>" id="birthdate" max="<?php echo $date ?>" required/>

                                    <h2 class="fs-title">Profile Picture</h2>
                                    <input type="hidden" name="pic" value="<?php echo $pic ?>"/>
                                    
                                    <i class="fa fa-camera"></i><b>Profile Picture</b></label><br>
                                    <input data-label="Upload" class="demo" value="<?php echo $pic ?>" type="file" name="picture" id="picture"/>

                                    <h2 class="fs-title">Account Settings</h2>
                                    <label for="username" style="float: left;">
                                    <i class="fa fa-user"></i>Username</label><input type="text" name="username" value="<?php echo $user ?>" pattern="[a-zA-Z0-9].{5,}" required/>
                                    
                                    <label for="password" style="float: left;"><i class="fa fa-user"></i>Password</label>
                                    <input type="password" name="password" value="<?php echo $password ?>" pattern="[a-zA-Z0-9].{5,}" required/>

                                    <label for="password" style="float: left;"><i class="fa fa-user"></i> Confirm Password</label>
                                    <input type="password" name="cpassword" value="<?php echo $password ?>" pattern="[a-zA-Z0-9].{5,}" required/>
                                    
                                    <input type="submit" name="submit" class="submit action-button" value="Save" onclick="return val();" />
                            </fieldset>
                        </form>

                    </div>
                </section><!-- /.content -->

        <!-- add new calendar event modal -->

    </body>
</html>

<?php
            
                
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                die();
                
            } 

        if(isset($_POST['submit'])){
            $first = $_POST['fname'];
            $last = $_POST['lname'];
            $contact = $_POST['contact'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $bday = $_POST['birthdate'];
            $user = $_POST['username'];
            $password = $_POST['password'];
            $pic = $_POST['pic'];
            $convert = strtotime($bday);
            $format = date('Y-m-d',$convert);

            echo $db -> editAdminProfile($first, $last, $contact, $address, $email, $format, $pic, $id, $user, $password);
        }
        
    ?>
