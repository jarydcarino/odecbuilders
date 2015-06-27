<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Substitution";
            $icon = '<i class="fa fa-edit"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";

            $tid = $_GET['id'];
            $n = $_GET['n'];
            $c = $_GET['c'];
            $i = $_GET['i'];
            $session = $_GET['sess'];
            $sid = $_GET['sid'];
           // $seid = $_GET['id'];

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
                            <h1 class="fs-title"><b><span class="glyphicon glyphicon-check"></span>  Substitution</b></h1>

                            <p style="text-align:left;"><b>Student Name:</b> <?php echo $n ?></p>
                            <p style="text-align:left;"><b>Class Name:</b> <?php echo $c ?></p><br>

                            <label style="float:left;"><i class="fa fa-calendar"></i> Date of Substitution:</label>
                            <input type="date" class="form-control" name="subDate" required/>
                            
                            <label for="hours" style="float:left;"><span class="glyphicon glyphicon-user"></span> Employee Name</label><br>
                            <div>
                                <?php
                                    global $dbh;
                                    try{
                                        echo '<select required class="form-control" name="employeeName" style="width:100%;">';
                                                                
                                        $query = $dbh->query("SELECT CONCAT(e.firstName,' ', e.lastName) as `name`, e.employeeID as `eid` FROM employee e
                                                            JOIN account a ON a.empID = e.employeeID 
                                                        
                                                            WHERE a.type = 'Tutorial'") ;
                                        $query -> setFetchMode(PDO::FETCH_ASSOC);
                                        echo '<option ></option>'; 

                                        while($row = $query -> fetch()){
                                            echo "<option value=".$row['eid'].">".$row['name']."</option>";
                                        }

                                            echo "</select>";
                                        
                                        }catch(PDOException $ex){
                                            echo $ex->getMessage();
                                            die();
                                        }
                                ?>
                            </div><br>

                            <label for="hours" style="float:left;"><span class="glyphicon glyphicon-user"></span> Attendance</label><br>
                            <select required class="form-control" name="att" style="width:100%;">
                                <option value='Present'>Present</option>
                                <option value='Absent'>Absent</option>
                            </select>
                            
                  

                            <a href='listOfClasses.php'><input type="button" class="submit action-button"value="Back" /></a>
                            <input type="submit" name="add" value="Done" class="submit action-button"/>
                        </fieldset>


                    </form> 

                </section><!-- /.content -->


        <?php 

          if(isset($_POST['add'])){

            //$tid = $i;
            $eid = $_POST['employeeName'];;
            $subdate = $_POST['subDate'];
            $attendance = $_POST['att'];



            echo $db-> substitute($tid,$eid,$subdate,$attendance,$id); 
            echo $db-> updateSession($session,$sid);

          }
        ?>


    </body>
</html>