<?php 
	//function check day employee_id & date from month_attended table
	function check_day_attendance($conn, $id, $date){
		$result = mysqli_query($conn,'SELECT COUNT(*) count  FROM attendance WHERE employee_id = "'.$id.'" AND date = "'.$date.'"');
		$row = mysqli_fetch_assoc($result);
		if ($row['count'] == 0) {
			return 0; //insert
		}else{
			return 1; //update
		}
	}
	//function to get overtime, totaltime, and attended count
	function count_data_month($conn,$id,$date){
		$year = substr($date, 0, 4);
		$month = substr($date, 5,2);
		$query = ("SELECT COUNT(*) attended, SUM( TIME_TO_SEC( totaltime )) totaltime, SUM( TIME_TO_SEC( overtime )) overtime  FROM attendance WHERE employee_id = '$id' AND date BETWEEN '".date("Y-m-1",mktime(0,0,0,$month,1,$year))."' AND '".date("Y-m-t",mktime(0,0,0,$month,1,$year))."'");
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);
		return $row;
	}
	//get overtime totaltime
	function get_time_format($time_in,$time_out,$time_break){		    
	    $temp_time_in = new DateTime($time_in);
	    $temp_time_out = new DateTime($time_out);
	    $temp_time_break = new DateTime($time_break);
	    $temp_activity_length = new DateTime("08:00:00");

	    $temp = $temp_time_in->diff($temp_time_out);
	    $temp = new DateTime (date("H:i:s",mktime($temp->h, $temp->i,0)));	    
	    $totaltime = $temp_time_break->diff($temp);
	    $temp_totaltime = new DateTime (date("H:i:s",mktime($totaltime->h, $totaltime->i,0)));
	    $overtime = $temp_activity_length->diff($temp_totaltime);

	    if($overtime->h < 0) {
	      $result['overtime'] = "00:00:00";
	    }else{
	      $result['overtime'] = date("H:i:s",mktime($overtime->h, $overtime->i,0));
	    }

	    $result['totaltime'] = date("H:i:s",mktime($totaltime->h, $totaltime->i,0));

	    return $result;
	}
	//function check month employee_id & date from month_attended table
	function check_month_attendance($conn,$id,$date){
		$result = mysqli_query($conn,'SELECT COUNT(*) count FROM month_attended WHERE employee_id = "'.$id.'" AND date = "'.$date.'"');
		$row = mysqli_fetch_assoc($result);
		if ($row['count'] == 0) {
			return 0;
		}else{
			return 1;
		}
	}
	//function input month attendance
	function input_month_attendance($conn,$employee_id,$date,$customer_name,$project_name,$wo_number,$attended,$overtime,$totaltime){
		$query = "INSERT INTO month_attended (employee_id, date, customer_name, project_name, wo_number, attended, overtime, totaltime) VALUES ('".$employee_id."','".$date."','".$customer_name."','".$project_name."','".$wo_number."','".$attended."','".$overtime."','".$totaltime."')";
		$result = mysqli_query($conn,$query);
		if ($result) {
			return 1;
		}else{
			return 0;
		}
	}
	//function update month attendance
	function update_month_attendance($conn,$employee_id,$date,$customer_name,$project_name,$wo_number,$attended,$overtime,$totaltime){
		if ($customer_name && $project_name && $wo_number) {
			$query = "UPDATE month_attended SET customer_name = '".$customer_name."', project_name = '".$project_name."', wo_number = '".$wo_number."', attended = '".$attended."', overtime = '".$overtime."', totaltime = '".$totaltime."' WHERE month_attended.employee_id = '".$employee_id."' AND month_attended.date = '".$date."'";
		}else{
			$query = "UPDATE month_attended SET attended = '".$attended."', overtime = '".$overtime."', totaltime = '".$totaltime."' WHERE month_attended.employee_id = '".$employee_id."' AND month_attended.date = '".$date."'";
		}
		$result = mysqli_query($conn,$query);
		if ($result) {
			return 1;
		}else{
			return 0;
		}
	}
?>
