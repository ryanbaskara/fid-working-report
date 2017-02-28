<?php
 include 'config.php';
 include 'check-login.php';

 if(isset($_POST['btn-update'])){
  $login_id = mysqli_real_escape_string($conn,$_POST["login_id"]);
 	$password = mysqli_real_escape_string($conn,$_POST["password"]);
  $name = mysqli_real_escape_string($conn,$_POST["name"]);
  $employee_id = mysqli_real_escape_string($conn,$_POST["employee_id"]);
  $position = mysqli_real_escape_string($conn,$_POST["position"]);
  $join_date = mysqli_real_escape_string($conn,$_POST["join_date"]);
  $end_date = mysqli_real_escape_string($conn,$_POST["end_date"]);
  $start_pro = mysqli_real_escape_string($conn,$_POST["start_pro"]);
  $end_pro = mysqli_real_escape_string($conn,$_POST["end_pro"]);
  $status = mysqli_real_escape_string($conn,$_POST["status"]);
  $pm = mysqli_real_escape_string($conn,$_POST["pm"]);
  $level = mysqli_real_escape_string($conn,$_POST["level"]);
  $role = mysqli_real_escape_string($conn,$_POST["role"]);
  $skill = mysqli_real_escape_string($conn,$_POST["skill"]);
  $wbs = mysqli_real_escape_string($conn,$_POST["wbs"]);
  $remark = mysqli_real_escape_string($conn,$_POST["remark"]);
  $company = mysqli_real_escape_string($conn,$_POST["company"]);

  $query = "UPDATE employee SET name = '$name', password = '$password', company_name = '$company', role = '$role', position = '$position', join_date = '$join_date', end_date = '$end_date', status = '$status', pm_leader = '$pm', skill = '$skill', level = '$level', start_peroid_po = '$start_pro', end_period_po = '$end_pro', wbs = '$wbs', remark = '$remark' WHERE employee.login_id = '$login_id'";

  $process = mysqli_query($conn,$query);
  if ($process) {
    $_SESSION['notification'] = "Update User Successfully";
    header("Location: /admin-wr/employee");
  }else{
    $_SESSION['notification'] = "Update User failed";
    header("Location: /admin-wr/employee");
  }
 }else{
  echo "failed";
 }

?>
