<div class="row">
<?php /*
  $foptions = array('style' => 'width:100%', 'class' => '', 'id' => "addaws", 'onsubmit' => "return validate()");
  echo form_open('clouds/saveservice', $foptions) */
?>
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
        <div class="col-lg-3 col-md-3">
            <div class="form-group">
            <label for="cpu">Cpus</label>
            <select name="cpu" id="cpu" class="form-control custom-select" style="width:100%;">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="4">4</option>
              <option value="8">8</option>
              <option value="16">16</option>
              <option value="32">32</option>
              <option value="64">64</option>
            </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3">
            <div class="form-group">
            <label for="ram">Ram</label>
            <select name="rm" id="ram" class="form-control custom-select" style="width:100%;">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="4">4</option>
              <option value="8">8</option>
              <option value="16">16</option>
              <option value="32">32</option>
              <option value="64">64</option>
            </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3">
            <div class="form-group">
            <label for="os">Operating System</label>
            <select name="cpu" id="cpu" class="form-control custom-select" style="width:100%;">
              <option value="linux">Linux</option>
              <option value="windows">Windows</option>
            </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3">
            <div class="form-group">
            <button class="btn btn-success-light mt-1" onclick="getVMFrom()">Search</button>
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
  

<?php /* echo form_close() */ ?>
</div>