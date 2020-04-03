(function($) {
	"use strict";
	// ______________Full screen

	
	// ______________Active Class
	$(document).ready(function() {
		$(".slide-menu li a").each(function() {
			var pageUrl = window.location.href.split(/[?#]/)[0];
			if (this.href == pageUrl) {
				$(this).addClass("active");
				$(this).parent().addClass("active"); // add active to li of the current link
				$(this).parent().parent().prev().addClass("active"); // add active class to an anchor
				$(this).parent().parent().prev().click(); // click the item to make it drop
			}
		});
	});
	
	// ______________ GLOBAL SEARCH

	var toggleSidebar = function() {
		var w = $(window);
		if(w.outerWidth() <= 1024) {
			$("body").addClass("sidebar-gone");
			$(document).off("click", "body").on("click", "body", function(e) {
				if($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {
					$("body").removeClass("sidebar-show");
					$("body").addClass("sidebar-gone");
					$("body").removeClass("search-show");
				}
			});
		}else{
			$("body").removeClass("sidebar-gone");
		}
	}
	toggleSidebar();
	$(window).resize(toggleSidebar);
	
	// ______________MCUSTOMSCROLLBAR
	$(".menu-container").mCustomScrollbar({
		theme:"minimal",
		autoHideScrollbar: true,
		scrollbarPosition: "outside"
	});
	$(".vscroll").mCustomScrollbar();
	$(".app-sidebar2").mCustomScrollbar({
		theme:"minimal",
		autoHideScrollbar: true
	});
	// ______________ PAGE LOADING
	$(window).on("load", function(e) {
		$("#global-loader").fadeOut("slow");
	})
	
	// ______________ BACK TO TOP BUTTON
	$(window).on("scroll", function(e) {
		if ($(this).scrollTop() > 0) {
			$('#back-to-top').fadeIn('slow');
		} else {
			$('#back-to-top').fadeOut('slow');
		}
	});
	$("#back-to-top").on("click", function(e) {
		$("html, body").animate({
			scrollTop: 0
		}, 600);
		return false;
	});
	
	// ______________ COVER IMAGE
	$(".cover-image").each(function() {
		var attr = $(this).attr('data-image-src');
		if (typeof attr !== typeof undefined && attr !== false) {
			$(this).css('background', 'url(' + attr + ') center center');
		}
	});
	
	// ______________ RATING STAR
	var ratingOptions = {
		selectors: {
			starsSelector: '.rating-stars',
			starSelector: '.rating-star',
			starActiveClass: 'is--active',
			starHoverClass: 'is--hover',
			starNoHoverClass: 'is--no-hover',
			targetFormElementSelector: '.rating-value'
		}
	};
	$(".rating-stars").ratingStars(ratingOptions);
	
	// ______________ CHART-CIRCLE
	if ($('.chart-circle').length) {
		$('.chart-circle').each(function() {
			let $this = $(this);
			$this.circleProgress({
				fill: {
					color: $this.attr('data-color')
				},
				size: $this.height(),
				startAngle: -Math.PI / 4 * 2,
				emptyFill: 'rgba(255,255,255,0.2)',
				lineCap: 'round'
			});
		});
	}

	// ______________ LEFT SIDE MENU
	$(document).ready(function(){
	$(".menu-container").jSideMenu({
		jSidePosition: "position-left", //possible options position-left or position-right
	 
		jSideSticky: true, // menubar will be fixed on top, false to set static

		jSideSkin: "default-skin", // to apply custom skin, just put its name in this string
		 });
	}); 
		
		
	// ______________ HEADER-STICKY
	$(document).ready(function(){ 
		$(window).on("scroll", function(){ 
			if ($(this).scrollTop() >= 10) { 
				$('.jside-menu .header').addClass('header-color'); 
			} else { 
				$('.jside-menu .header').removeClass('header-color'); 
			} 
		});

	});
		
		
    // ______________ COLORS
	
	/*////////////////////  FLAT COLORS  //////////////////////*/
	
	// $('body').addClass("color1"); // 
	
	// $('body').addClass("color2"); //
	
	// $('body').addClass("color3"); //
	
	// $('body').addClass("color4"); //
	
	// $('body').addClass("color5"); //
	
	// $('body').addClass("color6"); //
	
	// $('body').addClass("color7"); //
	
	// $('body').addClass("color8"); //
	
	// $('body').addClass("color9"); //
	
	// $('body').addClass("color10"); //
	
	
	/*////////////////////  GRADIENT COLORS  //////////////////////*/
	
	
	$('body').addClass("color11");
	
	// $('body').addClass("color12"); //
	
	// $('body').addClass("color13"); //
	
	// $('body').addClass("color14"); //
	
	// $('body').addClass("color15"); //
	
	// $('body').addClass("color16"); //
	
	// $('body').addClass("color17"); //
	
	// $('body').addClass("color18"); //
	
	// $('body').addClass("color19"); //
	
	// $('body').addClass("color20"); //
	
	
	/*////////////////////  BACKGROUND IMAGES  //////////////////////*/
	
	
	//  $('body').addClass("image1"); // 
	
	// $('body').addClass("image2"); //
	
	// $('body').addClass("image3"); //
	
	// $('body').addClass("image4"); //
	
	// $('body').addClass("image5"); //
	
	// $('body').addClass("image6"); //
	
	// $('body').addClass("image7"); //
	
	// $('body').addClass("image8"); //
	
	// $('body').addClass("image9"); //
	
	// $('body').addClass("image10"); //
	
	
	/* ////////////////////  FULL-WIDTH  ////////////////////// */
	
	// $('body').addClass("full-width"); //
	
	
	/*////////////////////  CARD-COLOR  //////////////////////*/
	
	// $('body').addClass("light-color"); //
	
	

	/** Constant div card */
	const DIV_CARD = 'div.card';
	/** Initialize tooltips */
	$('[data-toggle="tooltip"]').tooltip();
	/** Initialize popovers */
	$('[data-toggle="popover"]').popover({
		html: true
	});
	
	// ______________ FUNCTION FOR REMOVE CARD
	$('[data-toggle="card-remove"]').on('click', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.remove();
		e.preventDefault();
		return false;
	});
	
	// ______________ FUNCTIONS FOR COLLAPSED CARD
	$('[data-toggle="card-collapse"]').on('click', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-collapsed');
		e.preventDefault();
		return false;
	});
	
	// ______________ CARD FULL SCREEN
	$('[data-toggle="card-fullscreen"]').on('click', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-fullscreen').removeClass('card-collapsed');
		e.preventDefault();
		return false;
	});
	
})(jQuery);
