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
            $title = "Edit Profile";
            include_once "includes/head.php"; 
           // $empid = "111";

            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d");

            global $dbh;

            try {
                $query = $dbh -> prepare("SELECT firstName as `f`, lastName as `l`, 
                    email as `e`, address as `a`, bday as `b`, 
                    picture as  `p`, contactNum as `c`, username, password 
                    FROM employee e JOIN account a ON e.employeeID = a.empID
                    WHERE employeeID = :empid");
                $query -> bindParam(":empid", $id);
                $query -> execute();
                $query ->setFetchMode(PDO::FETCH_ASSOC);

                while($row = $query->fetch()){
                    $fname = $row['f'];
                    $lname = $row['l'];
                    $add = $row['a'];
                    $eadd = $row['e'];
                    $pic = $row['p'];
                    $contact = $row['c'];
                    $username = $row['username'];
                    $password = $row['password'];

                    $birth = $row['b'];
                    $todate = strtotime($birth);
                    $newformat = date('d-m-Y',$todate);

                


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
                                <input type="date" name="birthdate" value="<?php echo $birth ?>" id="birthdate" max="<?php echo $date ?>" required/>

                                <h2 class="fs-title">Profile Picture</h2>
                                <input type="hidden" name="pic" value="<?php echo $pic ?>"/>
                                
                                <i class="fa fa-camera"></i><b>Profile Picture</b></label><br>
                                <input data-label="Upload" class="demo" value="<?php echo $pic ?>" type="file" name="picture" id="picture"/>

                                <h2 class="fs-title">Account Settings</h2>
                                <label for="username" style="float: left;">
                                <i class="fa fa-user"></i>Username</label><input type="text" name="username" value="<?php echo $username ?>" pattern="[a-zA-Z0-9].{5,}" required/>
                                
                                <label for="password" style="float: left;"><i class="fa fa-user"></i>Password</label>
                                <input type="password" name="password" value="<?php echo $password ?>" pattern="[a-zA-Z0-9].{5,}" required/>

                                <label for="password" style="float: left;"><i class="fa fa-user"></i> Confirm Password</label>
                                <input type="password" name="cpassword" value="<?php echo $password ?>" pattern="[a-zA-Z0-9].{5,}" required/>
                                
                                <input type="submit" name="submit" class="submit action-button" value="Save" onclick="return val();" />
                        </fieldset>
                    </form>

                </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->

    </body>
    <script>
    function val()
        {
        if(form.cpassword.value != form.password.value) {
            alert("Password confirmation does not match.");
            return false;
        }

        return true;

        }

    </script>
</html>

<?php
            }   
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                die();
                
            } 
    if(isset($_POST['submit'])){
        $first = $_POST['fname'];
        $last = $_POST['lname'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $pic = $_POST['pic'];
        $contact = $_POST['contact'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $bday = $_POST['birthdate'];
        $convert = strtotime($bday);
        $format = date('Y-m-d',$convert);

        date_default_timezone_set('Asia/Manila');
        $ctime = date("h:i");
        $date = date("Y-m-d");
        $msg = "I updated my profile.";
        $icon = "fa fa-user bg-green";

        echo $db ->editProfileTimeline($id,$msg,$ctime,$date,$icon);

        echo $db -> editProfile($first, $last, $address, $email, $format, $pic, $contact, $username, $password, $id);
        
    }

        
        
    ?>