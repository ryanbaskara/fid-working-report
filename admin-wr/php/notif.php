<?php
  include 'config.php';
  include 'check-login.php';
  if( isset($_POST['post_notif']) ){

      $title = $_POST["title"];
      $content = $_POST["content"];

      $title_up = mysqli_real_escape_string($conn,$title);
      $content_up = mysqli_real_escape_string($conn,$content);

      $query = "UPDATE `notification` SET  `title` =  '$title_up', `content` = '$content_up' WHERE  `notification`.`id` =1";
      $process = mysqli_query($conn,$query);

      $query = "SELECT device_token FROM employee WHERE device_token != '' ";
      $process = mysqli_query($conn,$query);

      while ($row = mysqli_fetch_assoc($process)) {
        $token[] = $row['device_token'];
      }

       //Getting api key 
      $api_key = 'AIzaSyB9E5-VPsGt2kucoaU-MrTkj3UEKG4FTU8'; 

      //Getting registration token we have to make it as array 
      $reg_token = $token;

      //Creating a message array 
      $message = array
      (
      'title' => $title,
      'content' => $content,
      'date' => date("d F Y")
      );

      $message = json_encode($message);

      $msg = array
       (
       'message' => $message,
       'title' => 'Message from Simplified Coding',
       'subtitle' => 'Android Push Notification using GCM Demo',
       'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
       'vibrate' => 1,
       'sound' => 1,
       'largeIcon' => 'large_icon',
       'smallIcon' => 'small_icon'
       );


    
      //Creating a new array fileds and adding the msg array and registration token array here 
      $fields = array
      (
      'registration_ids' => $reg_token,
      'data' => $msg
      );

      //Adding the api key in one more array header 
      $headers = array
      (
      'Authorization: key=' . $api_key,
      'Content-Type: application/json'
      ); 

      //Using curl to perform http request 
      $ch = curl_init();
      curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
      curl_setopt( $ch,CURLOPT_POST, true );
      curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
      curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ));

      //Getting the result 
      $result = curl_exec($ch );
      curl_close( $ch );

      //Decoding json from result 
      $res = json_decode($result);


      //Getting value from success 
      $flag = $res->success;

   		if ($flag > 1) {
        $_SESSION['notification'] = "Successfully Update Notification";
        header("Location: /admin-wr/notification");
      }else{
        $_SESSION['notification'] = "Failed Update Notification";
        header("Location: /admin-wr/notification");
      }
 }
?>
