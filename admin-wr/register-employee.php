<?php 

  include "php/check-login.php";

  $date = date("Y-m-d");

?>

<!DOCTYPE html>

<html>

  <head>

    <meta charset="UTF-8">

    <title>Working Report</title>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

<?php include "include-header.php" ?>

    

  </head>

  <body class="skin-red-light fixed">

    <div class="wrapper">

      <header class="main-header">

        <a class="logo">

          <span class="logo-mini"><b>F</b>id</span>

          <span class="logo-lg"><b>FID</b> Working Report</span>

        </a>



        <nav class="navbar navbar-static-top" role="navigation">

          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

            <span class="sr-only">Toggle navigation</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

          </a>

          <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

              <li class="dropdown user user-menu">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <img src="dist/img/avatar5.png" class="user-image" alt="User Image"/>

                  <span class="hidden-xs">Admin</span>

                </a>

                <ul class="dropdown-menu">

                  <li class="user-header">

                    <img src="dist/img/avatar5.png" class="img-circle" alt="User Image" />

                    <p>

                      Admin - Working Report

                      <small>Fujitsu Indonesia</small>

                    </p>

                  </li>

                  <li class="user-footer">

                    <div class="pull-right">

                      <a href="/admin-wr/logout" class="btn btn-default btn-flat">Sign out</a>

                    </div>

                  </li>

                </ul>

              </li>

            </ul>

          </div>

        </nav>

      </header>

      

      <aside class="main-sidebar">

        <section class="sidebar">

          <div class="user-panel">

            <div class="pull-left image">

              <img src="dist/img/avatar5.png" class="img-circle" alt="User Image" />

            </div>

            <div class="pull-left info">

              <p><?php echo $_SESSION['fullname'] ?></p>

              <a href="#"><i class="fa fa-user"></i> Administrator</a>

            </div>

          </div>

          <ul class="sidebar-menu">

            <li class="header">Main Menu</li>

            <li><a href="working-report"><i class='fa fa-list-alt'></i><span>Working Report</span></a></li>

            <li><a href="employee"><i class="fa fa-table"></i><span>View Employee</span></a></li>

            <li class="active"><a><i class='fa fa-user text-red'></i><span class="text-red">Register New Employee</span></a></li>

            <li><a href="/admin-wr/notification" ><i class='fa fa-bell'></i><span>Notification</span></a></li>

          </ul>

        </section>

      </aside>



      <div class="content-wrapper">

        <section class="content-header">

          <h1>

            Register New Employee

          </h1>

        </section>

        <section class="content">

          <div class="row">

            <div class="col-xs-12">

              <div class="box box-danger">

                <div class="box-body">

                  <form action="register-employee-post" method="post">

                    <h4 style="margin-top:0px">General Information</h4>

                    <div class="row">

                      <div class="col col-md-6">

                        <h5>Login ID</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-user-plus"></i></span>

                          <input required="" type="text" class="form-control" placeholder="Login ID" name="login_id">

                        </div>

                      </div>

                      <div class="col col-md-6">

                        <h5>Password</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>

                          <input required type="text" class="form-control" placeholder="Password" name="password">

                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col col-md-6">

                        <h5>Name</h5>

                         <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>

                          <input required type="text" class="form-control" placeholder="Name" name="name">

                         </div>

                      </div>

                      <div class="col col-md-6">

                        <h5>Employee id</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-briefcase"></i></span>

                          <input required type="text" class="form-control" placeholder="Employee_id" name="employee_id">

                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col col-md-6">

                        <h5>Position</h5>

                         <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>

                          <input required type="text" class="form-control" placeholder="Position" name="position">

                         </div>

                      </div>  

                      <div class="col col-md-6">

                        <h5>Company Name</h5>

                         <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-building"></i></span>

                          <input required type="text" class="form-control" placeholder="Company Name" name="company">

                         </div>

                      </div>  

                    </div>

                    <hr>

                    <h4>Schedule Information</h4>

                    <div class="row">

                      <div class="col col-md-6">

                        <h5>Join Date</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>

                          <input type="date" value="<?php echo $date; ?>" class="form-control" placeholder="Join Date" name="join_date">

                        </div>

                      </div>

                      <div class="col col-md-6">

                        <h5>End Date</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>

                          <input type="date" value="<?php echo $date; ?>" class="form-control" placeholder="End Date" name="end_date">

                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col col-md-6">

                        <h5>Start Period Project</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>

                          <input type="date" value="<?php echo $date; ?>" class="form-control" placeholder="Start Period Project" name="start_pro">

                        </div>

                      </div>

                      <div class="col col-md-6">

                        <h5>End Period Project</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>

                          <input type="date" value="<?php echo $date; ?>" class="form-control" placeholder="End Period Project" name="end_pro">

                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col col-md-6">

                        <h5>Status</h5>

                        <div class="input-group">

                          <label>

                            <input type="radio" value="1" name="status" class="flat-red" checked/><span>&nbsp; Active &nbsp;</span>

                          </label>

                          <label>

                            <input type="radio" value="0" name="status" class="flat-red"/><span>&nbsp; Nonactive &nbsp;</span>

                          </label>

                        </div>

                      </div>

                    </div>

                    <hr>

                    <h4>Project Information</h4>

                    <div class="row">

                      <div class="col col-md-6">

                        <h5>PM Leader</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-male"></i></span>

                          <input type="text" class="form-control" placeholder="PM Leader" name="pm">

                        </div>

                      </div>

                      <div class="col col-md-6">

                        <h5>Level</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-arrow-up"></i></span>

                          <input type="text" class="form-control" placeholder="Level" name="level">

                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col col-md-6">

                        <h5>Role</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-file-text-o"></i></span>

                          <input type="Text" class="form-control" placeholder="Role" name="role">

                        </div>

                      </div>

                      <div class="col col-md-6">

                        <h5>Skill</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-pencil"></i></span>

                          <input type="text" class="form-control" placeholder="Skill" name="skill">

                        </div>

                      </div>

                    </div>

                    <hr>

                    <h4>Other Information</h4>

                    <div class="row">

                      <div class="col col-md-6">

                        <h5>WBS</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-sitemap"></i></span>

                          <input type="text" class="form-control" placeholder="WBS" name="wbs">

                        </div>

                      </div>

                      <div class="col col-md-6">

                        <h5>Remark</h5>

                        <div class="input-group">

                          <span class="input-group-addon"><i class="fa fa-fw fa-check-square-o"></i></span>

                          <input type="text" class="form-control" placeholder="Remark" name="remark">

                        </div>

                      </div>

                    </div>

                    <hr>

                    <button style="margin-top:-10px" type="submit" class="pull-right btn btn-danger" name="reg_new" onclick="openmodal()">Submit</button>

                  </form>            

                </div>

              </div>

            </div>

          </div>

        </section>

      </div>

      <footer class="main-footer">

        <strong>Copyright &copy; 2016 <a href="#">Fujitsu Indonesia</a>.</strong> All rights reserved.

      </footer>

    </div>

    <?php include 'php/notification.php' ?>

  </body>

</html>