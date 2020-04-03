<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">

              <div class="btn-group mt-2 mb-2">
                <button type="button" id="selectcloud" class="btn btn-outline-primary btn-pill dropdown-toggle" data-toggle="dropdown">
                  <span id="selectcloudtext">All Clouds</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#" onclick="selectcloud(0)">All Clouds</a></li>
                  <li><a href="#" onclick="selectcloud(1)">AWS</a></li>
                  <li><a href="#" onclick="selectcloud(2)">Azure</a></li>
                </ul>
              </div>
              
              <div class="btn-group mt-2 mb-2" slyle="margin-left:60px;padding-left:60px;">
            <!--    <button type="button" id="selectcloud" class="btn btn-outline-primary btn-pill dropdown-toggle" data-toggle="dropdown">
                  <span id="selectcloudtext">Add Resources</span> <span class="caret"></span>
                </button>
            -->
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
        <!-- <?php print_r($resources) ?> -->
          <table class="table table-striped table-bordered text-nowrap w-100 dataTable no-footer" id="resourcestable">
            <thead>
              <th>Cloud</th>
              <th>Type</th>
              <th>Name</th>
              <th>Status</th>
              <th></th>
            </thead>
            <tbody>
              <?php 
              if (count($resources) > 0) {
                foreach ($resources as $resource) {

                  if ($resource->id_type == 1) {
                    if ($resource->status == "stopped" || $resource->status == "VM deallocated") {
                      $distop = 'display:none;';
                      $distart = '';
                    } else {
                      $distop = '';
                      $distart = 'display:none;';
                    }
                  } else {
                    $distop = 'display:none;';
                    $distart = 'display:none;';
                  }

                  $lnk = $resource->clcode;


                  $actionbutton = '<button type="button" class="btn btn-outline-primary btn-pill dropdown-toggle" data-toggle="dropdown">';
                  $actionbutton .= '<span>Actions</span> <span class="caret"></span></button>';
                  $actionbutton .= '<ul class="dropdown-menu" role="menu"><li style="' . $distop . '"><a href="#"  onclick="stopM(\'' . $resource->id . '\', \'' . $this->session->userdata('id') . '\',\'' . $resource->id_account . '\',\'' . $resource->rgcode . '\')">Stop</a></li>';
                  $actionbutton .= '<li style="' . $distart . '"><a href="#" onclick="start(\'' . $resource->id . '\', \'' . $this->session->userdata('id') . '\',\'' . $resource->id_account . '\',\'' . $resource->rgcode . '\')">Start</a></li><li><a href="#" onclick="getdetails(\'' . $resource->id . '\')">View Details</a></li>';
                  $actionbutton .= '<li><a href="#" onclick="setService(\'' . $resource->id . '\')">Resource groups</a></li></ul>';

                  echo '<tr><td>' . $resource->clname . '</td>';
                  echo '<td>' . $resource->tyname . '</td>';
                  echo '<td>' . $resource->name . '</td>';
                  echo '<td>' . $resource->status . '</td>';
                  echo '<td>' . $actionbutton . '</td></tr>';
                }
              } 
              ?>

          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function selectcloud(id, uid, acid) {
  if (id == 0) {
    $("#selectcloudtext").html('All clouds')
    var table = $('#resourcestable').DataTable();
 
    table
        .columns( 0 )
        .search( "" )
        .draw();
      
    }
  if (id == 1) {
    $("#selectcloudtext").html('AWS')
    var table = $('#resourcestable').DataTable();
 
    table
        .columns( 0 )
        .search( "AWS" )
        .draw();
      
    }
    if (id == 2) {
      $("#selectcloudtext").html('Azure')
      var table = $('#resourcestable').DataTable();

      table
        .columns( 0 )
        .search( "Azure" )
        .draw();
      
        
  }
}

