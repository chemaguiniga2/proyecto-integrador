<div class="row">
<?php
  $foptions = array('style' => 'width:100%', 'class' => '', 'id' => "changepassword", 'onsubmit' => "return checkOk()");
  echo form_open('security/changepassword', $foptions)
?>
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Password change</h3>
        
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname">Current password</label>
              <input type="password" class="form-control" id="oldpass" name="oldpass" placeholder="Current password">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">New password</label>
              <input type="password" class="form-control" id="pass" name="pass" placeholder="New password">
              
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">

            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Repeat new password</label>
              <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Confirm password">
              
            </div>
          </div>
        </div>
 
        <div class="form-group">
        <div class="alert alert-warning form-control" id="warningdiv" style="<?php if (!isset($message)){echo 'display:none;';} ?>" role="alert">
          <span class="alert-inner--icon"></span>
          <span class="alert-inner--text" id="warningtext">
          <?php
            if (isset($message)) {
              echo($message);
            }
          ?>
          </span>
      </div>
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-success-light mt-1" >Change</button>
        
      </div>
    </div>

  </div>
  

<?php echo form_close() ?>
</div>

<div class="row">

  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">2 Factor Authentication <?php echo $active ? 'ENABLED' : 'DISABLED'?></h3>
        
      </div>
      <div class="card-body">
        <div class="row">
            <?php if ($haveauth) { ?>
          
          <div class="col-lg-12 col-md-12 text-center">
          <?php
            if ($active) {

              echo '<h5>To disable please enter your OTP code below</h5><br>';
              echo '<input type="text" class="form-control" name ="token" id="token" style="max-width:300px;">';
            } else {

              echo '<h5>To enable please enter your OTP code below</h5><br>';
              echo '<input type="text" class="form-control" name ="token" id="token" style="max-width:300px;">';
            }
            ?>
            <button type="submit" class="btn btn-primary-light btn-block" style="max-width:300px;"><?php echo $active == true ? "Disable" : "Enable"; ?></button>
         
          </div>
          
          <?php echo form_close(); ?>
          <?php } else { ?>
            <div class="col-lg-6 col-md-12">
              <h4>2 Factor Authentication is not configured <br>you should enable 2FA to improve your account security</h4>
              <br>
              <a class="btn btn-primary-light btn-block" href="<?php echo base_url() . 'security/enable2fa' ?>">Click here to activate 2FA</a>

              
            </div>
          <?php } ?>
        </div>
 
        <div class="form-group">
        <div class="alert alert-warning form-control" id="warningdiv" style="<?php if (!isset($message)){echo 'display:none;';} ?>" role="alert">
          <span class="alert-inner--icon"></span>
          <span class="alert-inner--text" id="warningtext">
          <?php
            if (isset($message)) {
              echo($message);
            }
          ?>
          </span>
      </div>
        </div>
      </div>

    </div>

  </div>
  
</div>

<script>
  function otpOk() {
    if ($("#token").val().length < 6) {
      $("#warningtext").html('Please verify yout OTP Token')
      $("#warningdiv").show()
      return(false)
    } else {
      return(true)
    }
  }

  function checkOk() {

    if($("#oldpass").val().length < 5) {
      $("#warningtext").html('Please verify your current password')
      $("#warningdiv").show()
      return(false)
    }

    if(!validatePass('pass')) {
      $("#warningtext").html('Password must contain Uppercase, lowercase and numbers and at least 8 characters')
      $("#warningdiv").show()
      return(false)
      
    }

    if ($("#pass").val() != $("#pass2").val()) {
      $("#warningtext").html('New password and password confirmation must match')
      $("#warningdiv").show()
      return(false)
    }

    return(true)
  }

  function validatePass(itemid) {
    // Validate lowercase letters
    var myInput = document.getElementById(itemid);
    valid = true
    var lowerCaseLetters = /[a-z]/g;
    if(!myInput.value.match(lowerCaseLetters)) {  
      valid = false
      
    }
    
    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(!myInput.value.match(upperCaseLetters)) {  
      valid = false
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(!myInput.value.match(numbers)) {  
      valid = false
    }
    
    // Validate length
    if(!myInput.value.length >= 8) {
      valid = false
    }
    
    return(valid)
  }
</script>