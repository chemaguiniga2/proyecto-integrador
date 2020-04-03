<div class="row">
<div class="col-lg-3 col-md-12"></div>
  <div class="col-lg-6 col-md-12">
    <div class="card ">
      <div class="card-body">
      <div class="text-center">
        <div class="alert alert-warning form-control" id="warningdiv" style="max-width:300px;<?php if (!isset($message)){echo 'display:none;';} ?>" role="alert">
            <span class="alert-inner--icon"></span>
            <span class="alert-inner--text" id="warningtext">
            <?php
              if (isset($message)) {
                echo($message);
              }
            ?>
            </span>
        </div>
        <?php
                $foptions = array('id' => "enable2fa", 'onsubmit' => "return checkOk()");
                  echo form_open('security/activateotp', $foptions)
                ?>
        
        <br>
        <?php
          if ($active) {
            echo '<h4>2 Factor Authentication is currently <em>ENABLED</em></h4>';
            echo '<h5>To disable please enter your OTP code below</h5><br>';
            echo '<input type="text" class="form-control" name ="token" id="token" style="max-width:300px;">';
          } else {
            echo '<h4>2 Factor Authentication is currently <em>DISABLED</em></h4>';
            echo '<h5>To enable please enter your OTP code below</h5><br>';
            echo '<input type="text" class="form-control" name ="token" id="token" style="max-width:300px;">';
          }
        ?>

        <br>

        <br>
        <button type="submit" class="btn btn-primary-light btn-block" style="max-width:300px;"><?php echo $active == true ? "Disable" : "Enable"; ?></button>
        </div>
        <?php echo form_close() ?>
      </div>
    </div>
    
  </div>
  <div class="col-lg-3 col-md-12"></div>
</div>

<script>
function checkOk() {
  if ($("#token").val().length < 6) {
    $("#warningtext").html('Please verify yout OTP Token')
    $("#warningdiv").show()
    return(false)
  } else {
    return(true)
  }
}
</script>