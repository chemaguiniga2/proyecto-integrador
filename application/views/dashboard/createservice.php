<div class="row">
<?php
  $foptions = array('style' => 'width:100%', 'class' => '', 'id' => "addaws", 'onsubmit' => "return validate()");
  echo form_open('clouds/saveservice', $foptions)
?>
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Service information</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname">Service name</label>
              <input type="hidden" name="prev" value="<?php echo isset($service) ? $service->id : ""?>">
              <input type="text" class="form-control" value="<?php echo isset($service) ? $service->name : ''?>" id="servicename" name="servicename" placeholder="Name">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Manager</label>
              <input type="text" class="form-control" value="<?php echo isset($service) ? $service->manager : ""?>" id="manager" name="manager" placeholder="Manager name">
              <input type="hidden" name="ckeysecret" id="ckeysecret">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Manager's email</label>
              <input type="email" class="form-control" value="<?php echo isset($service) ? $service->manager_email : ""?>" id="email" name="email" placeholder="manager@mycompany.com">
             
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Manager's phone</label>
              <input type="text" class="form-control" value="<?php echo isset($service) ? $service->manager_phone : ""?>" id="phone" name="phone" placeholder="Phone number">
              
            </div>
          </div>
          <div class="col-lg-12 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Service description</label>
              <input type="text" class="form-control" value="<?php echo isset($service) ? $service->description : ""?>" id="description" name="description" placeholder="Description">
              
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
            <button type="button" class="btn btn-danger-light mt-1" style="width:100%" onClick="window.location='https://omp.onecloudops.com/services';">Cancel</button>
          </div>
          <div class="col-lg-6 col-md-12">
            <button type="submit" class="btn btn-success-light mt-1">Save</button>
          </div>
          
        </div>
        
      </div>
    </div>

  </div>
  

<?php echo form_close() ?>
</div>


<script>

function validate() {
  if ($("#servicename").val().length < 3) {
    $("#warningtext").html('Please enter the service name')
    $("#warningdiv").show()
    return(false)
  }

  if ($("#manager").val().length < 3) {
    $("#warningtext").html('Please enter manager name')
    $("#warningdiv").show()
    return(false)
  }

  if ($("#phone").val().length < 3) {
    $("#warningtext").html('Please enter manager phone')
    $("#warningdiv").show()
    return(false)
  }

  if ($("#email").val().length < 3) {
    $("#warningtext").html('Please enter manager email')
    $("#warningdiv").show()
    return(false)
  }

  if ($("#description").val().length < 3) {
    $("#warningtext").html('Please enter service description')
    $("#warningdiv").show()
    return(false)
  }

  return(true)
}
</script>