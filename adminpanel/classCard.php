<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Class Card" ;
            $icon = '<i class="fa fa-book"></i>';
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
                    <!-- Small boxes (Stat box) -->

                    <form id="msform" method="POST">
                    <!-- progressbar -->

                        <!-- fieldsets -->
                        <fieldset style="margin-bottom:50px;">
                            <h1 class="fs-title"><b><span class="glyphicon glyphicon-list-alt"></span>  CLASS CARD</b></h1>
                            <?php
                                $sid = $_GET['sid'];
                                $eid = $_GET['eid'];
                                $class = $_GET['class'];
                                $query = $dbh -> query("SELECT DISTINCT CONCAT(s.firstName, ' ', s.lastName) as `student`, skillName as `sn`, 
                                    CONCAT(e.firstName, ' ', e.lastName) as `tutor`,
                                    GROUP_CONCAT(DISTINCT '  ',sc.day, ' ') as `schedule`,
                                    GROUP_CONCAT(DISTINCT '  ',sc.time, ' ') as `time`
                                    FROM student s 
                                    JOIN tutorial t ON s.studentID = t.studID 
                                    JOIN skills sk ON sk.skillID = t.classID
                                    JOIN employee e ON e.employeeID = t.empID
                                    JOIN schedule sc ON sc.studID = s.studentID
                                    WHERE s.studentID = '$sid'");
                                while($row = $query->fetch()){
                                    echo '<p style="text-align:left;"><b>Class Name: </b>'.$row['sn'].'</p>';
                                    echo '<p style="text-align:left;"><b>Student Name: </b>'. $row['student'].'</p>';
                                    echo '<p style="text-align:left;"><b>Tutor: </b>'. $row['tutor'].'</p>';

                                    echo '<p style="text-align:left;"><b>Schedule: </b>'. $row['time']. ' - ' .$row['schedule'].'</p>';
                                    echo '<p style="text-align:left;">
                                            <a href="pdf/class_card.php?sid='.$sid.'&eid='.$eid.'&class='.$class.'" target="_blank">
                                                <button class="btn btn-success btn-xs" type="button">
                                                    <i class="fa fa-file-o"></i> View PDF
                                                </button>
                                            </a>
                                        </p>';
                                }
                            ?>
                     
                            
                            

                            <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                       
                                                <th colspan="1" rowspan="1" style="text-align:center;"><i class="fa fa-calendar"></i> Date</th>
                                                <th colspan="1" rowspan="1" style="text-align:center;"><i class="fa fa-male"></i> Instructor / Substitute</th>
                                                <th colspan="1" rowspan="1" style="text-align:center;"><i class="glyphicon glyphicon-list-alt"></i> Attendance</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                                global $dbh;
                                                $eid = $_GET['eid'];
                                                $sid = $_GET['sid'];


                                                try{
                                                    $query = $dbh->query("SELECT c.date as `d`, CONCAT(e.firstName,' ', e.lastName) as `i`, 
                                                        attendance as `a`                   
                                                                        FROM class c
                                                                        JOIN employee e ON c.instID = e.employeeID
                                                                        JOIN tutorial t ON c.tutorialID = t.tutorialID
                                                                        JOIN student s ON t.studID = s.studentID
                                                                        WHERE t.empID = '$eid' AND s.studentID = '$sid'
                                                                        ORDER BY c.date ");
                                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                    while($row = $query->fetch()){
                                                       
                                                        $attendance = $row['a'];
                                                        $d = date("F d, Y",strtotime($row['d']));
                                                        echo '<tr>';
                                                        echo '<td>'.$d.'</td>';
                                                        echo '<td>'.$row['i'].'</td>';
                                                        if($attendance == 'Present'){
                                                            echo '<td><span  class="label label-success">'.$row['a'].'</span></td>';
                                                        }else if($attendance == 'Absent'){
                                                            echo '<td><span  class="label label-danger">'.$row['a'].'</span></td>';
                                                        }
                                                        
                                                        echo '</tr>';


                                                    }


                                                }catch(PDOException $ex){
                                                    echo $ex->getMessage();
                                                }
                                             ?>
                                        </tbody>
                                    </table>
      

                            <a href="ongoingClasses.php?eid=<?php echo $_GET['eid']?>&type=ongoing"><input type="button" name="next" class="next action-button" value="Back" required/></a>
                        </fieldset>

                        


                    </form>


                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6 connectedSortable"> 
                            <!-- Box (with bar chart) -->
                            <!-- tools box -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-6 connectedSortable">
                            <!-- Map box -->
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
    </body>
</html>
