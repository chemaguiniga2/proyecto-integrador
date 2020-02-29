<?php
if (!$this->session->userdata('isLogIn')) {
  redirect(base_url() . 'login'); 
}
if ($this->session->userdata('securitylevel') < 2) {
  if (current_url() != (base_url() . 'security/squestions')) {
    redirect(base_url() . 'security/squestions'); 
  }
}
?>
<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="msapplication-TileColor" content="#0061da">
		<meta name="theme-color" content="#1643a3">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<link rel="icon" href="../assets/images/favicon.png" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.png"/>

		<!-- TITLE -->
		<title>The OneCloud Management Framework</title>

		<!-- DASHBOARD CSS -->
		<link href="../assets/css/dashboard.css" rel="stylesheet"/>
		<link href="../assets/css/boxed.css" rel="stylesheet"/>

		<!-- COLOR-THEMES CSS -->
		<link href="../assets/css/color-themes.css" rel="stylesheet"/>

		<!-- C3.JS CHARTS PLUGIN -->
		<link href="../assets/plugins/charts-c3/c3-chart.css" rel="stylesheet"/>

		<!-- TABS CSS -->
		<link href="../assets/plugins/tabs/tabs-style2.css" rel="stylesheet" type="text/css">

    <link href="../assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">

		<!-- CUSTOM SCROLL BAR CSS-->
		<link href="../assets/plugins/mcustomscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!--- FONT-ICONS CSS -->
		<link href="../assets/css/icons.css" rel="stylesheet"/>

		<!-- RIGHT-MENU CSS -->
		<link href="../assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!-- LEFT-SIDEMENU CSS -->
		<link href="../assets/plugins/jquery-jside-menu-master/css/jside-menu.css" rel="stylesheet"/>
		<link href="../assets/plugins/jquery-jside-menu-master/css/jside-skins.css" rel="stylesheet"/>

		<!-- Sidemenu css -->
		<link href="../assets/plugins/side-menu/sidemenu-model2.css" rel="stylesheet" />

		<!-- Sidebar Accordions css -->
		<link href="../assets/plugins/sidemenu-responsive-tabs/css/easy-responsive-tabs.css" rel="stylesheet">
    <link href="../assets/css/sweetalert2.css" rel="stylesheet">

    <link href="../assets/plugins/formwizard/smart_wizard.css" rel="stylesheet">
    <link href="../assets/plugins/form-wizard/css/form-wizard.css" rel="stylesheet">
    <link href="../assets/plugins/formwizard/smart_wizard_theme_dots.css" rel="stylesheet">
    <link href="../assets/plugins/formwizard/smart_wizard_theme_circles.css" rel="stylesheet">
    <link href="../assets/plugins/formwizard/smart_wizard_theme_arrows.css" rel="stylesheet">
    <style>
    /* Hide all steps by default: */
    .wtab {
      display: none;
    }
    </style>
	</head>
	<body class="app sidebar-mini rtl body-dark">
  

<?php
  echo '<script>';
  if ($_SERVER["HTTP_HOST"] == 'localhost') {
    
    echo 'const sDef = "http://localhost";';
    echo 'const cDef = "http://localhost:9900";';
  } else {
    echo 'const sDef = "https://omp.onecloudops.com";';
    echo 'const cDef = "https://clouds.onecloudops.com:9900";';
  }
  echo '</script>';
