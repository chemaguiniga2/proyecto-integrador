<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
        <div class="btn-group mt-2 mb-2" slyle="margin-left:60px;padding-left:60px;">
          <button type="button" id="addservice" class="btn btn-outline-primary btn-pill">
            <a href="<?php echo base_url() . 'clouds/createservice' ?>" >Add Resource Group</a>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url() . 'clouds/vmwiz' ?>" >Virtual Machine</a></li>
            <li><a href="<?php echo base_url() . 'clouds/vmwiz' ?>" >Storage</a></li>
            <li><a href="<?php echo base_url() . 'clouds/vmwiz' ?>" >Database</a></li>
            <li><a href="<?php echo base_url() . 'clouds/vmwiz' ?>" >Container</a></li>
          </ul>
        </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered text-nowrap w-100 dataTable no-footer" id="resourcestable">
            <thead>
              <th>Name</th>
              <th>Resources</th>
              <th>Status</th>
              <th>Manager</th>
              <th></th>
            </thead>
            <tbody>
              <?php 
              $rlist = "";
              foreach ($servicestable as $service) {
                $rlist = "";
                if (count($service['resources']) > 0) {
                  foreach ($service['resources'] as $single) {
                    $rlist .= ($rlist != "") ? "<br>" : "";
                    $rlist .= '<a href="#" onclick="getdetail' . $single['cloud'] . '(\'' . $single['id'] . '\', \'' . $this->session->userdata('id') . '\',\'' . $single['id_account'] . '\',\'' . $single['name'] . '\',\'' . $single['location'] . '\')">' . $single['display'] .'</a>';
                  }
                } else {
                  $rlist = "No resources";
                }
                echo '<tr><td>' . $service['name'] . '</td>';
                echo '<td>' . $rlist . '</td>';
                echo '<td>' . $service['status'] . '</td>';
                echo '<td>' . $service['manager'] . '</td>';
                echo '<td><a href="' . base_url() . 'clouds/modifyservice?sid=' . $service['id'] . '">Modify</a></td></tr>';
              }
              echo "<!--";print_r($servicestable);echo "-->";
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function getdetailAWS(id, uid, acid, vmname, location) {
  let timerInterval
  Swal.fire({
    title: 'Getting VM details',
    html: 'Please wait until the information is ready',
    timer: 20000,
    onBeforeOpen: () => {
      Swal.showLoading()

    },
    onClose: () => {
      clearInterval(timerInterval)
    }
  }).then((result) => {
    if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.timer
    ) {
      
    }
  })

  $.get(cDef + "/aws/vm/details?vmid=" + id + "&userid=" + uid + "&acid=" + acid + "&region=" + location, 
    function(data) {
      console.log(data)
      if (data.success == true) {
        Swal.close()
        openports = ""
        data.instancedetails.ports.forEach(elem => {
          if (openports.length > 1) openports +="<br>"
          openports +=elem
        })
        var d = new Date(data.instancedetails.launched);

        var datestring = d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear() + " " +
        d.getHours() + ":" + d.getMinutes();
        Swal.fire({
          title: 'VM details',
          html: `<div class="table-responsive"><table class="table card-table table-vcenter text-nowrap">
                <tr><td>Type: </td><td>${data.instancedetails.type}</td></tr>
                <tr><td>Private IP: </td><td>${data.instancedetails.privateip}</td></tr>
                <tr><td>Public IP: </td><td>${data.instancedetails.publicip} </td></tr>
                <tr><td>Created in: </td><td>${datestring}</td></tr>
                <tr><td>Open ports: </td><td>${openports}</td></tr></table></div>`,
        })
      } else {
        
        Swal.close()
        Swal.fire('Please, verify your credentials')
      }
  })

}

function getdetailAZ(id, uid, acid, vmname, location) {
  let timerInterval
  Swal.fire({
    title: 'Getting VM details',
    html: 'Please wait until the information is ready',
    timer: 20000,
    onBeforeOpen: () => {
      Swal.showLoading()

    },
    onClose: () => {
      clearInterval(timerInterval)
    }
  }).then((result) => {
    if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.timer
    ) {
      
    }
  })

  $.get(cDef + "/azure/vm/details?vmname=" + vmname + "&vmid=" + id + "&userid=" + uid + "&acid=" + acid + "&region=" + location,
    function(data) {
      console.log(data)
      if (data.success == true) {
        Swal.close()
        openports = ""
        if ($.isArray(openports)) {
          data.instancedetails.ports.forEach(elem => {
          if (openports.length > 1) openports +="<br>"
          openports +=elem
          })
        }

        var d = new Date(data.instancedetails.launched);

        var datestring = d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear() + " " +
        d.getHours() + ":" + d.getMinutes();
        Swal.fire({
          title: 'VM details',
          html: `<div class="table-responsive"><table class="table card-table table-vcenter text-nowrap">
                <tr><td>Type: </td><td>${data.instancedetails.type}</td></tr>
                <tr><td>Private IP: </td><td>${data.instancedetails.privateip}</td></tr>
                <tr><td>Public IP: </td><td>${data.instancedetails.publicip} </td></tr>
                <!--<tr><td>Created in: </td><td>${datestring}</td></tr>
                <tr><td>Open ports: </td><td>${openports}</td></tr> --></table></div>`,
        })
        } else {
        Swal.close()
        Swal.fire('Please, verify your credentials')
      }
  })

}
</script>

