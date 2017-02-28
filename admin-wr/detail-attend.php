<!DOCTYPE html>

<html>

<?php

  include "php/config.php";

  include "php/check-login.php";

  

  $month = @$_GET['month'];

  $year = @$_GET['year'];

  $id = @$_GET['id'];



  $query_da = 'SELECT *, EXTRACT(DAY FROM date) day FROM attendance WHERE date BETWEEN "'.date("Y-m-1",mktime(0,0,0,$month,1,$year)).'" AND "'.date("Y-m-t",mktime(0,0,0,$month,1,$year)).'" AND employee_id = "'.$id.'" ORDER BY date';



  $query_user = "SELECT employee.name as name, employee.id as id_emp, employee.position as posisi, month_attended.customer_name as cus_name, month_attended.project_name as pro_name, month_attended.wo_number as wo_num, SEC_TO_TIME(month_attended.totaltime) as tot_time, SEC_TO_TIME(month_attended.overtime) as ov_time, month_attended.attended FROM month_attended INNER JOIN employee where employee.id = month_attended.employee_id AND employee.id= '$id' AND `date` = '".date("Y-m-1",mktime(0,0,0,$month,1,$year))."'";



  $query1 = mysqli_query($conn,$query_user);

  $result1 = mysqli_fetch_array($query1);

?>

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

            <li class="active "><a href="/admin-wr/working-report"><i class='fa fa-list-alt text-red'></i><span class="text-red">Working Report</span></a></li>

            <li><a href="/admin-wr/employee"><i class="fa fa-table"></i><span>View Employee</span></a></li>

            <li><a href="/admin-wr/register-employee"><i class='fa fa-user'></i><span>Register New Employee</span></a></li>
            <li><a href="/admin-wr/notification"><i class='fa fa-bell'></i><span>Notification</span></a></li>

          </ul>

        </section>

      </aside>

