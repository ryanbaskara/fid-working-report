<?php
  include "php/check-login.php";

  include "php/config.php";

  $query_employee="SELECT * FROM employee" ;?>
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

                  <img src="/admin-wr/dist/img/avatar5.png" class="user-image" alt="User Image"/>

                  <span class="hidden-xs">Admin</span>

                </a>

                <ul class="dropdown-menu">

                  <li class="user-header">

                    <img src="/admin-wr/dist/img/avatar5.png" class="img-circle" alt="User Image" />

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

              <img src="/admin-wr/dist/img/avatar5.png" class="img-circle" alt="User Image" />

            </div>

            <div class="pull-left info">

              <p><?php echo $_SESSION['fullname'] ?></p>

              <a href="#"><i class="fa fa-user"></i> Administrator</a>

            </div>

          </div>

          <ul class="sidebar-menu">

            <li class="header">Main Menu</li>

            <li><a href="working-report"><i class='fa fa-list-alt'></i><span>Working Report</span></a></li>

            <li class="active "><a><i class="fa fa-table text-red"></i><span class="text-red">View Employee</span></a></li>

            <li><a href="register-employee"><i class='fa fa-user'></i><span>Register New Employee</span></a></li>

            <li><a href="notification"><i class='fa fa-bell'></i><span>Notification</span></a></li>

          </ul>

        </section>

      </aside>

      <div class="content-wrapper">

        <section class="content-header">

          <h1>

            View Employee

          </h1>

        </section>



        <section class="content">

          <div class="row">

            <div class="col-xs-12">

              <div class="box box-danger">

                <div class="box-header">

                  <h3 class="box-title">Data Table Employee</h3>

                </div>

                <div class="box-body">

                   <table id="employee_table" class="table table-bordered table-striped"> 

                    <thead>

                      <tr>

                        <th class="hidden"></th>

                        <th></th>

                        <th width="1%">No</th>

                        <th>Login ID</th>

                        <th>Password</th>

                        <th>Name</th>

                        <th>Company</th>

                        <th>Start Peroid Project</th>

                        <th>End Peroid Project</th>

                        <th width="1%">Status</th>

                      </tr>

                    </thead>

                    <tbody>

                    <?php
                      mysqli_query($conn,'SET CHARACTER SET utf8');
                      $query=mysqli_query($conn,$query_employee); $i = 0;

                      while ($result=mysqli_fetch_array($query)) {

                        $rows[] = $result;

                    ?>

                      <tr>

                        <td class="hidden"></td>

                        <td align="center"><a onclick="openEditEmployee(<?php echo $i++; ?>)"  data-toggle="tooltip" data-placement="right" title="edit"><i class="fa fa-fw fa-pencil"></i></a></td>

                        <td><?php echo $i; ?></td>

                        <td><?php echo $result['login_id']; ?></td>

                        <td><?php echo $result['password']; ?></td>

                        <td><?php echo $result['name']; ?></td>

                        <td><?php echo $result['company_name']; ?></td>

                        <td><?php echo $result['start_peroid_po']; ?></td>

                        <td><?php echo $result['end_period_po']; ?></td>

                        <td><i class="fa fa-fw fa-circle <?php if($result['status']) echo "text-green"; else echo "text-red"  ; ?>"></i></td>

                      </tr>

                      <?php }?>

                    </tbody>

                  </table>

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

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" >

      <div class="modal-dialog" role="document">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Edit Employee</h4>

          </div>

          <div class="modal-body">            

            <form action="update-employee" method="post">

              <h4>General Information</h4>

              <div class="row">

                <div class="col col-md-6">

                  <h5>Login ID</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-user-plus"></i></span>

                    <input disabled required type="text" id="edit_login_id" class="form-control" placeholder="Login ID" name="id">

                    <input hidden name="login_id" id="edit_login_id_hidden">

                  </div>

                </div>

                <div class="col col-md-6">

                  <h5>Password</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>

                    <input required type="text" id="edit_password" class="form-control" placeholder="Password" name="password">

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col col-md-6">

                  <h5>Name</h5>

                   <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>

                    <input required type="text" id="edit_name" class="form-control" placeholder="Name" name="name">

                   </div>

                </div>

                <div class="col col-md-6">

                  <h5>Employee id</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-briefcase"></i></span>

                    <input required type="text" id="edit_employee_id" class="form-control" placeholder="Employee_id" name="employee_id">

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col col-md-6">

                  <h5>Position</h5>

                   <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>

                    <input required type="text" id="edit_position" class="form-control" placeholder="Position" name="position">

                   </div>

                </div>  

                <div class="col col-md-6">

                  <h5>Company Name</h5>

                   <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-building"></i></span>

                    <input required type="text" id="edit_company" class="form-control" placeholder="Company Name" name="company">

                   </div>

                </div>  

              </div>

              <br/>

              <h4>Schedule Information</h4>

              <div class="row">

                <div class="col col-md-6">

                  <h5>Join Date</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>

                    <input type="date" id="edit_join_date" class="form-control" placeholder="Join Date" name="join_date">

                  </div>

                </div>

                <div class="col col-md-6">

                  <h5>End Date</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>

                    <input type="date" id="edit_end_date" class="form-control" placeholder="End Date" name="end_date">

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col col-md-6">

                  <h5>Start Period Project</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>

                    <input type="date" id="edit_start_period" class="form-control" placeholder="Start Period Project" name="start_pro">

                  </div>

                </div>

                <div class="col col-md-6">

                  <h5>End Period Project</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>

                    <input type="date" id="edit_end_period" class="form-control" placeholder="End Period Project" name="end_pro">

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col col-md-6">

                  <h5>Status</h5>

                  <div class="input-group">

                    <label>

                      <input type="radio" value="1" id="edit_status_true" name="status" class="flat-red"/><span>&nbsp; Active &nbsp;</span>

                    </label>

                    <label>

                      <input type="radio" value="0" id="edit_status_false" name="status" class="flat-red"/><span>&nbsp; Nonactive &nbsp;</span>

                    </label>

                  </div>

                </div>

              </div>

              <br/>

              <h4>Project Information</h4>

              <div class="row">

                <div class="col col-md-6">

                  <h5>PM Leader</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-male"></i></span>

                    <input type="text" id="edit_pm" class="form-control" placeholder="PM Leader" name="pm">

                  </div>

                </div>

                <div class="col col-md-6">

                  <h5>Level</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-arrow-up"></i></span>

                    <input type="text" id="edit_level" class="form-control" placeholder="Level" name="level">

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col col-md-6">

                  <h5>Role</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-file-text-o"></i></span>

                    <input type="Text" id="edit_role" class="form-control" placeholder="Role" name="role">

                  </div>

                </div>

                <div class="col col-md-6">

                  <h5>Skill</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-pencil"></i></span>

                    <input type="text" id="edit_skill" class="form-control" placeholder="Skill" name="skill">

                  </div>

                </div>

              </div>

              <br/>

              <h4>Other Information</h4>

              <div class="row">

                <div class="col col-md-6">

                  <h5>WBS</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-sitemap"></i></span>

                    <input type="text" id="edit_wbs" class="form-control" placeholder="WBS" name="wbs">

                  </div>

                </div>

                <div class="col col-md-6">

                  <h5>Remark</h5>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-fw fa-check-square-o"></i></span>

                    <input type="text" id="edit_remark" class="form-control" placeholder="Remark" name="remark">

                  </div>

                </div>

              </div>

              <br/>

              <div class="row">

                <div class="col-xs-12">

                  <button type="submit" class="pull-right btn btn-danger" name="btn-update">Submit</button>

                </div>

              </div>

            </form> 

          </div>

        </div>

      </div> 

    </div>

  </body>

  <script type="text/javascript">

    var data = '<?php echo json_encode($rows) ?>';

    var json = JSON.parse(data);

  </script>

</html>

