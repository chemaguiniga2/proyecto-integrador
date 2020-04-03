<h5>Enter Azure or Office 365 credentials here to connect Microsoft Azure Cloud Accounts. You may connect multiple accounts.</h5>
<div class="row">
<?php
  $foptions = array('style' => 'width:100%', 'class' => '', 'id' => "addazure", 'onsubmit' => "return validate()");
  echo form_open('clouds/saveazure', $foptions)
?>
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Azure Credentials</h3>
        <img style="border-radius:5px;position: absolute;right: 20px;" src="../assets/images/azurelogo.png" class="header-brand-img" alt="AWS logo">
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username">
              
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              <input type="hidden" name="cpassword" id="cpassword">
              <input type="hidden" name="ctoken" id="ctoken">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Subscription Id</label>
              <input type="text" class="form-control" id="subscriptionid" name="subscriptionid" placeholder="Subscription Id">
              
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Region</label>
              <select name="region" id="region" class="form-control custom-select">
              <?php
                foreach ($regions as $region) {
                  echo '<option value="' . $region->id . '">' . $region->name . '</option>';
                }

              ?>
                <option value="br" data-data="{&quot;image&quot;: &quot;../assets/images/flags/br.svg&quot;}">Brazil</option>
              </select>
              
            </div>
          </div>
          <div class="col-lg-12 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Name for this Account</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="My account name">
             
            </div>
          </div>
        </div>
 
        <div class="form-group">
        <div class="alert alert-warning form-control" id="warningdiv" style="display:none;" role="alert">
          <span class="alert-inner--icon"></span>
          <span class="alert-inner--text" id="warningtext">
      </div>
        </div>
      </div>

      <div class="card-footer">
                
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <button type="button" class="btn btn-danger-light mt-1" style="width:100%" onClick="window.location='https://omp.onecloudops.com/clouds';">Cancel</button>
          </div>
          <div class="col-lg-6 col-md-12">
            <button type="submit" class="btn btn-success-light mt-1" onclick="testAzure($('#username').val(), $('#password').val(), '#addazure')">Connect</button>
          </div>
          
        </div>
      </div>
    </div>

  </div>
  

<?php echo form_close() ?>
</div>


<script>

function validate() {

  if ($("#username").val().length < 5) {
    $("#warningtext").html('Please input your Key id')
    $("#warningdiv").show()
    return(false)
  }
  if ($("#password").val().length < 2) {
    $("#warningtext").html('Please input your Key Secret')
    $("#warningdiv").show()
    return(false)
  }
  if ($("#name").val().length < 2) {
    $("#warningtext").html('Please give a name for this account')
    $("#warningdiv").show()
    return(false)
  }

  if (!checkFormOk()) {
    return(false)
  }
  
  return(true)
}
</script>