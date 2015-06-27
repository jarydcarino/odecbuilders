<?php
     include_once "includes/database.php";
     echo $db -> ifLogin();
     $id = $_SESSION['empID'];
     $icon = '<i class="fa fa-folder"></i>';
     $title = "Overview";
    date_default_timezone_set('Asia/Manila');
    $date=date('Y-m-d');
?>

<!DOCTYPE html>
<html>
    <head>
        <?php

         include_once "includes/head.php"; 

         ?>

         <script>
            function showButtons(str) {
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
                    xmlhttp.open("GET","includes/showButtons.php?q="+str,true);
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
        <!-- header logo: style can be found in header.less -->
        <?php include_once "includes/navigation.php" ?>


            <!-- Right side column. Contains the navbar and content of the page -->
            <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <div class="box-title">Project TimeIn/TimeOut</div><br>
                                    <div class="box-body">
                                         <div class="form-group">

                                         <form method="POST" action="">
                                            <label><br>Project Name:</label>
                                            <?php
                       

                                                
                                                        if(isset($_GET['s'])){
                                                            $s = $_GET['s'];
                                                            if($s == 'timeout'){
                                                                echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                                <strong>Success!</strong> Time Out Project Successful.
                                                            </div>';

                                                            }else if($s == 'ext'){
                                                                echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                                <strong>Success!</strong> You have requested for an extension.
                                                            </div>';

                                                            }else if($s == 'timein'){
                                                                echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                                <strong>Success!</strong> The time is now recorded.
                                                            </div>';
                                                            }

                                                        }
                                                        
                                                    ?>
                                            <select name="option" class="form-control" onchange="showButtons(this.value)">
                                                <option value=""></option>
                                             <?php echo $db -> fetchProjects($id); ?>
                                            </select>
                                            <div class="box-footer">
                                                <label style="margin-left:140px;"></label><br>
                                                <div id="contents"></div>
                                            </div>     
                                      </div>
                                    </div>                                  
                                </div><!-- /.box-header -->
                                </form>
                            </div><!-- /.box -->
                        </div>



                        <div class="col-xs-6">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"><i class="fa fa-tasks"></i> List of Ongoing Projects</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr role="row">
                                            <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Project Name</th> 
                                            <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Due Date</th> 
                                            <th colspan="1" rowspan="1"><i class="fa fa-check-circle-o"></i> Time Remaining</th>
                                            <th colspan="1" rowspan="1"><i class="fa fa-check-circle-o"></i> Logs</th>  
                                    </thead>
                                        <tbody>
                                             <?php echo $db -> fetchOngoingProjects($id); ?>
                                    </tbody></table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                       
                               
                                    <?php

                                    $query = $dbh->query("SELECT TIMESTAMPDIFF(DAY,CURDATE(),duedate) as `diff`,projectName as `pn` FROM project WHERE `draftsmanID` = '$id' AND status = 'ongoing'");
                                    $query -> execute();
                                    $temp = 1;
                                    while($row = $query->fetch()){
                                        if($row['diff'] == 1){
                                            if($temp == 1){
                                            echo"<div class='col-xs-6'>
                                            <div class='box'>
                                            <div class='box-header'>
                                            <h3 class='box-title'><i class='fa fa-warning'></i> NOTICE!!</h3>
                                             
                                            <div class='box-body'>
                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Project: ".$row['pn']." is due tommorow.  
                                            ";
                                            $temp = 2;
                                            }else{
                                                echo "     
                                                <div class='box-body'>
                                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br>Your Project: ".$row['pn']." is due tommorow. 
                                                ";
                                            }
                                        }elseif($row['diff'] == 0){
                                            if($temp == 1){
                                            echo"<div class='col-xs-6'>
                                            <div class='box'>
                                            <div class='box-header'>
                                            <h3 class='box-title'><i class='fa fa-warning'></i> NOTICE!!</h3></br>
                                                
                                            <div class='box-body'>
                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Project: ".$row['pn']." is due today. 
                                            ";
                                            $temp = 2;
                                            }else{
                                                echo "     
                                                <div class='box-body'>
                                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br>Your Project: ".$row['pn']." is due today. 
                                                ";
                                            }
                                         //do nothing  
                                        }
                                    }
                                ?>
                            
                       </div>
                       </div>
                       </div>
                </section><!-- /.content -->
    </body>
</html>

<?php
    global $dbh;
    if(isset($_POST['punchin'])){
            
            $id = $_SESSION['empID'];;
            $choice = $_POST['option'];
            $timeIN = $_POST['ti'];
            $timeOUT = $_POST['to'];
            $date1 = $_POST['date1'];
            $date2 = $_POST['date2'];
            $pid = $_POST['pid'];

            if($date1 > $date2){
                 echo '<div id="punchin" class="modalDialog text-center" style="margin-top:-50px">
                           <div class="modal-dialog">
                               <div class="modal-header">
                               <h10>ERROR!!</h10>
                               </div>
                               <div class="modal-body">
                               <div class="alert alert-danger">
                               <h5>Invalid TimeIn Date and TimeOut Date!</h5>
                               </div>
                               
                                </div>
                               <div class="modal-footer">
                               <a href=javascript:history.go(-2)><button class="btn btn-default" type="button">BACK</button></a>
                               </div>
                           </div>
                       </div>';
            }else{
            $db -> timeIn($id,$choice,$date1,$date2,$timeIN,$timeOUT,$pid);}

          }
?>