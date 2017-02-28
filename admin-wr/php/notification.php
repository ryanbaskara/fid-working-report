    <?php 
  if (@$_SESSION['notification']) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']);?>
    <div class="modal fade" id="notification-modal" tabindex="-1" role="dialog" >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo @$notification; ?></h4>
          </div>
        </div>
      </div>
    </div>    
    <script type="text/javascript">
       $('#notification-modal').modal();
    </script>
    <?php } ?>
