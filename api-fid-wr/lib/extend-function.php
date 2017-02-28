<?php 
	//--- function extended --- 
	//authentification
	function authentification($login_id,$password){
		$db = connect_db();		
		$login_id = mysqli_real_escape_string($db,$login_id);
		$password = mysqli_real_escape_string($db,$password);
		$query = 'SELECT * FROM employee WHERE login_id = "'.$login_id.'" AND password = "'.$password.'"';
	    $process_query = $db->query($query);
	    $result['row'] = mysqli_num_rows($process_query);
	    $result['content'] = mysqli_fetch_assoc($process_query);
	    return $result;
	}

	//function generate token from login_id & password with md5 hashing
	function get_token($login_id,$password){		
		$key = "fid-working-report";
		$varCheck = $key.":";
		$x = '';
		for ($i=0; $i < 5 ; $i++) { 
			$x = $x.$key.$login_id.$password;
		}
		$x = md5($x);
		return $x;
	}

	//update employee token
	function update_employee_token($login_id,$password,$id){
		$db = connect_db();	
		$login_id = mysqli_real_escape_string($db,$login_id);
		$password = mysqli_real_escape_string($db,$password);
		$token = get_token($login_id,$password);
		$process_query = $db->query('UPDATE employee SET token = "'.$token.'" WHERE id = "'.$id.'"');
		if ($process_query) {
			$result['process'] = "1";
		}else{
			$result['process'] = "0";
		}
		$result['token'] = $token;
		return $result;
	}

	//update employee token
	function temp_update_employee_token($login_id,$password,$id,$device_token){
		$db = connect_db();	
		$login_id = mysqli_real_escape_string($db,$login_id);
		$password = mysqli_real_escape_string($db,$password);
		$token = get_token($login_id,$password);
		$process_query = $db->query('UPDATE employee SET token = "'.$token.'", device_token = "'.$device_token.'" WHERE id = "'.$id.'"');
		if ($process_query) {
			$result['process'] = "1";
		}else{
			$result['process'] = "0";
		}
		$result['token'] = $token;
		return $result;
	}

	//function check token and id valid
	function check_token($token,$id){
		$db = connect_db();
		$token = mysqli_real_escape_string($db,$token);
		$id = mysqli_real_escape_string($db,$id);
		$result = $db->query('SELECT COUNT(*) count  FROM employee WHERE status = "1" AND token = "'.$token.'" AND id = "'.$id.'"');
		$row = mysqli_fetch_assoc($result);
		if ($row['count'] == 1) {
			return 1; //found
		}else{
			return 0; //not found
		}
	}

	//function check day employee_id & date from month_attended table
	function check_day_attendance($id,$date){
		$db = connect_db();
		$date = mysqli_real_escape_string($db,$date);
		$id = mysqli_real_escape_string($db,$id);
		$result = $db->query('SELECT COUNT(*) count  FROM attendance WHERE employee_id = "'.$id.'" AND date = "'.$date.'"');
		$row = mysqli_fetch_assoc($result);
		if ($row['count'] == 0) {
			return 1; //insert
		}else{
			return 0; //update
		}
	}

	//function check month employee_id & date from month_attended table
	function check_month_attendance($id,$date){
		$db = connect_db();
		$date = mysqli_real_escape_string($db,$date);
		$id = mysqli_real_escape_string($db,$id);
		$result = $db->query('SELECT COUNT(*) count FROM month_attended WHERE employee_id = "'.$id.'" AND date = "'.$date.'"');
		$row = mysqli_fetch_assoc($result);
		if ($row['count'] == 0) {
			return 1; //insert
		}else{
			return 0; //update
		}
	}

	//function check format time
	function check_valid_time($x){
		if ($x > 0 && $x < 2400 && $x%100 < 60) {
			return 1;
		}else{
			return 0;
		}
	}

	//function check format date
	function check_valid_date($x){
		if (substr($x, 0 , 4) > 1900 && substr($x, 0 , 4) < 2100 && substr($x, 5 , 2) > 0 && substr($x, 5 , 2) < 13 && substr($x, 8 , 2) > 0 && substr($x, 8 , 2) < 32 && substr($x, 4 , 1) == '-' && substr($x, 7 , 1) == '-') {
			return 1;
		}else{
			return 0;
		}
	}

	//function to get overtime, totaltime, and attended count
	function count_data_month($id,$date){
		$db = connect_db();
		$year = substr($date, 0, 4);
		$month = substr($date, 5,2);
		$id = mysqli_real_escape_string($db,$id);
		$query = ("SELECT COUNT(*) attended, SUM( TIME_TO_SEC( totaltime )) totaltime, SUM( TIME_TO_SEC( overtime )) overtime  FROM attendance WHERE employee_id = '$id' AND date BETWEEN '".date("Y-m-1",mktime(0,0,0,$month,1,$year))."' AND '".date("Y-m-t",mktime(0,0,0,$month,1,$year))."'");
		$result = $db->query($query);
		$row = mysqli_fetch_assoc($result);
		return $row;
	}

	//function count totaltime
	function count_totaltime($in,$out){
		$hour1 = $in/100;
		$hour2 = $out/100;
		$minute1 = $in%100;
		$minute2 = $out%100;
		if ($minute1 == $minute2) {
			return ($hour2 - $hour1) * 100 ;
		}else if($minute2 > $minute1){
			return ($hour2 - $hour1) * 100 + ($minute2 - $minute1);
		}else{
			return ($hour2 - $hour1 - 1) * 100 + (60-$minute1 + $minute2);
		}
	}

	//function input month attendance
	function input_day_attendance($employee_id,$date,$time_in,$time_out,$time_break,$overtime,$totaltime,$place,$activity){
		$db = connect_db();	
		$employee_id = mysqli_real_escape_string($db,$employee_id);
		$date = mysqli_real_escape_string($db,$date);
		$time_in = mysqli_real_escape_string($db,$time_in);
		$time_out = mysqli_real_escape_string($db,$time_out);
		$time_break = mysqli_real_escape_string($db,$time_break);
		$overtime = mysqli_real_escape_string($db,$overtime);
		$totaltime = mysqli_real_escape_string($db,$totaltime);
		$place = mysqli_real_escape_string($db,$place);
		$activity = mysqli_real_escape_string($db,$activity);
		$query = "INSERT INTO attendance (employee_id,date,time_in,time_out,time_break,overtime,totaltime,place,activity) VALUES ('".$employee_id."','".$date."','".$time_in."','".$time_out."','".$time_break."','".$overtime."','".$totaltime."','".$place."','".$activity."')";
		$result = $db->query($query);
		if ($result) {
			return 1;
		}else{
			return 0;
		}
	}

	//function input month attendance
	function update_day_attendance($employee_id,$date,$time_in,$time_out,$time_break,$overtime,$totaltime,$place,$activity){
		$db = connect_db();	
		$employee_id = mysqli_real_escape_string($db,$employee_id);
		$date = mysqli_real_escape_string($db,$date);
		$time_in = mysqli_real_escape_string($db,$time_in);
		$time_out = mysqli_real_escape_string($db,$time_out);
		$time_break = mysqli_real_escape_string($db,$time_break);
		$overtime = mysqli_real_escape_string($db,$overtime);
		$totaltime = mysqli_real_escape_string($db,$totaltime);
		$place = mysqli_real_escape_string($db,$place);
		$activity = mysqli_real_escape_string($db,$activity);
		$query = "UPDATE `attendance` SET `time_in` = '".$time_in."', `time_out` = '".$time_out."', `time_break` = '".$time_break."', `totaltime` = '".$totaltime."', `overtime` = '".$overtime."', `place` = '".$place."', `activity` = '".$activity."' WHERE `attendance`.`date` = '".$date."' AND `attendance`.`employee_id` = '".$employee_id."'";
		$result = $db->query($query);
		if ($result) {
			return 1;
		}else{
			return 0;
		}
	}

	//function input month attendance
	function input_month_attendance($employee_id,$date,$customer_name,$project_name,$wo_number,$attended,$overtime,$totaltime){
		$db = connect_db();	
		$employee_id = mysqli_real_escape_string($db,$employee_id);
		$date = mysqli_real_escape_string($db,$date);
		$customer_name = mysqli_real_escape_string($db,$customer_name);
		$project_name = mysqli_real_escape_string($db,$project_name);
		$wo_number = mysqli_real_escape_string($db,$wo_number);
		$overtime = mysqli_real_escape_string($db,$overtime);
		$totaltime = mysqli_real_escape_string($db,$totaltime);
		$attended = mysqli_real_escape_string($db,$attended);
		$query = "INSERT INTO month_attended (employee_id, date, customer_name, project_name, wo_number, attended, overtime, totaltime) VALUES ('".$employee_id."','".$date."','".$customer_name."','".$project_name."','".$wo_number."','".$attended."','".$overtime."','".$totaltime."')";
		$result = $db->query($query);
		if ($result) {
			return 1;
		}else{
			return 0;
		}
	}

	//function update month attendance
	function update_month_attendance($employee_id,$date,$customer_name,$project_name,$wo_number,$attended,$overtime,$totaltime){
		$db = connect_db();	
		$employee_id = mysqli_real_escape_string($db,$employee_id);
		$date = mysqli_real_escape_string($db,$date);
		$customer_name = mysqli_real_escape_string($db,$customer_name);
		$project_name = mysqli_real_escape_string($db,$project_name);
		$wo_number = mysqli_real_escape_string($db,$wo_number);
		$overtime = mysqli_real_escape_string($db,$overtime);
		$totaltime = mysqli_real_escape_string($db,$totaltime);
		$attended = mysqli_real_escape_string($db,$attended);
		if ($customer_name && $project_name && $wo_number) {
			$query = "UPDATE month_attended SET customer_name = '".$customer_name."', project_name = '".$project_name."', wo_number = '".$wo_number."', attended = '".$attended."', overtime = '".$overtime."', totaltime = '".$totaltime."' WHERE month_attended.employee_id = '".$employee_id."' AND month_attended.date = '".$date."'";
		}else{
			$query = "UPDATE month_attended SET attended = '".$attended."', overtime = '".$overtime."', totaltime = '".$totaltime."' WHERE month_attended.employee_id = '".$employee_id."' AND month_attended.date = '".$date."'";
		}
		$result = $db->query($query);
		if ($result) {
			return 1;
		}else{
			return 0;
		}
	}

	//function to get time_in, time_out, time_break, totaltime, and overtime
	function time_attended_day_handled($time_in,$time_out,$time_break,$totaltime,$overtime){
		$data['time_in'] = date("H:i:s", mktime($time_in / 100, $time_in % 100, 0));
		$data['time_out'] = date("H:i:s",mktime($time_out / 100, $time_out % 100, 0));
		$data['time_break'] = date("H:i:s",mktime($time_break / 100,$time_break % 100, 0));
		$data['totaltime'] = date("H:i:s",mktime($totaltime / 100, $totaltime % 100, 0));
		$data['overtime'] = date("H:i:s",mktime($overtime/ 100, $overtime% 100,0));
		return $data;
	}

	//get data month
	function get_data_month_attandace($month,$year,$id){
		$db = connect_db();	
		$id = mysqli_real_escape_string($db,$id);
		$month = mysqli_real_escape_string($db,$month);
		$year = mysqli_real_escape_string($db,$year);
		$query = 'SELECT *, EXTRACT(DAY FROM date) day FROM attendance WHERE date BETWEEN "'.date("Y-m-1",mktime(0,0,0,$month,1,$year)).'" AND "'.date("Y-m-t",mktime(0,0,0,$month,1,$year)).'" AND employee_id = "'.$id.'" ORDER BY date';
		$data = $db->query($query);		
		$row = mysqli_fetch_assoc($data);

		//get last day in month
		$n = date("t",mktime(0,0,0,$month,1,$year));
		//loop while 1 month
		for ($i=1; $i <= $n ; $i++) {
			$day = date("D",mktime(0,0,0,$month,$i,$year)); //day, ex: sun, mon, etc
			$date = date("d F Y",mktime(0,0,0,$month,$i,$year)); //date format 01 January 2016
			$date2 = date("Y-m-d",mktime(0,0,0,$month,$i,$year)); //dte format 2016-08-01

			if ($row['day'] == $i) {
				//day found in database
				$json['data'][] = array(
					"day"=>$day,
					"date"=>$date,
					"date2"=>$date2,
					"status"=>"1",
					"time_in"=>substr($row['time_in'],0,5),
					"time_out"=>substr($row['time_out'],0,5),
					"time_break"=>substr($row['time_break'],0,5),
					"totaltime"=>substr($row['totaltime'],0,5),
					"overtime"=>substr($row['overtime'],0,5),
					"time_in"=>substr($row['time_in'],0,5),
					"place"=>$row['place'],
					"activity"=>$row['activity']
				);
				$row = mysqli_fetch_assoc($data);				
			}else if($day == 'Sat' || $day == 'Sun'){
				//day in holiday
				$json['data'][] = array(
					"day"=>$day,
					"date"=>$date,
					"date2"=>$date2,
					"status"=>"2"
				);
			}else{
				//day not holiday and not found in databases
				$json['data'][] = array(
					"day"=>$day,
					"date"=>$date,
					"date2"=>$date2,
					"status"=>"0"
				);
			}
		}
		$json['message'] = "Fetching data Successful";
		$json['status'] = "200";
		return json_encode($json);
	}

	//function to view month employee
	function view_month_attended($id,$month,$year){
		$db = connect_db();
		$id = mysqli_real_escape_string($db,$id);
		$month = mysqli_real_escape_string($db,$month);
		$year = mysqli_real_escape_string($db,$year);
		$temp = $db->query('SELECT *, SEC_TO_TIME(totaltime) totaltime2, SEC_TO_TIME(overtime) overtime2 FROM month_attended WHERE employee_id = "'.$id.'" AND date = "'.date("Y-m-d",mktime(0,0,0,$month,1,$year)).'"');
		$result = "";
		if(mysqli_num_rows($temp)){
			$data = mysqli_fetch_assoc($temp);
			if (strlen($data['overtime2']) == 8) {
				$overtime = substr($data['overtime2'], 0, 5);
			}else{
				$overtime = substr($data['overtime2'], 0, 6);
			}

			if (strlen($data['totaltime2']) == 8) {
				$totaltime = substr($data['totaltime2'], 0,5);
			}else{
				$totaltime = substr($data['totaltime2'], 0,6);
			}
			
			$json['message'] = "Fetching data Successful";
			$json['status'] = "200";
			$json['customer_name'] = $data['customer_name'];
			$json['project_name'] = $data['project_name'];
			$json['wo_number'] = $data['wo_number'];
			$json['overtime'] = $overtime;
			$json['totaltime'] = $totaltime;

			return json_encode($json);
		}else{
			return '{"status":"404"}';
		}
	}

	//delete attended
	function delete_attended($id,$date){
		$db = connect_db();
		$temp = $db->query('DELETE FROM attendance WHERE employee_id = "'.$id.'" AND date = "'.$date.'"');
		if ($temp) {
			return 1;
		}
		else{
			return 0;
		}	
	}

	//get month list from year
	function get_select_month($year,$id){
		$db = connect_db();			
		$query = ("SELECT EXTRACT(MONTH FROM date) month, SEC_TO_TIME(totaltime) totaltime, SEC_TO_TIME(overtime) overtime, attended, wo_number, customer_name, project_name  FROM month_attended WHERE employee_id = '$id' AND `date` BETWEEN '".date("Y-m-1",mktime(0,0,0,1,1,$year))."' AND '".date("Y-m-t",mktime(0,0,0,12,1,$year))."' ORDER by `date`");

		$data = $db->query($query);
		$row = mysqli_fetch_assoc($data);

		for ($i=1; $i < 13 ; $i++) {
			if($row['month'] == $i){
				$status = "1";
				$attended = $row['attended'];
				if (strlen($row['overtime']) == 8) {
					$overtime = substr($row['overtime'], 0, 5);
				}else{
					$overtime = substr($row['overtime'], 0, 6);
				}
				if (strlen($row['totaltime']) == 8) {
					$totaltime = substr($row['totaltime'], 0,5);
				}else{
					$totaltime = substr($row['totaltime'], 0,6);
				}
				$json['data'][] = array(
					"date"=>date("F Y",mktime(0,0,0,$i,1,$year)),
					"month"=>date("m",mktime(0,0,0,$i,1,$year)),
					"month2"=>date("M",mktime(0,0,0,$i,1,$year)),
					"status"=>$status,
					"attended"=>$attended,
					"wo_number"=>$row['wo_number'],
					"project_name"=>$row['project_name'],
					"customer_name"=>$row['customer_name'],
					"overtime"=>$overtime,
					"totaltime"=>$totaltime
				);
				$row = mysqli_fetch_assoc($data);
			}else{
				$attended = "";
				$status = "0";
				$json['data'][] = array(
					"date"=>date("F Y",mktime(0,0,0,$i,1,$year)),
					"month"=>date("m",mktime(0,0,0,$i,1,$year)),
					"month2"=>date("M",mktime(0,0,0,$i,1,$year)),
					"status"=>"0",
					"attended"=>""
				);
			}
		}
		$json['message'] = "Fetching data Successful";
		$json['status'] = "200";
		return json_encode($json);
	}

	//get notification
	function get_notification(){
		$db = connect_db();			
		$query = ("SELECT title, content, UNIX_TIMESTAMP(`timestamp`) `timestamp` FROM notification");

		$data = $db->query($query);
		$row = mysqli_fetch_assoc($data);

		$json['title'] = $row['title'];
		$json['content'] = $row['content'];
		$json['timestamp'] = $row['timestamp'];
		$json['date'] = date("d F Y, h:i",$row['timestamp']);
		$json['message'] = "Fetching data Successful";
		$json['status'] = "200";
		return json_encode($json);
	}
	 
	//---- end function extended ----
?>