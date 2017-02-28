<?php
  include 'config.php';
  include 'check-login.php';
  if( isset($_POST['reg_new']) ){
   	$login_id = mysqli_real_escape_string($conn,$_POST["login_id"]);
   	$hit = mysqli_query($conn,"SELECT login_id FROM employee WHERE login_id='$login_id'");

   	if(mysqli_num_rows($hit) == 0) {
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

      //checking login_id
      $query = "INSERT INTO employee(login_id, password, name, id, position, join_date, end_date, start_peroid_po, end_period_po,status, pm_leader, level, role, skill, wbs, remark, company_name) VALUES ('$login_id', '$password', '$name', '$employee_id',  '$position', '$join_date', '$end_date', '$start_pro', '$end_pro', '$status', '$pm', '$level', '$role', '$skill', '$wbs', '$remark', '$company')";
   		$process = mysqli_query($conn,$query);
   		if ($process) {
        $_SESSION['notification'] = "Register User Successfully";
        header("Location: /admin-wr/register-employee");
      }else{
        $_SESSION['notification'] = "Register User failed";
        header("Location: /admin-wr/register-employee");
      }
    }else {
      //found login id in database
      echo "<script>alert('Login id is exist');history.go(-1)</script>";
    }
 }
?>
