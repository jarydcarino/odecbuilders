<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Add Project";
            $icon = '<i class="fa fa-edit"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
        ?>
       
    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php" ?>
                <!-- Main content -->
                <section class="content">

                    <form id="msform" method="POST">
                    <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active">Step 1</li>
                            <li style="margin-left:400px;">Finish</li>
                        </ul>
                        <!-- fieldsets -->
                        <fieldset>
                            <h1 class="fs-title"><b><span class="glyphicon glyphicon-plus"></span>  Add Project</b></h1>
                            <div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Success!</strong> Add Project successful.
                            </div>
                            <label for="projectTitle" style="float:left;"><i class="fa fa-flag"></i> Project Title</label>
                            <input name="projectTitle" class="form-control" placeholder="Enter Title" type="text" required/>
                            
                            <label for="clientName" style="float:left;"><i class="fa fa-user"></i> Client Name</label><br>
                            <input name="cName" class="form-control" type="text" placeholder="First Name, Last Name" required/>
                            
                            <label for="projectLocation" style="float:left;"><i class="fa fa-mobile-phone"></i> Contact Number</label>
                            <input name="contactnumber" class="form-control" placeholder="eg. 09xxxxxxxxx" type="text" required/>

                            <label for="projectLocation" style="float:left;"><i class="fa fa-map-marker"></i> Project Location</label>
                            <input name="projectLocation" class="form-control" placeholder="Location" type="text" required/>

                            <input type="button" name="next" class="next action-button" value="Next" required/>
                        </fieldset>

                        <fieldset>
                            <h1 class="fs-title"><b><span class="glyphicon glyphicon-plus"></span>  Add Project</b></h1>

                            <label for="hours" style="float:left;"><i class="fa fa-clock-o"></i> Total No. of Hours for Completion</label>
                            <input name="hours" class="form-control" type="text" placeholder="Input Number" required/>
                            
                            <label for="hours" style="float:left;"><span class="glyphicon glyphicon-fire"></span> Skills Required</label><br>
                            <div>
                                <?php
                                    global $dbh;
                                    try{
                                        echo '<select class="form-control" name="skillreq" style="width:100%;">';
                                                                
                                        $query = $dbh->query('SELECT skillID as `sid`, skillName as `sn` FROM skills') ;
                                        $query -> setFetchMode(PDO::FETCH_ASSOC);
                                        echo '<option ></option>'; 

                                        while($row = $query -> fetch()){
                                            echo "<option value=".$row['sid'].">".$row['sn']."</option>";
                                        }

                                            echo "</select>";
                                        
                                        }catch(PDOException $ex){
                                            echo $ex->getMessage();
                                            die();
                                        }
                                ?>
                            </div><br>
                            
                            <label style="float:left;"><i class="fa fa-calendar"></i> Start Date</label>
                            <input type="date" class="form-control" name="startDate" required/>
                  

                            <label style="float:left;"><i class="fa fa-calendar"></i> Due Date</label>
                            <input type="date" class="form-control" name="dueDate" required/>
                          

                            <input type="button" name="previous" class="previous action-button" value="Previous" />
                            <input type="submit" name="add" value="Add Project" class="submit action-button"/>
                        </fieldset>


                    </form> 

                </section><!-- /.content -->



        <?php 

          if(isset($_POST['add'])){
            $projTitle= $_POST['projectTitle'];
            $name= $_POST['cName'];
            $phone= $_POST['contactnumber'];
            $projLoc= $_POST['projectLocation'];
            $totalNoHours= $_POST['hours'];
            $hoursInMin = $totalNoHours * 60;

            $skill= $_POST['skillreq'];
            $sDate= $_POST['startDate'];
            $dDate= $_POST['dueDate'];
            $status = "ongoing";
            date_default_timezone_set('Asia/Manila');
            $time = date("h:i");
            $date = date("Y-m-d");
            $msg = "<b>PROJECT: " .$projTitle."</b> has been added.";
            $icon = "fa fa-briefcase bg-blue";

            echo $db-> addProject($projTitle,$name,$phone,$projLoc,$hoursInMin,$skill,$sDate,$dDate,$status,$time,$date,$id,$msg,$icon);  

          }
        ?>


    </body>
</html>