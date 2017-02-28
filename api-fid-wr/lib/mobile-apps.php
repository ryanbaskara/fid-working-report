<?php
	include "extend-function.php";;
	//------ main function for routing mobile apps-------
	// function for -> /auth
	function auth(){
		//checking request data input valid	
		if (@$_POST['login_id'] && @$_POST['password']) {
			//if request data valid
			//checking user in database
			$temp = authentification($_POST['login_id'],$_POST['password']);
			if ($temp['row'] == 1) {
				//if found in database
				$row = $temp['content'];
				if ($row['status'] == 1) {
					//if user have access
					if (@$_POST['device_token']) {
						$temp = temp_update_employee_token($_POST['login_id'],$_POST['password'],$row['id'],$_POST['device_token']);
					}else{
						$temp = update_employee_token($_POST['login_id'],$_POST['password'],$row['id']);
					}
					if ($temp['process'] == 1){
						$json['status'] = "302";
						$json['message'] = "Login Successful";
						$json['token'] = $temp['token'];
						$json['id'] = $row['id'];
						$json['name'] = $row['name'];
						$json['position'] = $row['position'];
						return json_encode($json);
					}else{
						return '{"status":"401","message":"Login Failed"}' ;
					}
				}else{
					//if user not have access
					return '{"status":"401","message":"You dont have access"}' ;
				}
			}else{
				//if not found
				return '{"status":"404","message":"Login ID and Password doesn`t match"}' ;
			}
		}else{
			//if request not valid
			return '{"status":"400","message":"Bad Request"}' ;
		}
	}
	// function for -> /attended-day
	function post_attended_day(){
		//checking form data input valid		
		if (@$_POST['token'] && @$_POST['id'] && check_valid_date(@$_POST['date']) && @$_POST['time_in'] && @$_POST['time_out'] && @$_POST['time_break'] && @$_POST['place'] && @$_POST['activity'] && check_valid_time(@$_POST['time_in']) && check_valid_time(@$_POST['time_out']) && check_valid_time(@$_POST['time_break'])){
				//checking valid token and id
				if (check_token($_POST['token'],$_POST['id'])) {
					//if token valid
					//checking employee_id and date record in attended day table
					$date_month = substr($_POST['date'], 0, 8)."01";
					if (check_day_attendance($_POST['id'], $_POST['date'])) {
						//if records not found
						//get time_in, time_out, time_break, totaltime, and overtime
						$data_time = time_attended_day_handled($_POST['time_in'], $_POST['time_out'], $_POST['time_break'], $_POST['totaltime'], $_POST['overtime']);
						//input date attendance 
						if (input_day_attendance($_POST['id'],$_POST['date'],$data_time['time_in'],$data_time['time_out'],$data_time['time_break'],$data_time['overtime'],$data_time['totaltime'],$_POST['place'],$_POST['activity'])) {
							//update month-attandance
							//counting overtime, attended, totaltime
							$data = count_data_month($_POST['id'], $date_month);
							$null = '';
							if (check_month_attendance($_POST['id'], $date_month)) {
								//input month attendance 
								if (input_month_attendance($_POST['id'],$date_month,$null,$null,$null,$data['attended'],$data['overtime'],$data['totaltime'])) {
									//success input to database
									return '{"status":"200","message":"Success Input Attended"}' ;
								}else{
									//failed input to database
									return '{"status":"200","message":"error"}' ;
								}
							}else{
								//update month attendance 
								if (update_month_attendance($_POST['id'],$date_month,$null,$null,$null,$data['attended'],$data['overtime'],$data['totaltime'])) {
									//success input to database
									return '{"status":"200","message":"Success Input Attended"}' ;
								}else{
									//failed input to database
									return '{"status":"200","message":"error"}' ;
								}
							}
						}else{
							//failed insert attendance day
							return '{"status":"200","message":"error"}' ;
						}
					}else{
						//attendance found
						//get time_in, time_out, time_break, totaltime, and overtime
						$data_time = time_attended_day_handled($_POST['time_in'], $_POST['time_out'], $_POST['time_break'], $_POST['totaltime'], $_POST['overtime']);
						//update date attendance 
						if (update_day_attendance($_POST['id'],$_POST['date'],$data_time['time_in'],$data_time['time_out'],$data_time['time_break'],$data_time['overtime'],$data_time['totaltime'],$_POST['place'],$_POST['activity'])) {
							//update month-attandance
							//counting overtime, attended, totaltime
							$data = count_data_month($_POST['id'], $date_month);
							$null = '';
							if (check_month_attendance($_POST['id'], $date_month)) {
								//input month attendance 
								if (input_month_attendance($_POST['id'],$date_month,$null,$null,$null,$data['attended'],$data['overtime'],$data['totaltime'])) {
									//success input to database
									return '{"status":"200","message":"Success Update Attended"}' ;
								}else{
									//failed input to database
									return '{"status":"200","message":"error"}' ;
								}
							}else{
								//update month attendance 
								if (update_month_attendance($_POST['id'],$date_month,$null,$null,$null,$data['attended'],$data['overtime'],$data['totaltime'])) {
									//success input to database
									return '{"status":"200","message":"Success Update Attended"}' ;
								}else{
									//failed input to database
									return '{"status":"200","message":"error"}' ;
								}
							}
						}else{
							//failed insert attendance day
							return '{"status":"200","message":"error"}' ;
						}
					}
				}else{
					//token and id not valid
					return '{"status":"401","message":"You dont have access"}' ;
				}
		}else{
			//bad  request params
			return '{"status":"400","message":"Bad Request"}' ;
		}
	}
	// function for -> /attended-month
	function post_attended_month(){
		//checking form data input valid
		if (@$_POST['token'] && @$_POST['id'] && @$_POST['customer_name'] && @$_POST['project_name'] && @$_POST['wo_number'] && @$_POST['date']){
				//if form data input valid
				//checking token & id valid
				if (check_token($_POST['token'],$_POST['id'])) {
					//if token valid
					//counting overtime, attended, totaltime
					$data = count_data_month($_POST['id'], $_POST['date']);
					//checking employee_id & month on server 
					if (check_month_attendance($_POST['id'], $_POST['date'])) {
						//input month attendance 
						if (input_month_attendance($_POST['id'],$_POST['date'],$_POST['customer_name'],$_POST['project_name'],$_POST['wo_number'],$data['attended'],$data['overtime'],$data['totaltime'])) {
							//success input to database
							return '{"status":"200","message":"Success Input Month Attended"}' ;
						}else{
							//failed input to database
							return '{"status":"200","message":"Success Input Month Attended"}' ;
						}
					}else{
						//update month attendance 
						if (update_month_attendance($_POST['id'],$_POST['date'],$_POST['customer_name'],$_POST['project_name'],$_POST['wo_number'],$data['attended'],$data['overtime'],$data['totaltime'])) {
							//success input to database
							return '{"status":"200","message":"Success Update Month Attended"}' ;
						}else{
 							//failed input to database
							return '{"status":"200","message":"Failde Update Month Attended"}' ;
						}
					}
				}else{
					//if token invalid
					return '{"status":"401","message":"You dont have access"}' ;
				}
		}else{
			//if form data input invalid 
			return '{"status":"400","message":"Bad Request"}' ;
		}
	}
	// function for -> /data-month
	function get_data_month(){
		//checking request data input valid
		if (@$_GET['id'] && @$_GET['token'] && @$_GET['month'] && @$_GET['year'] && @$_GET['month'] > 0 && @$_GET['year'] > 1900 && @$_GET['month'] < 13 && @$_GET['year'] < 2100) {
			//if request valid
			//checking employee with token and id
			if (check_token($_GET['token'],$_GET['id'])) {
				//if token and id valid
				//get data month
				return get_data_month_attandace($_GET['month'],$_GET['year'],$_GET['id']);
			}else{
				//if token and id not valid
				return '{"status":"401","message":"You dont have access"}' ;
			}
		}else{
			//if request not valid
			return '{"status":"400","message":"Bad Request"}' ;
		}
	}
	// function for -> /view-month-attended-form
	function view_month_attended_form(){
		//checking form valid
		if (@$_GET['token'] && @$_GET['id'] && @$_GET['month'] && @$_GET['year']) {
			//if request valid
			//checking token valid
			if (check_token($_GET['token'],$_GET['id'])) {
				//get data month attandance
				return view_month_attended($_GET['id'],$_GET['month'],$_GET['year']);
			}else{
				//token invalid
				return '{"status":"401","message":"You dont have access"}' ;
		}
		}else{
			//if request not valid
			return '{"status":"400","message":"Bad Request"}' ;
		}
	}
	// function for -> /delete-attended-day
	function delete_attended_day(){
		//checking form valid
		if (@$_POST['token'] && @$_POST['id'] && @$_POST['date']) {
			//checking token valid
			if (check_token($_POST['token'],$_POST['id'])) {
			//get data month attandance
				$date_month = substr($_POST['date'], 0, 8)."01";
				$data_time = time_attended_day_handled($_POST['time_in'], $_POST['time_out'], $_POST['time_break'], $_POST['totaltime'], $_POST['overtime']);
				//input date attendance 
				if (delete_attended($_POST['id'],$_POST['date'])) {
					//update month-attandance
					//counting overtime, attended, totaltime
					$data = count_data_month($_POST['id'], $date_month);
					$null = '';
					if (check_month_attendance($_POST['id'], $date_month)) {
						//input month attendance 
						if (input_month_attendance($_POST['id'],$date_month,$null,$null,$null,$data['attended'],$data['overtime'],$data['totaltime'])) {
							//success input to database
							return '{"status":"200","message":"Deleted Successfully"}';
						}else{
							//failed input to database
							return '{"status":"200","message":"Deleted Unsuccessfull"}';
						}
					}else{
						//update month attendance 
						if (update_month_attendance($_POST['id'],$date_month,$null,$null,$null,$data['attended'],$data['overtime'],$data['totaltime'])) {
							//success input to database
							return '{"status":"200","message":"Deleted Successfully"}';
						}else{
							//failed input to database
							return '{"status":"200","message":"Deleted Unsuccessfull"}';
						}
					}
				}else{
					//failed insert attendance day
					return '{"status":"200","message":"delete failed"}' ;
				}
			}else{
				//if token and id invalid
				return '{"status":"401","message":"You dont have access"}' ;
			}
		}else{
			//if request form invalid
			return '{"status":"400","message":"Bad Request"}' ;
		}
	}
	// function for -> /select-month
	function select_month(){
		//checking form valid
		if (@$_GET['token'] && @$_GET['id'] && @$_GET['year'] && @$_GET['year'] > 2000 && @$_GET['year'] < 2100) {
			//if request form valid
			//checking token valid
			if (check_token($_GET['token'],$_GET['id'])) {
				// if token and id valid
				//get data month attandance
				$data = get_select_month($_GET['year'],$_GET['id']);
				return $data;
			}else{
				//if token and id invalid
				return '{"status":"401","message":"You dont have access"}' ;
			}
		}else{
			//if request form invalid
			return '{"status":"400","message":"Bad Request"}' ;
		}
	}

	// function for -> /notification
	function notification(){
		//checking form valid
		if (@$_GET['token'] && @$_GET['id']) {
			//if request form valid
			//checking token valid
			if (check_token($_GET['token'],$_GET['id'])) {
				// if token and id valid
				//get data month attandance
				$data = get_notification();
				return $data;
			}else{
				//if token and id invalid
				return '{"status":"401","message":"You dont have access"}' ;
			}
		}else{
			//if request form invalid
			return '{"status":"400","message":"Bad Request"}' ;
		}
	}
?>