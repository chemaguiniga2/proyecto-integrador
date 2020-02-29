<div class="row">

  <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Virtual Machine Configuration</h3>
        
      </div>
      <div class="card-body">

        <?php if ($deployok) { ?>
        <h4>Deployment in progress</h4>
        <br>
        <h5>Click the button below to download the VM certificate</h5>
        <h5>We don't store any copy! - Keep it safe!</h5>
        <br>
        
        <button type="button" class="btn btn-success-light mt-1" onclick="sendcertificate('certificate.pem', `<?php echo $pkey ?>`)">Download</button>

        <?php } else { ?>
          <h4>There was a problem!</h4>
        <br>
        <h5>VM was ot deployed</h5>


        <?php } ?>
        
      </div>

      <div class="card-footer">
        
        
      </div>
    </div>

  </div>

</div>

<script>
function sendcertificate(filename,text){
    // Set up the link
    var link = document.createElement("a");
    link.setAttribute("target","_blank");
    if(Blob !== undefined) {
        var blob = new Blob([text], {type: "text/plain"});
        link.setAttribute("href", URL.createObjectURL(blob));
    } else {
        link.setAttribute("href","data:text/plain," + encodeURIComponent(text));
    }
    link.setAttribute("download",filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>