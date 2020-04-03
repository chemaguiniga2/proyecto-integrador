<div class="row">
  <!--   div iz        -->
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <!--   card iz        -->
    <div class="card">

      <!--   body iz        -->
      <div class="card-body">
      <?php
  $foptions = array('style' => 'width:100%', 'class' => '', 'id' => "addaws", 'onsubmit' => "return validate()");
  echo form_open('clouds/saveservice', $foptions)
?>
        <div id="vmdivs">
          <div class="col-lg-6 col-md-12">
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
          <div class="col-lg-6 col-md-12">
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
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
            <label for="os">Operating System</label>
            <select name="cpu" id="cpu" class="form-control custom-select" style="width:100%;">
              <option value="linux">Linux</option>
              <option value="windows">Windows</option>
            </select>
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="form-group">
            <button class="btn btn-success-light mt-1" onclick="getVMFrom()">Search</button>
            </div>
          </div>


        </div>

      </div>
      <!--   fin body iz        -->

    </div>
    <!--   fn card iz        -->
  </div>
  <!--   fin div iz        -->

  <!--   div der        -->
  <div class="col-lg-9 col-xl-9 col-md-9 col-sm-12">
    <!--   card der        -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Available instances</h3>
            
      </div>
      <!--   body der        -->
 
          
      <div id="vmdivr">
        <div class="table-responsive">
          <table class="table card-table table-vcenter text-nowrap">
            <thead>
              <tr>
                <th>Provider</th>
                <th>Name</th>
                <th>CPU</th>
                <th>RAM</th>
                <th>Storage</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">AWS</th>
                <td>X2.mini</td>
                <td>2</td>
                <td>2</td>
                <td>8Gb</td>
                <td>0.003$ Hour</td>
              </tr>
              
              
            </tbody>
          </table>
        </div>
      </div>

      <!--   fin body der        -->

      <div class="card-footer">
            
            
      </div>
    </div>
    <!--   fn card der        -->
  </div>
<!--   fn div der        -->
<?php echo form_close() ?>
</div>

<script>
function getAccountsFrom() {
  cloud = $("#cloud").val()
  $.get(sDef + "/clouds/getaccountsfrom?cloud=" + cloud, 
  function(data) {
    console.log(data)
    pdata = JSON.parse(data)
    if (pdata.success == true) {
      optionsl = ""
      
      
      pdata.accountlist.forEach(element => {
        optionsl += '<option value="' + element.id + '">' + element.name + '</option>'
      })
      $("#account").html(optionsl)
    }
  })
}

function getVMFrom() {
  account = $("#account").val()
  $.get(sDef + "/clouds/getvmpfrom?account=" + account + "&cpu=" + $("#cpu").val() + "&cloud=" + cloud, 
  function(data) {
    console.log(data)
    pdata = JSON.parse(data)
    if (pdata.success == true) {
      optionsl = ""
      pdata.vmlist.forEach(element => {
        optionsl += '<option value="' + element.id + '">' + element.description + '</option>'
      })
      $("#itype").html(optionsl)
    }
  })
}

</script>