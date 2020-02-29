<h5>You will need to connect your AWS clouds by connecting with your secret access key. For more information on how to get your secret access key <a href="https://aws.amazon.com/blogs/security/wheres-my-secret-access-key/">click here.</a></h5>
<div class="row">
<?php
  $foptions = array('style' => 'width:100%', 'class' => '', 'id' => "addaws", 'onsubmit' => "return validate()");
  echo form_open('clouds/saveaws', $foptions)
?>
  <input type="hidden" name="cloud" value="1">
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">AWS Access Keys</h3>
        <img style="border-radius:5px;position: absolute;right: 20px;" src="../assets/images/awslogo.png" class="header-brand-img" alt="AWS logo">
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname">Access Key ID</label>
              <input type="text" class="form-control" id="keyid" name="keyid" placeholder="Key Id">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Access Key Secret</label>
              <input type="password" class="form-control" id="keysecret" name="keysecret" placeholder="Key Secret">
              <input type="hidden" name="ckeysecret" id="ckeysecret">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Name for this Account</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="My account name">
             
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
            <button type="submit" class="btn btn-success-light mt-1" onclick="testAWS($('#keyid').val(), $('#keysecret').val(), '#addaws')">Connect</button>
          </div>
          
        </div>
        
      </div>
    </div>

  </div>
  

<?php echo form_close() ?>
</div>


<script>

function validate() {
  if ($("#keyid").val().length < 5) {
    $("#warningtext").html('Please input your Key id')
    $("#warningdiv").show()
    return(false)
  }
  if ($("#keysecret").val().length < 2) {
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