<?php if (mysqli_num_rows($query1)) {?>

      <div class="content-wrapper">

        <section class="content-header">

          <h1>

            Working Report

            <small><?php echo date("F Y",mktime(0,0,0,$_GET['month']+1,0,$_GET['year'])) ; ?></small>

          </h1>

        </section>



        <section class="content">

          <div class="row">

            <div class="col-xs-12">

              <div class="box box-danger">

                <div class="box-body">

                  <div class="row"> 

                    <div class="col col-md-6">

                      <table>

                        <tbody>

                          <tr>

                            <th>Employee Name</th>

                            <td align="center" width="10%">:</td>

                            <td><?php echo $result1['name']; ?></td>

                          </tr>

                          <tr>

                            <th>ID No</th>

                            <td align="center" width="10%">:</td>

                            <td><?php echo $result1['id_emp']; ?></td>

                          </tr>

                          <tr>

                            <th>Position</th>

                            <td align="center" width="10%">:</td>

                            <td><?php echo $result1['posisi']; ?></td>

                          </tbody>

                        </tr>

                      </table>

                    </div>

                    <div class="col col-md-6">

                      <table>

                        <tr>

                          <th>Customer Name</th>

                          <td align="center" width="10%">:</td>

                          <td><?php echo $result1['cus_name']; ?></td>

                        </tr>

                        <tr>

                          <th>Project Name</th>

                          <td align="center" width="10%">:</td>

                          <td><?php echo $result1['pro_name']; ?></td>

                        </tr>

                        <tr>

                          <th>WO Number</th>

                          <td align="center" width="10%">:</td>  

                          <td><?php echo $result1['wo_num']; ?></td>

                        </tr>

                        <tr>

                          <th>Total Working Time</th>

                          <td align="center" width="10%">:</td>

                          <td><?php echo $result1['tot_time']; ?></td>

                        </tr>

                        <tr>

                          <th>Total Over Time</th>

                          <td align="center" width="10%">:</td>

                          <td><?php echo $result1['ov_time']; ?></td>

                        </tr>

                        <tr>

                          <th>Total Attended</th>

                          <td align="center" width="10%">:</td>

                          <td><?php echo $result1['attended']; ?></td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>



                <div class="box-body">

                  <table id="detail-attended" class="table table-bordered table-striped">

                    <thead>

                      <tr> 

                        <th rowspan="2" width="1%"></th>

                        <th class="middle" rowspan="2" colspan="2">Date</th>

                        <th colspan="3">Time</th>

                        <th colspan="2">Working Time</th>

                        <th rowspan="2">Place</th>

                        <th rowspan="2">Activity</th>

                      </tr>

                      <tr> 

                        <th>In</th>

                        <th>Out</th>

                        <th>Break</th>

                        <th>Total</th>

                        <th>Over</th>

                      </tr>

                    </thead>

                    <tbody>

                      <?php

                      $query = mysqli_query($conn,$query_da);

                      $row = mysqli_fetch_array($query);



                      $n = date("t",mktime(0,0,0,$month,1,$year));

                      //loop while 1 month 

                      for ($i=1; $i < $n ; $i++) { 

                        //set date and day

                        $date = date("d F Y",mktime(0,0,0,$month,$i,$year));

                        $date2 = date("Y-m-d",mktime(0,0,0,$month,$i,$year));

                        $day = date("D",mktime(0,0,0,$month,$i,$year));

                        //saturday and sunday check

                        if(date("N",mktime(0,0,0,$month,$i,$year)) == 6 || date("N",mktime(0,0,0,$month,$i,$year)) == 7){

                          $class1 = 'holiday';$class2 = 'holiday';

                        }else {

                          $class1 = 'time';$class2 = '';

                        };

                        //check data in database with iterati

                        if ($row['date'] == date("Y-m-d",mktime(0,0,0,$month,$i,$year))) {

                          $data['time_in'] = $row['time_in'];

                          $data['time_out'] = $row['time_out'];

                          $data['time_break'] = $row['time_break'];

                          $data['totaltime'] = $row['totaltime'];

                          $data['overtime'] = $row['overtime'];

                          $data['place'] = $row['place'];

                          $data['activity'] = $row['activity'];

                          $row = mysqli_fetch_array($query);

                        }else{

                          $data['time_in'] = "";

                          $data['time_out'] = "";

                          $data['time_break'] = "";

                          $data['totaltime'] = "";

                          $data['overtime'] = "";

                          $data['place'] = "";

                          $data['activity'] = "";

                        }?> 

                      <tr id="rows<?php echo $i; ?>">

                        <td align="center"><a onclick="openEditAttended(<?php echo $i; ?>)"  data-toggle="tooltip" data-placement="right" title="edit"><i class="fa fa-fw fa-pencil"></i></a></td>

                        <td><?php echo $date; ?></td>

                        <td><?php echo $day; ?></td>

                        <td class="<?php echo $class1; ?>"><?php echo $data['time_in']; ?></td>

                        <td class="<?php echo $class1; ?>"><?php echo $data ['time_out']; ?></td>

                        <td class="<?php echo $class1; ?>"><?php echo $data['time_break']; ?></td>

                        <td class="<?php echo $class1; ?>"><?php echo $data['totaltime']; ?></td>

                        <td class="<?php echo $class1; ?>"><?php echo $data['overtime']; ?></td>

                        <td class="<?php echo $class2; ?>"><?php echo $data['place']; ?></td>

                        <td class="<?php echo $class2; ?>"><?php echo $data['activity'];?></td>

                        <td class="hidden"><?php echo $date2 ?></td>

                      </tr>

                    <?php }?></tbody>

                  </table>

                </div>

              </div>

            </div>

          </div>

        </section>

      </div>

      <?php }else include 'not-found.php' ?>      

      <footer class="main-footer">

        <strong>Copyright &copy; 2016 <a href="#">Fujitsu Indonesia</a>.</strong> All rights reserved.

      </footer>

    </div>

    <div class="modal fade" id="modal_edit_record" tabindex="-1" role="dialog" >

      <div class="modal-dialog" role="document">

        <div class="modal-content">

        <form method="post" action="/admin-wr/update-attended">

          <input name="link" class="hidden" value="<?php echo $month."/".$year."/".$id; ?>">

          <input id="edit_id_employee" name="id_employee" class="hidden" value="<?php echo $id; ?>">

          <input id="edit_date" name="date" class="hidden"/> 

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Edit Report</h4>

          </div>

          <div class="modal-body">

          <h4 id="edit_title"></h4> 

            <div class="row">

              <div class="col-md-4 form-group" id="edit-form2">

                <label>Time In</label>

                <input id="edit_time_in" name="time_in" type="time" class="form-control timepicker"/>     

              </div>

              <div class="col-md-4 form-group bootstrap-timepicker timepicker" id="edit-form3">

                <label>Time Out</label>

                <input id="edit_time_out" name="time_out" type="time" class="form-control timepicker"/>    

              </div>

              <div class="col-md-4 form-group bootstrap-timepicker timepicker" id="edit-form4">

                <label>Time Break</label>

                <input id="edit_time_break" name="time_break" type="time" class="form-control timepicker"/>    

              </div>                    

            </div>

            <div class="form-group" id="edit-form5">

              <label>Place</label>

              <input id="edit_place" name="place" type="text" class="form-control"/>  

            </div>

            <div class="form-group" id="edit-form6">

              <label>Activity</label>

              <input id="edit_activity" name="activity" maxlength="50" type="text" class="form-control"/> 

            </div>

          </div>

          <div class="modal-footer">

            <button type="submit" id="edit_btn" name="btn-update" class="btn btn-danger">Update</button>

          </div>   

        </form>

        </div>

      </div> 

    </div>

    <?php include 'php/notification.php' ?>

  </body>

</html>

