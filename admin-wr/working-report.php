<?php

  include "php/config.php";

  include "php/check-login.php";

  include "php/wr-page.php";



  $querywr="SELECT *, month_attended.employee_id as id, employee.name as name, SEC_TO_TIME(month_attended.totaltime) as totaltime, SEC_TO_TIME(month_attended.overtime) as overtime, month_attended.attended as attended FROM month_attended INNER JOIN employee ON month_attended.employee_id=employee.id WHERE month_attended.date = '".date("Y-m-1",mktime(0,0,0,$_GET['month'],1,$_GET['year']))."'"; ?>
<html>
  <head>

    <meta charset="UTF-8">

    <title>Working Report</title>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

<?php include "include-header.php" ?>

    <script type="text/javascript">

      function export_general(){
        if (count != 0) {
          location.href = "/admin-wr/export-general/<?php echo $_GET['month']."/".$_GET['year']; ?>"
        }
        else{
          alert('Export excel failed, data this month empty')
        }

      }



      function export_selected(){

        var val = [];

        // location.href = "/admin-wr/export-month/<?php echo $_GET['month']."/".$_GET['year']; ?>/"+$(this).val();

        $('#employee_checkbox:checked').each(function(i){

          val[i] = $(this).val();

        });

        if (val.length) {

          for (var i = 0; i < val.length; i++) {

            // alert("/admin-wr/export-month/<?php echo $_GET['month']."/".$_GET['year']; ?>/"+val[i]);

            export_page = "/admin-wr/export-month/<?php echo $_GET['month']."/".$_GET['year']; ?>/"+val[i];

            if(confirm('Export Working Report '+ val[i] + '?')) window.open(export_page);

          }

        }else{

          alert('Export excel failed, choose employee checkbox, to Export')

        }

      }



      function choosedate(){

        location.href = "/admin-wr/working-report/"+$('#month').val()+"/"+$('#year').val();

      }

    </script>



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

            <li class="active "><a><i class='fa fa-list-alt text-red'></i><span class="text-red">Working Report</span></a></li>

            <li><a href="/admin-wr/employee"><i class="fa fa-table"></i><span>View Employee</span></a></li>

            <li><a href="/admin-wr/register-employee"><i class='fa fa-user'></i><span>Register New Employee</span></a></li>

            <li><a href="/admin-wr/notification"><i class='fa fa-bell'></i><span>Notification</span></a></li>

          </ul>

        </section>

      </aside>



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

                <div class="box-header">

                  <h3 class="box-title">Employee Working Report data <?php echo date("F Y",mktime(0,0,0,$_GET['month']+1,0,$_GET['year'])) ; ?></h3>

                  <div class="pull-right">

                    <button class="btn btn-default" onclick="export_general()">Export This Month &nbsp;<i class="fa fa-file-excel-o"></i></button> &nbsp;

                    <button class="btn btn-default pull-right" onclick="export_selected()">Export Selected &nbsp;<i class="fa fa-file-excel-o"></i></button>

                  </div>

                  <div class="clearfix"></div>

                  <form id="reportForm" class="reportForm" method="post" name="reportForm">

                  <div class="row">  

                    <div class="col col-xs-2" style="padding-right:0px">

                      <select id="month" name="month" class="form-control">

                        <?php for ($i=1; $i < 13; $i++){?> <option <?php if($i == $_GET['month']) echo "Selected"; ?> value="<?php echo $i?>"><?php echo date("F",mktime(0,0,0,$i+1,0,$_GET['year'])) ; ?></option>

                        <?php }?>

                      </select>

                    </div>

                    <div class="col col-xs-1"  style="padding-right:0px">

                      <select id="year" name="year" class="form-control">

                        <?php for ($i=date("Y"); $i > date("Y")-5; $i--){?> <option <?php if($i == $_GET['year']) echo "Selected"; ?> value="<?php echo $i?>"><?php echo $i ?></option>

                        <?php }?>

                      </select>

                    </div>

                    <div class="col col-xs-2">

                      <a class="btn btn-default" onclick="choosedate()">View</a>

                    </div>

                  </form>

                  </div>

                </div>

                <div class="box-body">

                  <div class="row">

                    <div class="col-xs-12 col">

                      <table id="employee_table" class="table table-bordered table-striped"> 

                        <thead>

                          <tr>

                            <th class="hidden"></th>

                            <th width="1px" style="padding-right:0px">

                             <div class="checkbox" >

                                <label>

                                  <input value="1" type="checkbox" class="all" id="checkbox_all">

                                </label>

                              </div>

                            </th>

                            <th width="1%"></th>

                            <th width="10%">Employee ID</th>

                            <th align="center">Employee Name</th>

                            <th>Total Time</th>

                            <th>Over time</th>

                            <th>Total Attended</th>

                            <th>Costumer Name</th>

                            <th>Project Name</th>

                            <th>WO Number</th>

                          </tr>

                        </thead>

                        <tbody>

                        <?php
                          mysqli_query($conn,'SET CHARACTER SET utf8');
                          $query = mysqli_query($conn,$querywr);$i=0;
                          $count = mysqli_num_rows($query);
                          while ($result=mysqli_fetch_array($query)) {

                            $record['employee_id'] = $result['employee_id'];

                            $record['name'] = $result['name'];

                            $record['date'] = $result['date'];

                            $record['customer_name'] = $result['customer_name'];

                            $record['project_name'] = $result['project_name'];

                            $record['wo_number'] = $result['wo_number'];

                            $rows[] = $record;

                        ?>

                          <tr>

                            <td class="hidden"></td>

                            <td>

                              <div class="checkbox" >

                                <label>

                                  <input type="checkbox" class="check" id="employee_checkbox" value="<?php echo $result['id'];?>">

                                </label>

                              </div>

                            </td>

                            <td align="center"><a onclick="openEditWR(<?php echo $i++; ?>)"  data-toggle="tooltip" data-placement="right" title="edit"><i class="fa fa-fw fa-pencil"></i></a></td>

                            <td><?php echo $result['id']; ?></td>

                            <td><?php echo $result['name']; ?></td>

                            <td><?php echo substr($result['totaltime'], 0, strlen($result['totaltime'])-3); ?> hours</td>

                            <td><?php echo substr($result['overtime'], 0, strlen($result['overtime'])-3); ?> hours</td>

                            <td><a href="/admin-wr/detail-attended/<?php echo $_GET['month'].'/'.$_GET['year'].'/'.$result['id']; ?>"</a><?php echo $result['attended']; ?></td>

                            <td><?php echo $result['customer_name']; ?></td>

                            <td><?php echo $result['project_name']; ?></td>

                            <td><?php echo $result['wo_number']; ?></td>

                          </tr>

                          <?php

                        }

                          ?>

                        </tbody>

                      </table>

                    </div>

                  </div>

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

    <div class="modal fade" id="modal_edit_wr" tabindex="-1" role="dialog" >

      <div class="modal-dialog" role="document">

        <div class="modal-content">

        <form method="post" action="/admin-wr/update-month-attended">

          <input name="link" class="hidden" value="<?php echo "/".$_GET['month']."/".$_GET['year']; ?>">

          <input id="edit_employee_id" name="id_employee" class="hidden">

          <input id="edit_date" name="date" class="hidden"/> 

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Edit Working Report | <?php echo date("F Y",mktime(0,0,0,$_GET['month']+1,0,$_GET['year'])) ; ?></h4>

          </div>

          <div class="modal-body">

          <h4 id="edit_title"></h4> 

            <div class="form-group" id="edit-form4">

              <label>Customer Name</label>

              <input id="edit_customer_name" name="customer" type="text" class="form-control"/>                     

            </div>

            <div class="form-group" id="edit-form5">

              <label>Project Name</label>

              <input id="edit_project_name" name="project_name" type="text" class="form-control"/>  

            </div>

            <div class="form-group" id="edit-form6">

              <label>WO Number</label>

              <input id="edit_wo_number" name="wo_number" maxlength="50" type="text" class="form-control"/> 

            </div>

          </div>

          <div class="modal-footer">

            <button type="submit" id="edit_btn" name="btn-update" class="btn btn-danger">Update</button>

          </div>   

        </form>

        </div>

      </div> 

    </div>

  </body>

  <script type="text/javascript">
    var count = '<?php echo $count ?>';
    var data = '<?php echo json_encode($rows) ?>';

    var json = JSON.parse(data);

    
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'iradio_square-red',
      increaseArea: '20%'
    });
  </script>

</html>

