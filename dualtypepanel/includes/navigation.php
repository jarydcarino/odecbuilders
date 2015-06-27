<?php
    include_once "includes/database.php";
    global $dbh;
    $eid = $_SESSION['empID'];

    try {
         $query = $dbh -> prepare("SELECT firstName as 'f', lastName as 'l', picture as 'p' FROM employee WHERE employeeID = :empid");
         $query -> bindParam(":empid",$id);
         $query -> execute();
         $query ->setFetchMode(PDO::FETCH_ASSOC);

         while($row = $query->fetch()){

            $fname = $row['f'];
            $lname = $row['l'];
            $pic = $row['p'];

               $query2 = $dbh->prepare("SELECT id, proj_id as `pid`, status as `to` FROM projwork WHERE eID = ? AND `id` = (SELECT MAX(id) ) ORDER BY id DESC LIMIT 1");
               $passval= array($id);
               $query3 = $dbh->prepare("SELECT COUNT(timeOut) as `count` FROM projwork WHERE eID = ? AND `id` = (SELECT MAX(id) ) ORDER BY id DESC LIMIT 1");
               $query2 ->execute($passval);
               $query3 -> execute($passval);
               $row3 = $query3 ->fetch();
               $row2 = $query2 ->fetch();
               $pid = $row2['pid'];
               $count = $row3['count'];
               $timout = $row2['to'];
               $query = $dbh->prepare("SELECT type FROM account WHERE type=? ");
               
               if($timout == NULL){
                    $temp = "projects";
               }elseif($timout == 1){
                    $temp = "projects2";
               }elseif($count == 0){
                    $temp = "projects";
               }else{
                    $temp = "projects";
               }

?>









<!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="img/logo.png" alt="logo" class="logo">
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right" id="refresh">
                    <ul class="nav navbar-nav">
                        <!-- Notifications: style can be found in dropdown.less -->
                       <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-globe"></i>
                                        <?php echo $db -> fetchnotif($id); ?> 
                                    </ul>
                                </li>
                                <li class="footer"><a href='notifView.php?id=<?php echo $eid;?>'>View all</a></li>
                            </ul>
                        </li>
       
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Notifications: style can be found in dropdown.less -->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $fname; echo ' '; echo $lname; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo $pic?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $fname; echo ' '; echo $lname; ?>
                                        <small>Draftsman/Tutor</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div style="text-align:center;">

                                        <a href="../logout.php" class="btn btn-warning btn-sm" style=" font-size:15px; width:60%;"><span class="glyphicon glyphicon-off"></span></a>
                                        <a href="viewProfile.php" class="btn btn-default btn-sm"><i class="fa fa-user"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo $pic; ?>" class="img-circle" alt="User Image" onError="this.onerror=null;this.src='../adminpanel/img/users/default.jpg';" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $fname; ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li>
                            <a href="index.php">
                                <i class="fa fa-home"></i> <span>Home</span>
                            </a>
                        </li>


                        <li>
                            <a href="<?php echo $temp ?>.php?pid=<?php echo $pid;?>">
                                <i class="fa fa-folder"></i> <span>Projects</span>
                            </a>
                        </li>

                        <li>
                            <a href="tutClasses.php">
                                <i class="fa fa-th"></i> <span>Classes</span>
                            </a>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-print"></i> <span>Reports</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="projectReport.php?type=all"><i class="fa fa-angle-double-right"></i> My Project Reports</a></li>
                                <li><a href="reportClass.php?type=all"><i class="fa fa-angle-double-right"></i> My Class Reports</a></li>
                                <li><a href="leaveReports.php"><i class="fa fa-angle-double-right"></i> My Leave Reports</a></li>
                            </ul>
                        </li>


                        <li>
                            <a href="empProfile.php">
                                <i class="fa fa-users"></i> <span>Edit Profile</span>
                            </a>
                        </li>


                         <li>
                            <a href="applyLeave.php">
                                <i class="fa fa-plus-square"></i> <span>Apply for Leave</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo $icon; ?> <?php echo $title; ?>
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?php echo $title; ?></li>
                    </ol>
                </section>
                



<script>
var $scores = $("#refresh");
setInterval(function () {
    $scores.load("index.php #refresh");
}, 5000);
</script>



<?php
        }
    } catch (PDOException $e){

    }

?>