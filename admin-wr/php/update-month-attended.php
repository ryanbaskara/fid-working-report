<?php

  require 'check-login.php';
  require 'config.php';
  require 'function.php';



  if(isset($_POST['btn-update'])){

    $link = mysqli_real_escape_string($conn,$_POST["link"]);

   	$employee_id = mysqli_real_escape_string($conn,$_POST["id_employee"]);

   	$date = mysqli_real_escape_string($conn,$_POST["date"]);

    $customer_name = mysqli_real_escape_string($conn,$_POST["customer"]);

    $project_name = mysqli_real_escape_string($conn,$_POST["project_name"]);

    $wo_number = mysqli_real_escape_string($conn,$_POST["wo_number"]);



    $query_update = "UPDATE `month_attended` SET `customer_name` = '$customer_name', `project_name` = '$project_name', `wo_number` = '$wo_number' WHERE `employee_id` = '$employee_id' AND `date` = '$date'";



    // check attended for update or insert

    $process = mysqli_query($conn, $query_update);
    if ($process) {
      //success input to database
      $_SESSION['notification'] = "Update Month Attended Success";

    }else{
       $_SESSION['notification'] = "Update Month Attended failed";
    }

    header("location: /admin-wr/working-report".$link);
 }

?>

