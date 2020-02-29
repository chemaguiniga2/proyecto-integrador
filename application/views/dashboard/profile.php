<div class="row">
<?php
  $foptions = array('style' => 'width:100%', 'class' => '', 'id' => "updateprofile", 'onsubmit' => "return validate()");
  echo form_open('dashboard/updatep', $foptions)
?>
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Edit Profile</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname">First Name</label>
              <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?php echo $fname ?>">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Last Name</label>
              <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name" value="<?php echo $lname ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input disabled type="email" class="form-control" name="email" id="email" placeholder="email address" value="<?php echo $email ?>">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputnumber">Contact Number</label>
              <input type="text" class="form-control" id="phone" name="phone" placeholder="phone number" value="<?php echo $phone ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Company Name</label>
              <input type="text" class="form-control" id="company" name="company" placeholder="Company" value="<?php echo $company ?>">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputnumber">Your Role</label>
              <input type="text" class="form-control" id="role" name="role" placeholder="Role in the company" value="<?php echo $role ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label class="form-label">Company Website</label>
              <input type="text" class="form-control" id="website" name="website" placeholder="http://mywebsite.com" value="<?php echo $website ?>">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label class="form-label">Company Logo link</label>
              <input type="text" class="form-control" id="logo" name="logo" placeholder="http://mywebsite.com/logo.jpg" value="<?php echo $logo ?>">
            </div>
          </div>
        <!--
        <div class="form-group">
          <label class="form-label">Company Website</label>
          <input type="text" class="form-control" id="website" name="website" placeholder="http://mywebsite.com" value="<?php echo $website ?>">
        </div>

        -->
            <input type="hidden"  value="<?php echo $companyid ?>">
        <div class="form-group">
        <div class="alert alert-warning form-control" id="warningdiv" style="display:none;" role="alert">
          <span class="alert-inner--icon"></span>
          <span class="alert-inner--text" id="warningtext">
      </div>
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-success-light mt-1">Save</button>
        
      </div>
    </div>

  </div>
  

<?php echo form_close() ?>
</div>


<script>

function validate() {
  if ($("#fname").val().length < 2) {
    $("#warningtext").html('Please input your name')
    $("#warningdiv").show()
    return(false)
  }
  if ($("#lname").val().length < 2) {
    $("#warningtext").html('Please input your lastname')
    $("#warningdiv").show()
    return(false)
  }
  if ($("#phone").val().length < 5) {
    $("#warningtext").html('Please input phone number')
    $("#warningdiv").show()
    return(false)
  }
  if ($("#company").val().length < 2) {
    $("#warningtext").html('Please input your company name')
    $("#warningdiv").show()
    return(false)
  }
  if ($("#role").val().length < 2) {
    $("#warningtext").html('Please input your company role')
    $("#warningdiv").show()
    return(false)
  }
  if ($("#website").val().length < 2) {
    $("#warningtext").html('Please input your company\'s website')
    $("#warningdiv").show()
    return(false)
  }
  return(true)
}
</script>