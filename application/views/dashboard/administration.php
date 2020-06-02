<link href="../assets/css/dashboard.css" rel="stylesheet" />
<link href="../assets/css/icons.css" rel="stylesheet" />
<link href="../assets/css/billingRegistration.css" rel="stylesheet" type="text/css" media="all" />
<link href="https://fonts.googleapis.com/css?family=Monda" rel="stylesheet">

<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/confirmationpopup.js" type="text/javascript"></script>
<script src="https://js.stripe.com/v3/"></script>

<div class="row">

    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add new plan.</h3>
            </div>
            <div class="card-body">

                <div class="price-grid">
					<div class="price-block agile">
						<div class="price-gd-top">
							<h4><script>
setInterval(function() { ObserveInputValue($('#fname').val()); }, 100);
</script></h4>
							<h3>$/ month </h3>
							<h5>$/ year</h5>
						</div>
						<div class="price-gd-bottom">
							<div class="price-list">
							</div>
						</div>
						<div class="price-selet">


						</div>
					</div>
        </div> 
        
        <form method="post" action='addPlan' >
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="planName">Plan Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Test Plan 1">
                        </div>

                    </div>

                </div>
                
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="monthly">Monthly Price</label>
                            <input input type="number" min="0.00" max="10000.00" step="0.01" class="form-control" id="monthly-price" name="monthly-price" placeholder="15">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="monthlyprice">Annual Price</label>
                            <input input type="number" min="0.00" max="10000.00" step="0.01" class="form-control" id="annual-price" name="annual-price" placeholder="150">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Allowed Users</label>
                            <input type="number" class="form-control" id="users" name="users" placeholder="10">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Allowed Clouds</label>
                            <input type="number" class="form-control" id="clouds" name="clouds" placeholder="5">
                        </div>
                    </div>

                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-success-light mt-1">Save</button>

                </div>
            </div>

        </div>
        </form>
        <div class="price-selet pric-sclr1">
					<a class="popup-with-zoom-anim"
					href="<?php echo base_url() . 'billing/pdfReportListUsers'?>">List Users</a>

					<a class="popup-with-zoom-anim"
					href="<?php echo base_url() . 'billing/pdfReportListUsersInTrial'?>">List Users In Trial</a>

					<a class="popup-with-zoom-anim"
					href="<?php echo base_url() . 'billing/pdfReportListUsersInPlan'?>">List Users In Plan</a>

					<a class="popup-with-zoom-anim"
					href="<?php echo base_url() . 'billing/pdfReportListIdleUsers'?>">List Idle Users</a>

					<a class="popup-with-zoom-anim"
					href="<?php echo base_url() . 'billing/pdfReportProfitPerPlan'?>">Profit Per Plan</a>

					<a class="popup-with-zoom-anim"
					href="<?php echo base_url() . 'billing/pdfReportMonthlyBilling'?>">Monthly Billing</a>
					
                </div>
                
                
    </div>

    