function stopAWS(id, uid, acid, location) {
  $.get(cDef + "/aws/vm/stopvm?vmid=" + id + "&userid=" + uid + "&acid=" + acid + "&region=" + location,
  function(data) {
    if (data.success == true) {
      Swal.fire({
        position: 'top-end',
        type: 'info',
        title: data.message,
        showConfirmButton: false,
        timer: 3000
      }).then((result) => {
        if (data.reload) {
          location.reload()
        }
      })
    }
  })
}

function startAWS(id, uid, acid, location) {
  console.log(cDef + "/aws/vm/startvm?vmid=" + id + "&userid=" + uid + "&acid=" + acid)
  $.get(cDef + "/aws/vm/startvm?vmid=" + id + "&userid=" + uid + "&acid=" + acid + "&region=" + location,
  function(data) {
    if (data.success == true) {
      Swal.fire({
        position: 'top-end',
        type: 'info',
        title: data.message,
        showConfirmButton: false,
        timer: 3000
      }).then((result) => {
        if (data.reload) {
          location.reload()
        }
      })
    }
  })
}

function deleteAWS(id, uid, acid, location) {
  console.log(cDef + "/aws/vm/deletevm?vmid=" + id + "&userid=" + uid + "&acid=" + acid)
  $.get(cDef + "/aws/vm/deletevm?vmid=" + id + "&userid=" + uid + "&acid=" + acid + "&region=" + location,
  function(data) {
    if (data.success == true) {
      Swal.fire({
        position: 'top-end',
        type: 'info',
        title: data.message,
        showConfirmButton: false,
        timer: 3000
      }).then((result) => {
        if (data.reload) {
          location.reload()
        }
      })
    }
  })
}

function getdetails(id) {
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

  })

  $.get(sDef + "/clouds/getresourcedetails?id=" + id, 
    function(data) {
      console.log(data)
      data = JSON.parse(data)
      if (data.success == true) {
        Swal.close()
        let details = data.details
        var hdetails = ""
        for (var p in details) {
          if( details.hasOwnProperty(p) ) {
            hdetails += '<tr><td>' + p + "</td><td>" + details[p] + "</td></tr>";
          } 
        }   

        console.log(hdetails)
        Swal.fire({
          title: 'Resource details',
          html: `<div class="table-responsive"><table class="table card-table table-vcenter text-nowrap">
                ${hdetails}</table></div>`,
        })
      } else {
        Swal.close()
        Swal.fire('Please, verify your credentials')
      }
  })
}

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

function setService(id, uid, acid, vmname, location) {
  setServicePopup(id)
}

function setServiceAZ(id, uid, acid, vmname, location) {
  setServicePopup(id, 'AZ')
}

function setServicePopup(id) {
  $.get(sDef + "/clouds/getservices?resid=" + id,
    function(data) {
      console.log(data)
      let popdata = ""
      pdata = JSON.parse(data)
      if (pdata.servicelist.length > 0) {
        console.log(pdata)
        pdata.servicelist.forEach(element => {
          //checkme = "" //element.member ? "checked" : ""
          popdata += `<tr><td><input name="servicecheck[]" type="checkbox" value="${element.id}">${element.name}</td></tr>` 
        })
        popdata = '<table>' + popdata + '</table>'
        Swal.fire({
          title: 'Select services',
          html: popdata,
          showCancelButton: true,
          preConfirm: () => {
            var checked = ""
            $("input[name='servicecheck[]']:checked").each(function ()
            {
              checked += checked == "" ? "" : "-----"
              checked += $(this).val()
              console.log($(this))
            });
            checked += checked == "" ? 'unlink' : ''
            $.get(sDef + "/clouds/setservices?type=1&resid=" + id + "&slist=" + checked,
            function(data2) {
              console.log(data2)
              swal.close
            })
            

          }
        })
      }
  })
}

function updateServices() {
  var checked = []
  $("input[name='servicecheck[]']:checked").each(function ()
  {
      checked.push(parseInt($(this).val()));
  });
}
</script>

