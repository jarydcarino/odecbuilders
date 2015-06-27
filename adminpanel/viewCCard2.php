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
                        

            $sid = $_GET['id'];
            $n = $_GET['n'];
            $c = $_GET['c'];
            $inst = $_GET['i'];
            $tid = $_GET['tid'];
            $type = $_GET['type'];

            $query = $dbh->query("SELECT
                                    CONCAT(s.firstName,' ', s.lastName) as `name`, s.studentID as `sid`,
                                    s.classID as `cn`, sk.skillName as `sn`, GROUP_CONCAT(DISTINCT '  ',ss.day, ' ') as `schedule`, GROUP_CONCAT(DISTINCT '  ',ss.time, ' ') as `time`,
                                    ss.classsched as `status`, s.instid as `inst`, sk.skillID as `cid`, t.tutorialID as `tid`, s.session,e.employeeID as `eid`,
                                    CONCAT(e.firstName,' ', e.lastName) as `tutor`,
                                    s.email as `email`, s.session, s.contact as `contact`
                                    FROM student s
                                    JOIN employee e ON e.employeeID = s.instID
                                    JOIN schedule ss ON ss.studID = s.studentID
                                    JOIN skills sk ON s.classID = sk.skillID
                                    JOIN tutorial t ON t.studID = s.studentID
                                    WHERE ss.classsched = '1' AND t.tutorialID ='$tid' AND e.employeeID = '$inst'
                                    GROUP BY t.studID;
                                    ");
            $row = $query->fetch();
            $tutor=$row['tutor'];
            $day = $row['schedule'];
            $time = $row['time'];
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
                            <?php if($type=="dropped" || $type=="finished"){ ?>
                                <h1 class="fs-title"><b><span class="glyphicon glyphicon-list-alt"></span>  CLASS CARD</b></h1>
                                <p style="text-align:left;"><b>Class Name:</b> <?php echo $c?></p>
                                <p style="text-align:left;"><b>Student Name:</b> <?php echo $n?></p>
                                <p style="text-align:left;">
                                    <a href="pdf/class_card.php?sid=<?php echo $sid;?>&eid=<?php echo $inst?>&class=<?php echo $c;?>" target="_blank">
                                        <button class="btn btn-success btn-xs" type="button">
                                            <i class="fa fa-file-o"></i> View PDF
                                        </button>
                                    </a>
                                </p>
                            <?php }else{?>
                             <h1 class="fs-title"><b><span class="glyphicon glyphicon-list-alt"></span>  CLASS CARD</b></h1>
                                <p style="text-align:left;"><b>Class Name:</b> <?php echo $c?></p>
                                <p style="text-align:left;"><b>Student Name:</b> <?php echo $n?></p>
                                <p style="text-align:left;"><b>Instructor:</b> <?php echo $tutor; ?></p>
                                <p style="text-align:left;"><b>Day:</b> <?php echo $day; ?></p>
                                <p style="text-align:left;"><b>Time:</b> <?php echo $time; ?></p>
                                <p style="text-align:left;">
                                    <a href="pdf/class_card.php?sid=<?php echo $sid;?>&eid=<?php echo $inst?>&class=<?php echo $c;?>" target="_blank">
                                        <button class="btn btn-success btn-xs" type="button">
                                            <i class="fa fa-file-o"></i> View PDF
                                        </button>
                                    </a>
                                </p>
                                <?php } ?>
                            

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

                                                try{
                                                    $query = $dbh->query("SELECT c.date as `d`, CONCAT(e.firstName,' ', e.lastName) as `i`, attendance as `a`                   
                                                                        FROM class c
                                                                        JOIN employee e ON c.instID = e.employeeID
                                                                        JOIN tutorial t ON c.tutorialID = t.tutorialID
                                                                        JOIN student s ON t.studID = s.studentID
                                                                        WHERE t.empID = '$inst' AND s.studentID = '$sid'
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
                 
                            <?php
                                if($type == 'ongoing'){
                                    echo '<a href="classReportOngoing.php"><input type="button" name="next" class="next action-button" value="Back" required/></a>';
                                }else if($type == 'finished'){
                                    echo '<a href="classReportFinished.php"><input type="button" name="next" class="next action-button" value="Back" required/></a>';
                                }else if($type == 'dropped'){
                                    echo '<a href="classReportDropped.php"><input type="button" name="next" class="next action-button" value="Back" required/></a>';
                                }else{
                                    echo '<a href="classReport.php?type=all"><input type="button" name="next" class="next action-button" value="Back" required/></a>';
                                }
                            
                            ?>
                        </fieldset>

                        


                    </form>


                    <!-- Main row -->

                </section><!-- /.content -->

        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
    </body>
</html>
