<div class="row">
  <div class="container">
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
              echo form_open('security/enable2fa', $foptions)
            ?>
    <img src="<?php echo $qrcode ?>" class="" alt="">
    <br>
    <h5>Scan the QR code to add omp.onecloudops.com in Google Authenticator</h5>
    <br>
    <h5>Then input your token to activate 2FA in your account</h5>
    <input type="text" class="form-control" name ="token" id="token" style="max-width:300px;">
    <input type="hidden" name="secret" value="<?php echo $secret ?>">
    <br>
    <button type="submit" class="btn btn-primary-light btn-block" style="max-width:300px;">Enable</button>
    </div>
    <?php echo form_close() ?>
  </div>
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