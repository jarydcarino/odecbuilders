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

            date_default_timezone_set("Asia/Manila");
            $date = date("Y-m-d");
            

        ?>
       
    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php" ?>
                <!-- Main content -->
                <section class="content">

                    <form id="msform" method="POST">
                    <!-- progressbar -->

                        <!-- fieldsets -->
                        <fieldset>
                            <h1 class="fs-title"><b><span class="glyphicon glyphicon-plus"></span>  Add Project</b></h1>
                            <?php
                                if(isset($_GET['s'])){
                                    echo '<div class="alert alert-danger" id="alert" style="visibility: true; display: block; width:90%;">
                                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                                        <strong>Error!</strong> The start date is bigger than the due date.
                                    </div>';

                                }
                                
                            ?>
                             
                                        
                                    
                            <label for="projectTitle" style="float:left;"><i class="fa fa-flag"></i> Project Title</label>
                            <input name="projectTitle" class="form-control" placeholder="Enter Title" type="text" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
                            
                            <label for="clientName" style="float:left;"><i class="fa fa-user"></i> Client Name</label><br>
                            <input name="cName" class="form-control" type="text" placeholder="First Name, Last Name" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
                            
                            <label for="projectLocation" style="float:left;"><i class="fa fa-mobile-phone"></i> Contact Number</label>
                            <input name="contactnumber" pattern="(0[0-9]{10})" class="form-control" placeholder="eg. 09xxxxxxxxx" type="text" maxlength="11" required/>

                            <label for="projectLocation" style="float:left;"><i class="fa fa-map-marker"></i> Project Location</label>
                            <input name="projectLocation" class="form-control" placeholder="Location" type="text" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>

                            <label for="hours" style="float:left;"><i class="fa fa-clock-o"></i> Total No. of Hours for Completion</label>
                            <input name="hours" class="form-control" type="text" placeholder="Input Number" pattern="\d+" maxlength="5" required/>
                            
                            <label for="hours" style="float:left;"><span class="glyphicon glyphicon-fire"></span> Skills Required</label><br>
                            <div>
                                <?php
                                    global $dbh;
                                    try{
                                        echo '<select required class="form-control" name="skillreq" style="width:100%;">';
                                                                
                                        $query = $dbh->query('SELECT skillID as `sid`, skillName as `sn` FROM skills WHERE stat="enabled"') ;
                                        $query -> setFetchMode(PDO::FETCH_ASSOC);
                                        echo '<option></option>'; 

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

                            <label for="dates" style="float:left;"><i class="fa fa-calendar"></i> Date Range</label>
                            <input type="text" class="form-control" id="reservation" placeholder="Select the Date Range" name="dates" required/>
                            <?php
                            
                            /*echo '<label style="float:left;"><i class="fa fa-calendar"></i> Start Date</label>
                            <input type="date" class="form-control" id="myDate" name="startDate" min="'.$date.'" required/>';


                            echo '<label style="float:left;"><i class="fa fa-calendar"></i> Due Date</label>
                            <input type="date" class="form-control" name="dueDate" min="'.$date.'" required/>
                            </form>';*/

                            ?>
                          

                            <input type="submit" name="add" value="Add Project" class="submit action-button"/>
                            <input type="reset" value="Clear" class="submit action-button">

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
            //$sDate= $_POST['startDate'];
            //$dDate= $_POST['dueDate'];
            $dates = $_POST['dates'];
            $d = explode("-", $dates);
            $start = strtotime($d[0]);
            $due= strtotime($d[1]);
            $sDate = date('Y-m-d',$start);
            $dDate = date('Y-m-d',$due);

            $status = "ongoing";
            date_default_timezone_set('Asia/Manila');
            $time = date("h:i");
            $date = date("Y-m-d");
            $msg = "<b>PROJECT: " .$projTitle."</b> has been added.";
            $icon = "fa fa-briefcase bg-blue";


            if($sDate > $dDate){
                echo '<script>window.location="addProject.php?s=date";</script>';
            }else{
                echo $db-> addProject($projTitle,$name,$phone,$projLoc,$hoursInMin,$skill,$sDate,$dDate,$status,$time,$date,$id,$msg,$icon); 
            }

             

          }
        ?>


    </body>
</html>

<script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

<script type="text/javascript">
            $(function() {
                //Datemask dd/mm/yyyy
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
                $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
                //Money Euro
                $("[data-mask]").inputmask();

                //Date range picker
                var dateToday = new Date(); 
                var newDate = new Date(dateToday.getFullYear(), dateToday.getMonth(), dateToday.getDate());
                $('#reservation').daterangepicker({ startDate: newDate, minDate: newDate});;
               ;
            });
        </script>
