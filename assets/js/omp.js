var formOk = false;

function checkFormOk() {
  return formOk
}

function testAzure(username, password, form) {

  azusername = username
  azpassword = password
  let timerInterval
  Swal.fire({
    title: 'Adding Cloud',
    html: 'Please wait until your credentials are verifyed and the cloud is set up',
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

  $.get(cDef + "/azure/session/login?azusername=" + azusername + '&azpassword='+azpassword, 
    function(data) {
      console.log(data)
      if (data.success == true) {
        $("#cpassword").val(data.password) 
        formOk = true
        $(form).submit();
      } else {
        Swal.close()
        Swal.fire('Please, verify your credentials')
      }
  })

}

function testAWS(keyid, keysecret, form) {

    
  keyid = keyid
  keysecret = keysecret
  let timerInterval
  Swal.fire({
    title: 'Adding Cloud',
    html: 'Please wait until your credentials are verifyed and the cloud is set up',
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

  $.get(cDef + "/aws/session/login?keyid=" + keyid + '&keysecret='+encodeURIComponent(keysecret), 
    function(data) {
      console.log(data)
      if (data.success == true) {
        $("#ckeysecret").val(data.keysecret)
        formOk = true
        $(form).submit();
      } else {
        Swal.close()
        Swal.fire('Please, verify your credentials')
      }
  })

}

function swalwredirect(wurl) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      window.location.href = wurl
    }
  })
}

function simpleredirect(wurl) {

  window.location.href = wurl

}

setInterval(function(){ 
  $.get(sDef + "/site/getmessages", 
  function(data) {
    data = JSON.parse(data)
    if (data.success == true) {
      notificationshtml = ""
      if (data.notifications.length > 0) {
        $("#bellspan").show()
        notificationstext = ('You have ' + data.notifications.length)
      } else {
        $("#bellspan").hide()
        notificationstext = ('You don\'t have')
      }
      $("#belltext").html(notificationstext)
      
      data.notifications.forEach(elem => {
        notificationshtml += `<div class="dropdown-item d-flex pb-3" onclick="dispatchMessage(${elem.id})">
                              <div class="notifyimg bg-danger">
                                <i class="fa fa-cogs"></i>
                              </div>
                              <div>
                                <strong>${elem.message}</strong>
                                <!-- <div class="small">45 mintues ago</div> -->
                              </div>
                            </div>`
      })
      $("#nplace").html(notificationshtml)
    }
})
}, 10000);

setInterval(function(){ 
  $.get(sDef + "/site/getfeed", 
  function(data) {
    feedhtml = ''
    data = JSON.parse(data)
    if (data.success == true) {

      data.feed.forEach(elem => {
        
        feedhtml += `<div class="list d-flex align-items-center border-bottom p-4">
                    <div class="">
                      <span class="avatar ${elem.color} brround avatar-md">${elem.initials}</span>
                    </div>
                    <div class="wrapper w-100 ml-3">
                      <p class="mb-0 d-flex">
                        <b>${elem.feed}</b>
                      </p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                          <i class="mdi mdi-clock text-muted mr-1"></i>
                          <small class="text-muted ml-auto">${elem.time}</small>
                          <p class="mb-0"></p>
                        </div>
                      </div>
                    </div>
                  </div>
            `
        $("#tab2").html(feedhtml)
      })
    } 
})
}, 6000);

async function supportTicket() {
  const { value: formValues } = await Swal.fire({
    title: 'Submit ticket',
    html:
      '<label>Subject: </label><input id="subject" class="swal2-input">' +
      '<label>Details: </label><textarea id="details" class="swal2-input"></textarea>',
    focusConfirm: false,
    preConfirm: () => {
      return [
        document.getElementById('subject').value,
        document.getElementById('details').value
      ]
    }
  })
  
  if (formValues) {
    Swal.fire(JSON.stringify(formValues))
  }
  return false
}

function dispatchMessage(id) {
  $(this).remove()
  $.get(sDef + "/site/dispatchmessage?id=" + id, 
  function(data) {
    console.log(data)
  })
}


$(document).ready( function () {
  $('#resourcestable').DataTable({
    "oLanguage": {

      "sSearch": "Filter:"
      
      }
  });
} );