<?php 
    include_once "includes/database.php";
    echo $db -> ifLogin();
     $id = $_SESSION['empID'];
?>



<!DOCTYPE html>
<html>
    <head>
        <?php 
            $icon = '<i class="fa fa-plus-square"></i>';
            $title = "Apply for Leave" ;
            include_once "includes/head.php";

            date_default_timezone_set("Asia/Manila");
            $date = date("Y-m-d");
            
           // $empid = "111";
        ?>
    </head>
    <body class="skin-blue">
            <?php include_once "includes/navigation.php"; ?>

                <!-- Main content -->
                <section class="content">

                    
                    <div class="row">
                         <form id="msform" method="POST" enctype="multipart/form-data">

                            <fieldset style="margin-bottom:50px;">
                                <h2 class="fs-title">Apply For Leave</h2>
                                <?php 
                                    if(isset($_GET['s'])){
                                        $s = $_GET['s'];
                                        if($s == 'success'){
                                            echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                                    <a href="#" class="close" data-dismiss="alert">×</a>
                                                    <strong>Leave application submitted for approval.</strong>
                                                </div>' ;
                                        }else if($s == 'date'){
                                            echo '<div class="alert alert-danger" id="alert" style="visibility: true; display: block; width:90%;">
                                                    <a href="#" class="close" data-dismiss="alert">×</a>
                                                    <strong>Error!</strong> The start date is bigger than the end date.
                                                </div>' ;
                                        }               
                                    }
                                ?>
                                <label for="leavetype" style="float: left;"><i class="fa fa-flag"></i> Leave Type</label><br>
                                    <select class="form-control" name="ltype" required>
                                        <option value="sick">Sick</option>
                                        <option value="maternity">Maternity</option>
                                        <option value="vacation">Vacation</option>
                                        <option value="others">Others</option>
                                    </select>

                                <label for="remarks" style="float: left;"><i class="fa fa-flag"></i> Reason</label>
                                    <textarea id="remarks" class="form-control" style="height:200px;" placeholder="What is the reason?" name="reason" required></textarea>
                                
                                <label for="dates" style="float:left;"><i class="fa fa-calendar"></i> Date Range</label>
                            <input type="text" class="form-control" id="reservation" name="dates" placeholder="Choose a Date" required/>

                                <input type="submit" name="submit" class="submit action-button" value="Apply" required/>
                            </fieldset>
                         </form>
                        
                    </div><!-- /.row -->

                </section><!-- /.content -->


            </aside><!-- /.right-side -->



        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        

    </body>
</html>
<?php
if(isset($_POST['submit'])){
        $type = $_POST['ltype'];
        $reason = $_POST['reason'];
       

        //start date
       /* $start = $_POST['start'];
        $convert1 = strtotime($start);
        $newstart = date('Y-m-d',$convert1);
       



        //end date
        $end = $_POST['end'];
        $convert2 = strtotime($end);
        $newend = date('Y-m-d',$convert2);*/

        $dates = $_POST['dates'];
        $d = explode("-", $dates);
        $start = strtotime($d[0]);
        $due= strtotime($d[1]);
        $sDate = date('Y-m-d',$start);
        $dDate = date('Y-m-d',$due);
       

        $dateSent = date("Y-m-d");
       

        $affirm = 0;

        if($start > $due){
                echo '<script>window.location="applyLeave.php?s=date";</script>';
            }else{
        echo $db -> applyLeave($id, $sDate, $dDate, $dateSent, $reason, $affirm, $type);
        }
    } 
?>
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