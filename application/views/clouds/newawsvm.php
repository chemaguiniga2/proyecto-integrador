<div class="row">
<?php
  $foptions = array('style' => 'width:100%', 'class' => '', 'id' => "addawsvm", 'onsubmit' => "");
  echo form_open('clouds/newawsvmadd', $foptions)
?>
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Virtual Machine Configuration</h3>
        <img style="border-radius:5px;position: absolute;right: 20px;" src="../assets/images/awslogo.png" class="header-brand-img" alt="AWS logo">
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname">Select VM Size</label>
              <select name="type" id="type" class="form-control custom-select">
              <?php
                foreach ($vmtype as $type) {
                  echo '<option value="' . $type->id . '">' . $type->cpu . ' cores ' . $type->ram . 'Gb Ram</option>';
                }

              ?>
              </select>
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Hard Drive Size</label>
              <select name="hdd" id="hdd" class="form-control custom-select">
                <option value='30'>30 GB</option>
                <option value='50'>50 GB</option>
                <option value='80'>80 GB</option>

              </select>
            </div>
          </div>
          <div class="col-lg-12 col-md-12">
            <div class="form-group">
              <label for="exampleInputname1">Name for this Virtual Machine</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="My vm name">
             
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
        <button type="submit" class="btn btn-success-light mt-1" >Create</button>
        
      </div>
    </div>

  </div>
  

<?php echo form_close() ?>
</div>
