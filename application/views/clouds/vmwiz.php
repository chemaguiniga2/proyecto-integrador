<div class="row">
<input type="hidden" name="selvm" id="selvm" val="">
<input type="hidden" name="selc" id="selc" val="">
<?php 
  echo '<script>var uaccounts = ' . $acjson . ';</script>';
?>
  <!--   div iz        -->
  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <!--   card iz        -->
    <div class="card">
      <div class="card-header">
        <h3 id="whead" class="card-title">Select size and operating system</h3>
      </div>
      <!--   body iz        -->
      <div class="card-body">
        
        <div class="wtab">
          <div class="row">
            <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3" >
            <div class="form-group overflow-hidden">
                <label for="region">Region</label>
                <select name="region" id="region" class="form-control custom-select" style="width:100%;">
                  <?php 
                    foreach ($regions as $region) {
                      echo '<option value="' . $region->id . '">' . $region->name . '</option>';
                    }
                  
                  ?>
                </select>
              </div>

              <div class="form-group overflow-hidden">
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

              <div class="form-group overflow-hidden">
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

              <div class="form-group overflow-hidden">
                <label for="os">Operating System</label>
                <select name="cpu" id="cpu" class="form-control custom-select" style="width:100%;">
                  <option value="linux">Linux</option>
                  <option disabled value="windows">Windows</option>
                </select>
              </div>
              <button class="btn btn-success-light mt-1" onclick="getVMFrom()">Search</button>
            </div>
            <div class="col-lg-9 col-xl-9 col-md-9 col-sm-9" >
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
                  <tbody id="filterbody">

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="wtab">
          <div class="row">
            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4" >
              <div class="form-group overflow-hidden">
                <label for="acid">Account ID</label>
                <select name="acid" id="acid" class="form-control custom-select" style="width:100%;">
                  
                </select>
              </div>

            </div>

            <div class="col-lg-8 col-xl-8 col-md-8 col-sm-8" >
              <div class="form-group overflow-hidden">
                <label for="name">Name for this Virtual Machine</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="My vm name">
                  
              </div>
            </div>


          </div>
        </div>

        <div class="wtab">
        <div class="row" id="fstp1" style="">
            <div class="col-md-12">
              <h4>Click Create VM button when ready</h4>

            </div>
          </div>

          <div class="row" id="fstp2" style="display:none;">
            <div class="col-md-12">
              <h4>Please wait...</h4>
              <h5>deployment in progress</h5>
            </div>
            <div class="col-md-12">
              <div class="dimmer active">
                <div class="spinner"></div>
              </div>
            </div>
          </div>

          <div class="row" id="fstp3" style="display:none;">
            <div class="col-md-12" id="deployresult">
              <h4>Please wait...</h4>
              <h5>deployment in progress</h5>
            </div>
          </div>

        </div>

      </div>
      <!--   fin body iz        -->
      <div class="card-footer">
        <div class="row">
          <div class="col-lg-2 col-md-2">
            <a id="cancelBtn" href="<?php echo base_url() . 'clouds/resources' ?>" class="btn btn-pill btn-danger-light">Cancel</a>
          </div>
          <div class="col-lg-10 col-md-10" style="text-align: right">
            <button id="prevBtn" class="btn btn-pill btn-warning-light" onclick="nextPrev(-1)">Prev</button>
            <button id="nextBtn" class="btn btn-pill btn-success-light" onclick="nextPrev(1)">Next</button>
          </div>
        </div>
        
      </div>
    </div>
    <!--   fn card iz        -->
  </div>
  <!--   fin div iz        -->

  <!--   div der        -->

<!--   fn div der        -->

</div>

<script>
function getAccountsFrom() {
  cloud = $("#cloud").val()
  $.get(sDef + "/clouds/getaccountsfrom?cloud=" + cloud, 
  function(data) {
    console.log(data)
    pdata = JSON.parse(data)
    if (pdata.success == true) {
      filterhtml = ""
      pdata.available.forEach(element => {
        optionsl += '<option value="' + element.id + '">' + element.name + '</option>'
      })
      $("#account").html(optionsl)
    }
  })
}

function getVMFrom() {
  account = $("#account").val()
  $.get(sDef + "/clouds/getvmprices?cpu=" + $("#cpu").val() + "&ram=" + $("#ram").val() + "&region=" + $("#region").val(), 
  function(data) {
    //console.log(data)
    pdata = JSON.parse(data)
    if (pdata.success == true) {
      tbhtml = ""
      pdata.vmlist.forEach(element => {
        
        tbhtml += `<tr>
                    <th scope="row"><input type="radio" name="smachine" value="${element.id}" onclick="$('#selvm').val('${element.id}');$('#selc').val('${element.name}')"> ${element.name} - ${element.region_name}</th>
                    <td>${element.typeid}</td>
                    <td>${element.cpu}</td>
                    <td>${element.ram}</td>
                    <td>${element.storage}</td>
                    <td>${element.price}$ Hour</td>
                  </tr>`
      })
      $("#filterbody").html(tbhtml)
    }
  })
}

</script>

<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
var whead = ['Select size and operating system', 'Select account', 'Review deployment']
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("wtab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Create VM";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  document.getElementById("whead").innerHTML = whead[n]
  //... and run a function that will display the correct step indicator:
  //fixStepIndicator(n)
}

function nextPrev(n) {
  var x = document.getElementsByClassName("wtab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && (!validateForm())) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    $("#nextBtn").hide();
    $("#prevBtn").hide();
    $("#cancelBtn").hide();
    $("#fstp1").hide();
    $("#fstp2").show();
    createvm()
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  
  if (currentTab == 0) {
    if ($("#selvm").val() == "" || $("#selc").val() == "") {
      alert("You must select an VM type from the list")
      return false
    }
    if ($("#selc").val() == "AWS") {
      if (uaccounts.AWS.length < 1) {
        alert("You must register an AWS account to start a new AWS service")
        return false
      } else {
        ophtml = ""
        uaccounts.AWS.forEach(elem => {
          ophtml += `<option value="${elem.id}">${elem.name}</option>`
        })
        $("#acid").html(ophtml)
      }
    } else {
      if (uaccounts.AZ.length < 1) {
        alert("You must register an Azure account to start a new Azure service")
        return false
      } else {
        ophtml = ""
        uaccounts.AZ.forEach(elem => {
          ophtml += `<option value="${elem.id}">${elem.name}</option>`
        })
        $("#acid").html(ophtml)
      }
    }
  } else if (currentTab == 1) {
    if ($("#name").val().length < 8) {
      alert("Please give a name for the Virtual Machine")
      return false
    }
  } else if (currentTab == 2) {

  }

  return true
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}

function createvm() {
  pdata = {
      cloud: $("#selc").val(),
      vmtype: $("#selvm").val(),
      acid: $("#acid").val()
    }
  $.post("https://omp.onecloudops.com/clouds/createresource", pdata, function(result){
    console.log(result)
    result = JSON.parse(result)
    if (result.success) {
      rhtml = `        <h4>Deployment in progress</h4>
        <br>
        <h5>Click the button below to download the VM certificate</h5>
        <h5>We don't store any copy! - Keep it safe!</h5>
        <br>
        
        <button type="button" class="btn btn-success-light mt-1" onclick="sendcertificate('certificate.pem', ${result.pkey})">Download</button>
      `
    } else {
      rhtml = ` <h4>There was a problem!</h4>
        <br>
        <h5>VM was ot deployed</h5>
      `
    }
    $("#cancelBtn").show();
    $("#cancelBtn").html("Finish");
  });
}
</script>