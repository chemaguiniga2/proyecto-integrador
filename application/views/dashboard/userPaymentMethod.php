<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
<link href="../assets/css/payment_form.css" rel="stylesheet" type="text/css" media="all" />
<div class="wrapper">
  <div class="payment-box">
    <div class="form">
      <div class="card space icon-relative">
        <label class="label">Card holder:</label>
        <input type="text" class="input" placeholder="OneCloud Ops">
        <i class="fas fa-user"></i>
      </div>
      <div class="card space icon-relative">
        <label class="label">Card number:</label>
        <input type="text" class="input" data-mask="0000 0000 0000 0000" placeholder="Card Number">
        <i class="far fa-credit-card"></i>
      </div>
      <div class="card-grp space">
        <div class="card icon-relative">
          <label class="label">Expiry date:</label>
          <input type="text" name="expiry-data" class="input"  placeholder="00 / 00">
          <i class="far fa-calendar-alt"></i>
        </div>
        <div class="card icon-relative">
          <label class="label">CVC:</label>
          <input type="text" class="input" data-mask="000" placeholder="000">
          <i class="fas fa-lock"></i>
        </div>
      </div>
        
      <div class="btn">
        Update
      </div> 
      
    </div>
  </div>
</div>