?>

  
		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
		</div>

		<div class="page">
			<div class="page-main">

        <!-- Sidebar menu--> 
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div> 
        <aside class="app-sidebar app-sidebar2"> 
            <a class="header-brand left-meu-header-brand" href="<?php echo base_url()?>"> 
                <img src="../assets/images/logo.png" class="header-brand-img desktop-logo" alt="OneCloud logo"> 
                <img src="../assets/images/logo.png" class="header-brand-img mobile-view-logo" alt="OneCloud logo"> 
            </a> 
          <ul class="side-menu"> 
            <li> 
                <a class="side-menu__item" href="<?php echo base_url() . '' ?>"><i class="side-menu__icon fa fa-tachometer"></i><span class="side-menu__label">Dashboard</span></a> 
            </li> 
            <li > 
              <a class="side-menu__item" href="<?php echo base_url() . 'clouds' ?>"><i class="side-menu__icon fa fa-cloud"></i><span class="side-menu__label">Clouds</span></a> 
   
            </li> 
            <li class="slide"> 
              <a class="side-menu__item" href="<?php echo base_url() . 'services' ?>"><i class="side-menu__icon fa fa-cubes"></i><span class="side-menu__label">Resource Groups</span></a> 
            </li> 
            <li class="slide"> 
              <a class="side-menu__item" href="<?php echo base_url() . 'clouds/resources' ?>"><i class="side-menu__icon fa fa-cube"></i><span class="side-menu__label">Resources</span></a> 
            </li> 
            <!--
            <li class="slide"> 
              <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Settings</span><i class="angle fa fa-angle-right"></i></a> 
              <ul class="slide-menu"> 
                <li> 
                    <a href="<?php echo base_url() . 'dashboard/profile' ?>" class="slide-item">Profile</a> 
                </li> 
                <li> 
                    <a href="<?php echo base_url() . 'security/changepassword' ?>" class="slide-item">Change Password</a> 
                </li> 
                <li> 
                    <a href="<?php echo base_url() . 'security/enable2fa' ?>" class="slide-item">2FA Authentication</a> 
                </li> 
              </ul> 
            </li> 
            -->
          </ul> 
        </aside> 
        <!--sidemenu end--> 

				<!-- app-content-->
				<div class="app-content">

					<!-- HEADER -->
					<div class="header header-fixed ">
						<div class="container-fluid">
							<div class="d-flex">
								<a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a>
								<a class="header-brand d-md-none" href="index.html">
									<img src="../assets/images/logo.png" class="header-brand-img desktop-logo" alt="Onecloud logo">
									<img src="../assets/images/logo.png" class="header-brand-img mobile-view-logo" alt="Onecloud logo">
								</a>
								<!-- LOGO -->
								
								<div class="d-flex order-lg-2 ml-auto header-right-icons header-search-icon">
                <?php 
                  
                    if ($this->session->userdata('companylogo') != "" && $_SERVER["HTTP_HOST"] != 'localhost') { ?>
                      <img src="<?php echo $this->session->userdata('companylogo') ?>" class="header-brand-img desktop-logo mCS_img_loaded" alt="logo">
                   <?php
                   
                  }
                ?>
                  
                  <div style="width: auto;"></div>
									<!-- SEARCH -->
									<div class="dropdown d-md-flex">
										
									</div><!-- FULL-SCREEN -->
									<div class="dropdown d-md-flex notifications">
										<a class="nav-link icon" data-toggle="dropdown">
											<i class="fe fe-bell"></i>
											<span id="bellspan" style="display:none;" class="nav-unread bg-warning-1 pulse"></span> 
										</a>
										<div class="dropdown-menu dropdown-menu-right  dropdown-menu-arrow">
											<div class="dropdown-item p-4 bg-image-2 text-center text-white">
												<h4 id="belltext" class="mb-1">You don't have </h4>
												<span class="text-white-transparent user-semi-title">Notifications</span>
											</div>
											<div id="nplace"></div>
																						
										</div>
									</div><!-- NOTIFICATIONS -->
							<!-- MESSAGE-BOX -->
									<div class="dropdown text-center selector profile-1">
										<a href="#" data-toggle="dropdown" class="nav-link leading-none d-flex">
											<span><img src="../assets/images/faces/female/16.jpg" alt="profile-user" class="avatar avatar-sm brround cover-image mb-1 ml-0"></span>
											<span class=" ml-3 d-none d-lg-block ">
												<span class="text-white "><?php echo $this->session->userdata('name') ?></span>
											</span>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
											<div class="text-center bg-image p-4 text-white">
												<a href="#" class="dropdown-item text-white text-center font-weight-sembold user" data-toggle="dropdown"><?php echo $this->session->userdata('name') ?></a>
											</div>
											<a class="dropdown-item" href="<?php echo base_url() . 'dashboard/profile' ?>">
												<i class="dropdown-icon mdi mdi-account-outline"></i> Profile
											</a>
											<a class="dropdown-item" href="<?php echo base_url() . 'security/changepassword' ?>">
												<i class="dropdown-icon  mdi mdi-settings"></i> Security
											</a>
                      <!-- <a class="dropdown-item" href="<?php echo base_url() . 'security/enable2fa' ?>">
												<i class="dropdown-icon  mdi mdi-settings"></i> 2FA Authentication
											</a> -->

											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="#" onclick="return supportTicket()">
												<i class="dropdown-icon mdi mdi-compass-outline"></i> Support ticket
											</a>
											<a class="dropdown-item" href="<?php echo base_url() . 'site/logout' ?>">
												<i class="dropdown-icon mdi  mdi-logout-variant"></i> Logout
											</a>
										</div>
									</div><!-- PROFILE -->
									<div class="dropdown d-md-flex header-settings">
										<a href="#" class="nav-link icon " data-toggle="sidebar-right" data-target=".sidebar-right">
											<i class="fe fe-menu"></i>
										</a>
									</div>

									</div><!-- SIDE-MENU -->
								</div>
								<a href="#" class="header-toggler d-lg-none ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
									<span class="header-toggler-icon"></span>
								</a>
							</div>
						</div>
			
					<!-- HEADER END -->
					<div class="side-app">
						<!-- PAGE-HEADER -->
						<div class="page-header">
							<h4 class="page-title"><?php echo $ptitle ?></h4>
						</div>
						<!-- PAGE-HEADER END -->
            <?php echo $content ?>

					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>

			<!-- RIGHT-SIDEBAR OPEN -->
      <div class="sidebar sidebar-right sidebar-animate">
			    <div class=" close-button float-right">
					<a href="#" data-toggle="sidebar-right" data-target=".sidebar-right"><i class="fe fe-x  text-white"></i></a>
				</div>
				<div class="tab-menu-heading siderbar-tabs border-0 ">

				</div>
				<div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
					<div class="tab-content border-top">
						<div class="tab-pane active show" id="tab2">

						</div><!-- TAB-2 END -->

					</div>
				</div>
			</div>
			<!-- RIGHT-SIDEBAR CLOSED -->

			<!-- FOOTER -->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-md-12 col-sm-12 text-center">
							Copyright © 2020 OneCloud, LLC. All rights reserved
						</div>
					</div>
				</div>
			</footer>
			<!-- FOOTER CLOSED -->
		</div>

		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

		<!-- JQUERY SCRIPTS -->
		<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>

		<!-- BOOTSTRAP SCRIPTS -->
		<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>

		<!-- SPARKLINE -->
		<script src="../assets/js/vendors/jquery.sparkline.min.js"></script>

		<!-- CHART-CIRCLE -->
		<script src="../assets/js/vendors/circle-progress.min.js"></script>

		<!-- RATING STAR -->
		<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>

		<!-- INPUT MASK PLUGIN-->
		<script src="../assets/plugins/input-mask/jquery.mask.min.js"></script>

		<!-- CHARTJS CHART -->
		<script src="../assets/plugins/chart/Chart.bundle.js"></script>
		<script src="../assets/plugins/chart/utils.js"></script>

		<!-- PIETYCHART -->
		<script src="../assets/plugins/peitychart/jquery.peity.min.js"></script>
		<script src="../assets/plugins/peitychart/peitychart.init.js"></script>

		<!-- CUSTOM SCROLL BAR JS-->
		<script src="../assets/plugins/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

    <script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatable/datatable.js"></script>

		<!-- CHARTS PLUGIN -->
		<script src="../assets/plugins/highcharts/highcharts.js"></script>

		<!-- RIGHT-MENU JS -->
		<script src="../assets/plugins/sidebar/sidebar.js"></script>

		<!-- LEFT-SIDEMENU PLUGIN -->
		<script src="../assets/plugins/jquery-jside-menu-master/js/jquery.jside.menu.js"></script>

		<!--Side-menu js-->
		<script src="../assets/plugins/side-menu/sidemenu-fullwidth.js"></script>
    <script src="../assets/js/sweetalert2.all.js"></script>

    <script src="../assets/js/d3.v5.min.js"></script>
    
		<!-- CUSTOM JS-->
		
    <script src="../assets/js/omp.js"></script>

    <!-- form wizzard -->
    <script src="../assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js"></script>
    <script src="../assets/plugins/formwizard/jquery.smartWizard.js"></script>
    <script src="../assets/plugins/formwizard/fromwizard.js"></script>
    <script src="../assets/js/advancedform.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/dashboardcharts.js"></script>
    <?php if (isset($additionaljs)) {echo $additionaljs;} ?>

	</body>
</html>