<?php
  require 'config.php';
  require 'check-login.php';
  require 'function.php';

  if(isset($_POST['btn-update'])){
   	$employee_id = mysqli_real_escape_string($conn,$_POST["id_employee"]);
   	$date = mysqli_real_escape_string($conn,$_POST["date"]);
    $place = mysqli_real_escape_string($conn,$_POST["place"]);
    $activity = mysqli_real_escape_string($conn,$_POST["activity"]);
    $link = mysqli_real_escape_string($conn,$_POST["link"]);

    $time_in = mysqli_real_escape_string($conn,$_POST["time_in"]);
    $time_out = mysqli_real_escape_string($conn,$_POST["time_out"]);
    $time_break = mysqli_real_escape_string($conn,$_POST["time_break"]);

    //get overtime totaltime
    $data = get_time_format($time_in,$time_out,$time_break);
    
    $overtime = $data['overtime'];
    $totaltime = $data['totaltime'];

    $query_insert = "INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `time_out`, `time_break`, `totaltime`, `overtime`, `place`, `activity`, `timestamp`) VALUES (NULL, '$employee_id', '$date', '$time_in', '$time_out', '$time_break', '$totaltime', '$overtime', '$place', '$activity', CURRENT_TIMESTAMP);";
    $query_update = "UPDATE `attendance` SET `time_in` = '$time_in', `time_out` = '$time_out', `time_break` = '$time_break', `totaltime` = '$totaltime', `overtime` = '$overtime', `place` = '$place', `activity` = '$activity' WHERE `employee_id` = '$employee_id' AND `date` = '$date';";

    // check attended for update or insert
    $checking_attended = check_day_attendance($conn, $employee_id, $date);

    mysqli_autocommit($conn, FALSE);
    if ($checking_attended){
      $process = mysqli_query($conn, $query_update);
    }else{
      $process = mysqli_query($conn, $query_insert);
    }

    if ($process) {
      $date_month = substr($_POST['date'], 0, 8)."01";
      $null = null;
      $data = count_data_month($conn,$employee_id,$date_month);
      if (check_month_attendance($conn,$employee_id, $date_month)) {
        if (update_month_attendance($conn,$employee_id,$date_month,$null,$null,$null,$data['attended'],$data['overtime'],$data['totaltime'])) {
          //success input to database
          mysqli_commit($conn);
          $_SESSION['notification'] = "Update Attended Success";
          header("Location: /admin-wr/detail-attended/".$link);
        }else{
           mysqli_rollback($conn);
           $_SESSION['notification'] = "Update Attended failed";
           header("Location: /admin-wr/detail-attended/".$link);
        }
      }else{
        if (input_month_attendance($conn,$employee_id,$date_month,$null,$null,$null,$data['attended'],$data['overtime'],$data['totaltime'])) {
          //success input to database
          mysqli_commit($conn);
          $_SESSION['notification'] = "Update Attended Success";
          header("Location: /admin-wr/detail-attended/".$link);
        }else{
           mysqli_rollback($conn);
           $_SESSION['notification'] = "Update Attended failed";
           header("Location: /admin-wr/detail-attended/".$link);
        }
      }
    }else{
      mysqli_rollback($conn);
      $_SESSION['notification'] = "Update Attended failed";
      header("Location: /admin-wr/detail-attended/".$link);
    }
 }
?>
