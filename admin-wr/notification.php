<?php 

  include "php/check-login.php";

  include "php/config.php";

  $date = date("Y-m-d");

  $query = "SELECT * FROM notification";



  $query_process = mysqli_query($conn,$query);

  $result = mysqli_fetch_array($query_process);

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

            <li><a href="register-employee"><i class='fa fa-user'></i><span>Register New Employee</span></a></li>

            <li class="active"><a><i class='fa fa-bell text-red'></i><span class="text-red">Notification</span></a></li>

          </ul>

        </section>

      </aside>



      <div class="content-wrapper">

        <section class="content-header">

          <h1>

            Notification

          </h1>

        </section>

        <section class="content">

          <div class="row">

            <div class="col-md-3"></div>

              <div class="col-md-6">

                <div class="box box-danger">

                  <div class="box-body">

                    <form action="notification_post" method="post">

                      <div class="form-group">

                          <label for="exampleInputEmail1">Title</label>

                          <input required type="text" value="<?php echo $result['title']; ?>" class="form-control" id="title_id" placeholder="Title Message ..." name="title">

                        </div>

                        <div class= "form-group">

                            <label>Message</label>

                            <textarea class="form-control" rows="3" placeholder="Content Message ..." name="content"><?php echo $result['content']; ?></textarea>

                        </div>

                        <hr>

                        <button style="margin-top:-10px" type="submit" class="pull-right btn btn-danger" name="post_notif" onclick="openmodal()">Submit</button>

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