<?php
session_start();
 include 'config.php';
 
 if(isset($_POST['btn-login']) ) { 
  $login_id = mysqli_real_escape_string($conn,$_POST['login_id']);
  $password = mysqli_real_escape_string($conn,$_POST['password']);
   
  $res = mysqli_query($conn,"SELECT login_id, password, name FROM admin WHERE login_id='$login_id'");  
  $row = mysqli_fetch_array($res); 
  
  if(mysqli_num_rows($res) == 1 && $row['password']==$password ) {
    
    $_SESSION['user'] = $row['login_id'];
    $_SESSION['fullname'] = $row['name'];
    header("Location: working-report");
  } else if(mysqli_num_rows($res) == 1) {
    header("Location: login;username-password-doesn't-match");    
  } else{
    header("Location: login;user-not-found");
  }
 }
?>