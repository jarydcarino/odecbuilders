<?php
    include_once "includes/database.php";
     echo $db -> ifLogin();
     $id = $_SESSION['empID']; 

     $nt = $_GET['nt'];

            global $dbh;
            try{
            $query = $dbh->prepare("UPDATE notification SET status='Seen' WHERE notifID=:nt ");
            $query -> bindParam(":nt", $nt);
            $query -> execute();
        }catch (PDOException $e) {
    
        }
?>


<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Classes";
            $icon = '<i class="fa fa-book"></i>';
            include_once "includes/head.php" ;
        ?>

        <script>
            function showStudents(str) {
                if (str == "") {
                    document.getElementById("contents").innerHTML = "";
                    return;
                } else { 
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("contents").innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET","includes/showStudents.php?q="+str,true);
                    xmlhttp.send();
                }
            }

            /*function hideModal(e){
                $(".modalDialog").hide();
                e.preventDefault();
            }*/
        </script>

    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php" ?>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                    <div class="col-md-12">
                            <div class="box box-primary" style="width:100%; margin: auto;">
                                
                                <div class="box-header">
                                    <h3 class="box-title"><i class = "fa fa-book"></i> My Classes</h3>
                                </div>

                                
                                    <div class="box-body" >
                                        <?php 
                                        if(isset($_GET['s'])){
                                           $s = $_GET['s'];
                                           $student = $_GET['st'];
                                           if($s == 'p'){

                                                echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                                    <a href="#" class="close" data-dismiss="alert">×</a><strong>'
                                                    .$student. '</strong> has been marked present.
                                                 </div>' ;
                                            
                                            }elseif($s == 'a'){

                                                echo '<div class="alert alert-danger" id="alert" style="visibility: true; display: block; width:90%;">
                                                    <a href="#" class="close" data-dismiss="alert">×</a><strong>'
                                                     .$student.'</strong> has been marked absent.
                                                 </div>'  ;  
                                            }elseif($s == 'f'){
                                                echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                                    <a href="#" class="close" data-dismiss="alert">×</a><strong>'
                                                     .$student.'</strong> has finished the required session for his/her class.
                                                 </div>'  ; 
                                            }elseif($s == 'd'){
                                                echo '<div class="alert alert-danger" id="alert" style="visibility: true; display: block; width:90%;">
                                                    <a href="#" class="close" data-dismiss="alert">×</a><strong>'
                                                     .$student.'</strong> has been dropped.
                                                 </div>'  ; 
                                            }
                                        }
                                        ?>

                                        <div class="form-group">
                                            <label>Class Name:</label>
                                            <select class="form-control" name="subject" onchange="showStudents(this.value)">
                                                <option value="">Select subject:</option>
                                               <?php 
                                                    $query=$dbh->query("SELECT se.skillID as 'sid', s.skillName as 'sn' FROM `employee` e 
                                                                    JOIN skillemp se ON e.employeeID=se.empID
                                                                    JOIN skills s ON s.skillID = se.skillID
                                                                    WHERE employeeID='$id' AND skillType='class'" );
                                                    while($row = $query->fetch()){
                                                        echo '<option value='.$row['sid'].'>'.$row['sn'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                      
                                           <!-- <div class="form-group">
                                               <button type="submit" name="submit" class="btn btn-primary btn-lg"> VIEW CLASS </button>
                                            </div>-->
                                   
                                

                                <div id="contents"></div>


                            </div><!--primary-->
                        </div>

                         
                    </div><!-- /.row -->

                    <!-- top row -->
                    <div class="row">
                        <div class="col-xs-12 connectedSortable">
                            
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->

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