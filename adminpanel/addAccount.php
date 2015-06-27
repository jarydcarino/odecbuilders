
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Add Employee";
            $icon = '<i class="fa fa-group"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
                        

        ?>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php include_once "includes/navigation.php" ?>

                <!-- Main content -->
                <section class="content">


                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                
                                <div class="box-header">
                                    <h3 class="box-title"><i class="fa fa-group"></i> Personal Details</h3>
                                </div>

                                <form method="POST" data-toggle="validator">
                                    <div class="box-body">

                                         <div class="form-group"> 
                                            <label for="username" class="control-label"><i class="fa fa-user"></i> Username</label>
                                            <input name="username"id="username" placeholder = "Username" class="form-control" type="text" style="width:45%;" data-error="Please fill this up." required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        
                                        <div class="form-group"> 
                                            <label for="clientName" class="control-label"><i class="fa fa-user"></i> Password</label><br>
                                            <input name="password" id="password" class="form-control" type="password" placeholder="Password" style="width:45%; display:inline-block;" data-error="Please fill this up." required> 
                                            <input name="cpassword" id="cpassword" class="form-control" type="password" placeholder="Confirm Password" style="width:45%;  display:inline-block;" data-error="Please fill this up." data-match="#password" data-match-error="Whoops, these don't match" required>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="type" class="control-label"><i class="fa fa-user"></i> Employee Type</label>
                                            <div class="radio">
                                              <label>
                                                <input type="radio" name="type" value="Draftsman" required>
                                                Draftsman
                                              </label>
                                            </div>
                                            <div class="radio">
                                              <label> 
                                                <input type="radio" name="type" value="Tutor" required>
                                                Tutor
                                              </label>
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <input name="submit" type="submit" value="Submit" class="btn btn-success" style="width: 180px; height: 50px;"/>
                                        </div>

                                    </div>
                                


                            </div><!--primary-->
                        </div>
                        
                        </form>
                                
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    



                     

                
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        
    </body>
</html>

<?php  

    global $dbh;
    try {
        if(isset($_POST['submit2'])){
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $type = $_POST['type'];
            $empid = $_GET['id'];


            echo $db -> addAccount($empid,$user,$pass,$type);
            
        }
        
    } catch (PDOException $e) {
        
    }

    if(isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];

        echo $db -> addEmployee($fname,$lname,$contact,$address,$email,$birthdate);
    }

?>