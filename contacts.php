<?php include_once "includes/database.php"; ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--//> <html class="no-js"> <!--<![endif]-->
<head>
    <?php include_once "includes/script.php"; ?>
</head>

<body>

    <!--Header-->
    <header class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <?php include_once "includes/navigation.php";
                      include_once "includes/database.php";          
                            
                 ?>
            </div>
        </div>
    </header>
    <!-- /header -->

        <section class="title">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <h1>Contact Us</h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li class="active">Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->

    <section id="contact-page" class="container">
        <div class="row-fluid">

            <div class="span8">
                <h4>Contact Form</h4>
               <div class="alert alert-success" id="alert" align="center" style="visibility: true; display: block; width:90%;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <h4><strong>Inquiry Sent!</strong><h4>
                </div>  


                <form method="POST">
                  <div class="row-fluid">
                        <div class="span5">
                        <label>First Name</label>
                        <input type="text" name="fname" class="input-block-level" required="required" placeholder="Your First Name">
                        <label>Last Name</label>
                        <input type="text" name="lname" class="input-block-level" required="required" placeholder="Your Last Name">
                        <label>Email Address</label>
                        <input type="email" name="email" class="input-block-level" required="required" placeholder="Your email address" data-error="Please input a valid email address">

                        <br>
                        <h4>Our Address</h4>
                        <p>
                            <i class="icon-map-marker pull-left"></i> Rm. 302 Laperal Bldg. Session Rd. Baguio City<br>
                                                                        Benguet, 2600, Philippines
                        </p>
                        <p>
                             <i class="icon-envelope"></i> &nbsp;ololrenders@gmail.com
                         </p>
                         <p>
                             <i class="icon-phone"></i> &nbsp;(+63)915-9525-811<br>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(+074)244-1681
                         </p>
                    </div>
                    <div class="span7" >
                        <label>Message</label>
                        <textarea name="message" id="message" required="required" class="input-block-level" rows="8"></textarea>
                        <br>
                        <br>
                        <input type="submit" value="Send Message" name="subs" class="btn btn-primary"></input> <!--function to -->
                     <p> </p>
                    </div>

                </div>
                           </form>
        </div>

        <div class="span3">
            <h4>We are located here!</h4>

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d956.8136059642566!2d120.59786795337298!3d16.411899924923492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a142ae06faad%3A0xdf5b59d7c6510bfe!2sLaperal+Bldg%2C+Diego+Silang+St%2C+Baguio%2C+Benguet!5e0!3m2!1sen!2sph!4v1426604712845" width="400" height="400" frameborder="0" style="border:0"> 
            </iframe>


        </div>

    </div>



</section>

<!--Footer-->
<footer>
<?php include_once "includes/footer.php"; ?>
</footer>
<!--/Footer-->

<!--  Login form -->

<!--  /Login form -->

<script src="js/vendor/jquery-1.9.1.min.js"></script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/main.js"></script>   

<?php

        if(isset($_POST['subs'])){

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $dateSent = date("Y-m-d");

            global $dbh;
                try{
                        $query = $dbh -> prepare("INSERT INTO inquiries(firstName, lastName, email, message, dateSent) VALUES (:fname,:lname, :email, :message, :dateSent)");
                        $query -> bindParam(':fname',$fname);
                        $query -> bindParam(':lname',$lname);
                        $query -> bindParam(':email',$email);   
                        $query -> bindParam(':message',$message);
                        $query -> bindParam(':dateSent',$dateSent);
                        $query -> execute();

                        echo "<script> window.location='contacts.php' </script>";

                }catch(PDOException $ex){
                    echo $ex->getMessage();
            }
            
        }
        
   


?>



</body>
</html>


<?php  

   
        if(isset($_POST['add'])){

        $first = $_POST['fname'];
        $last = $_POST['lname'];
        $email = $_POST['emailAdd'];
        $message = $_POST['message'];


        echo $db -> insertFeedback($first, $last, $email, $message);

        }



?>
