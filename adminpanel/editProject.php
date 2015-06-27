<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Edit Project";
            $icon = '<i class="fa fa-edit"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";

            date_default_timezone_set("Asia/Manila");
            $date = date("Y-m-d");

            $projID = $_GET['id'];

            global $dbh;

            try {
                $query = $dbh -> prepare("SELECT projectName as `pn`, clientName as `cn`, contactNum as `c`, location as `l`,
                         totalNumHours as `th`, skillReq as `sr`, skillName as `sn`, startdate as  `sd`, duedate as  `dd` FROM project p 
                         JOIN skills sk ON p.skillReq = sk.skillID WHERE projectID = :pid");
                $query -> bindParam(":pid", $projID);
                $query -> execute();

                $query ->setFetchMode(PDO::FETCH_ASSOC);

                while($row = $query->fetch()){
                    $pn = $row['pn'];
                    $cn = $row['cn'];
                    $c = $row['c'];
                    $l = $row['l'];
                    $th = $row['th'] / 60;
                    $sn = $row['sn'];
                    $sd = $row['sd'];
                    $dd = $row['dd'];
                    $sr = $row['sr'];

                    $sd2 = strtotime($sd);
                    $sdate = date("m/d/Y", $sd2);

                    $dd2 = strtotime($dd);
                    $ddate = date("m/d/Y", $dd2);

                    $daterange = $sdate.' - '.$ddate;


        ?>
       
    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php" ?>
                <!-- Main content -->
                <section class="content">

        <?php echo'            <form id="msform" action="includes/projEdit.php?id='.$projID.'" method="POST"> ';?>
                    <!-- progressbar -->

                        <!-- fieldsets -->
                        <fieldset>
                            <h1 class="fs-title"><b><span class="glyphicon glyphicon-edit"></span> Edit Project</b></h1>
                            <?php
                                if(isset($_GET['s'])){
                                    echo '<div class="alert alert-danger" id="alert" style="visibility: true; display: block; width:90%;">
                                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                                        <strong>Error!</strong> The start date is bigger than the due date.
                                    </div>';

                                }
                                
                            ?>
                            <label for="projectTitle" style="float:left;"><i class="fa fa-flag"></i> Project Title</label>
                            <input name="projectTitle" class="form-control" placeholder="Enter Title" type="text" value="<?php echo $pn ?>" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
                            
                            <label for="clientName" style="float:left;"><i class="fa fa-user"></i> Client Name</label><br>
                            <input name="cName" class="form-control" type="text" placeholder="First Name, Last Name" value="<?php echo $cn ?>" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
                            
                            <label for="projectLocation" style="float:left;"><i class="fa fa-mobile-phone"></i> Contact Number</label>
                            <input name="contactnumber" class="form-control" placeholder="eg. 09xxxxxxxxx" pattern="(0[0-9]{10})" type="text" maxlength="11" value="<?php echo $c ?>" required/>

                            <label for="projectLocation" style="float:left;"><i class="fa fa-map-marker"></i> Project Location</label>
                            <input name="projectLocation" class="form-control" placeholder="Location" type="text" value="<?php echo $l ?>" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>

                            <label for="hours" style="float:left;"><i class="fa fa-clock-o"></i> Total No. of Hours for Completion</label>
                            <input name="hours" class="form-control" type="text" placeholder="Input Number" value="<?php echo $th ?>" pattern="\d+" maxlength="5" required/>
                            
                            <label for="hours" style="float:left;"><span class="glyphicon glyphicon-fire"></span> Skills Required</label><br>
                            <div>
                                <?php
                                    global $dbh;
                                    try{
                                        echo '<select required class="form-control" name="skillreq" style="width:100%;">';
                                                                
                                        $query2 = $dbh->query('SELECT skillID as `sid`, skillName as `sn` FROM skills') ;
                                        $query2 -> setFetchMode(PDO::FETCH_ASSOC);
                                        echo "<option value=".$sr." selected>".$sn."</option>"; 

                                        while($row2 = $query2 -> fetch()){
                                            
                                            echo "<option value=".$row2['sid'].">".$row2['sn']."</option>";
                                        }

                                            echo "</select>";
                                        
                                        }catch(PDOException $ex){
                                            echo $ex->getMessage();
                                            die();
                                        }
                                ?>
                            </div><br>
                            
                            <!--<label style="float:left;"><i class="fa fa-calendar"></i> Start Date</label>
                            <input type="date" class="form-control" name="startDate" value="<?php echo $sd ?>" required/>
                  

                            <label style="float:left;"><i class="fa fa-calendar"></i> Due Date</label>
                            <input type="date" class="form-control" name="dueDate" value="<?php echo $dd ?>" min="<?php echo $date ?>" required/>-->
                            <label for="dates" style="float:left;"><i class="fa fa-calendar"></i> Date Range</label>
                            <input type="text" class="form-control" id="reservation" name="dates" value="<?php echo $daterange;?>" required/>
                            
                          

                            <input type="submit" name="edit" value="Edit Project" class="submit action-button"/><br>
                            <a href="assignDraftsman.php">BACK TO ASSIGN DRAFTSMAN</button></a>


                        </fieldset>



                    </form> 

                </section><!-- /.content -->


        <?php 
            }
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                die();
                
            } 

          // if(isset($_POST['edit'])){
          //   $projTitle= $_POST['projectTitle'];
          //   $name= $_POST['cName'];
          //   $phone= $_POST['contactnumber'];
          //   $projLoc= $_POST['projectLocation'];
          //   $totalNoHours= $_POST['hours'];
          //   $hoursInMin = $totalNoHours * 60;

          //   $skill= $_POST['skillreq'];
          //   $sDate= $_POST['startDate'];
          //   $dDate= $_POST['dueDate'];
          //   $status = "ongoing";
          //   date_default_timezone_set('Asia/Manila');
          //   $time = date("h:i");
          //   $date = date("Y-m-d");
          //   $msg = "<b>PROJECT: " .$projTitle."</b> has been edited.";
          //   $icon = "fa fa-briefcase bg-blue";

          //   echo $db-> editProject($projTitle,$name,$phone,$projLoc,$hoursInMin,$skill,$sDate,$dDate,$status,$time,$date,$id,$msg,$icon);  

          // }
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