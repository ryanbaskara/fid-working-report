 <!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Admin Working Report | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="/admin-wr/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin-wr/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/admin-wr/dist/css/fid-wr.min.css" rel="stylesheet" type="text/css" />
    <script src="/admin-wr/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/admin-wr/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </head>
  <body class="login-page">
    <div class="login-box box box-danger">
      <div class="login-logo">
        <img src="dist/img/logo.png" width="80%" alt="FID Working Report"/>
      </div>
      <div class="login-box-body">
        <p class="login-box-msg"><b>Administator Dashboard</b></p>
        <form action="auth" method="post">
          <div class="form-group has-feedback" id="div_login_id">
            <input required type="text" class="form-control" name="login_id" id="login_id" placeholder="login_id"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback" id="div_login_id">
            <input required type="password" class="form-control" name="password" id="password" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <?php if (@$_GET['error']) {
            if ($_GET['error'] == 1) { $notif_text = 'User not found'; } else{ $notif_text = "Username and password doesn't match"; }?>
          <p class="text-red" align="center"><?php echo $notif_text ?></p>
          <?php } ?>
          <br/>
          <div class="form-group has-feedback" align="right" style="margin-bottom:0px;margin-top:-20px">
              <button type="submit" class="btn btn-danger " name="btn-login" id="btn_sign_in">Sign In</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>