/**
 * SMOF js
 *
 * contains the core functionalities to be used
 * inside SMOF
 */

jQuery.noConflict();

/** Fire up jQuery - let's dance!
 */
jQuery(document).ready(function($){

	//(un)fold options in a checkbox-group
	jQuery('.fld').click(function() {
		var $fold='.f_'+this.id;
		$($fold).slideToggle('normal', "swing");
	});

	//delays until AjaxUpload is finished loading
	//fixes bug in Safari and Mac Chrome
	if (typeof AjaxUpload != 'function') {
		return ++counter < 6 && window.setTimeout(init, counter * 500);
	}

	//hides warning if js is enabled
	$('#js-warning').hide();

	//Tabify Options
	$('.group').hide();

	// Display last current tab
	if ($.cookie("of_current_opt") === null) {
		$('.group:first').fadeIn('fast');
		$('#of-nav li:first').addClass('current');
	} else {

		var hooks = $('#hooks').html();
		hooks = jQuery.parseJSON(hooks);

		$.each(hooks, function(key, value) {

			if ($.cookie("of_current_opt") == '#of-option-'+ value) {
				$('.group#of-option-' + value).fadeIn();
				$('#of-nav li.' + value).addClass('current');
			}

		});

	}

	//Current Menu Class
	$('#of-nav li a').click(function(evt){
		// event.preventDefault();

		$('#of-nav li').removeClass('current');
		$(this).parent().addClass('current');

		var clicked_group = $(this).attr('href');

		$.cookie('of_current_opt', clicked_group, { expires: 7, path: '/' });

		$('.group').hide();

		$(clicked_group).fadeIn('fast');
		return false;

	});

	//Expand Options
	var flip = 0;

	$('#expand_options').click(function(){
		if(flip == 0){
			flip = 1;
			$('#of_container #of-nav').hide();
			$('#of_container #content').width(760);
			$('#of_container .group').add('#of_container .group h2').show();

			$(this).removeClass('expand');
			$(this).addClass('close');
			$(this).text('Close');

		} else {
			flip = 0;
			$('#of_container #of-nav').show();
			$('#of_container #content').width(600);
			$('#of_container .group').add('#of_container .group h2').hide();
			$('#of_container .group:first').show();
			$('#of_container #of-nav li').removeClass('current');
			$('#of_container #of-nav li:first').addClass('current');

			$(this).removeClass('close');
			$(this).addClass('expand');
			$(this).text('Expand');

		}

	});

	//Update Message popup
	$.fn.center = function () {
		this.animate({"top":( $(window).height() - this.height() - 200 ) / 2+$(window).scrollTop() + "px"},100);
		this.css("left", 250 );
		return this;
	}


	$('#of-popup-save').center();
	$('#of-popup-reset').center();
	$('#of-popup-fail').center();

	$(window).scroll(function() {
		$('#of-popup-save').center();
		$('#of-popup-reset').center();
		$('#of-popup-fail').center();
	});


	//Masked Inputs (images as radio buttons)
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});
	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();

	//Masked Inputs (background images as radio buttons)
	$('.of-radio-tile-img').click(function(){
		$(this).parent().parent().find('.of-radio-tile-img').removeClass('of-radio-tile-selected');
		$(this).addClass('of-radio-tile-selected');
	});
	$('.of-radio-tile-label').hide();
	$('.of-radio-tile-img').show();
	$('.of-radio-tile-radio').hide();

	//AJAX Upload
	function of_image_upload() {
		$('.image_upload_button').each(function(){

			var clickedObject = $(this);
			var clickedID = $(this).attr('id');

			var nonce = $('#security').val();

			new AjaxUpload(clickedID, {
				action: ajaxurl,
				name: clickedID, // File upload name
				data: { // Additional data to send
					action: 'of_ajax_post_action',
					type: 'upload',
					security: nonce,
					data: clickedID },
				autoSubmit: true, // Submit file after selection
				responseType: false,
				onChange: function(file, extension){},
				onSubmit: function(file, extension){
					clickedObject.text('Uploading'); // change button text, when user selects file
					this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
					interval = window.setInterval(function(){
						var text = clickedObject.text();
						if (text.length < 13){	clickedObject.text(text + '.'); }
						else { clickedObject.text('Uploading'); }
					}, 200);
				},
				onComplete: function(file, response) {
					window.clearInterval(interval);
					clickedObject.text('Upload Image');
					this.enable(); // enable upload button


					// If nonce fails
					if(response==-1){
						var fail_popup = $('#of-popup-fail');
						fail_popup.fadeIn();
						window.setTimeout(function(){
							fail_popup.fadeOut();
						}, 2000);
					}

					// If there was an error
					else if(response.search('Upload Error') > -1){
						var buildReturn = '<span class="upload-error">' + response + '</span>';
						$(".upload-error").remove();
						clickedObject.parent().after(buildReturn);

					}
					else{
						var buildReturn = '<img class="hide of-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';

						$(".upload-error").remove();
						$("#image_" + clickedID).remove();
						clickedObject.parent().after(buildReturn);
						$('img#image_'+clickedID).fadeIn();
						clickedObject.next('span').fadeIn();
						clickedObject.parent().prev('input').val(response);
					}
				}
			});

		});

	}

	of_image_upload();

	//AJAX Remove Image (clear option value)
	$('.image_reset_button').live('click', function(){

		var clickedObject = $(this);
		var clickedID = $(this).attr('id');
		var theID = $(this).attr('title');

		var nonce = $('#security').val();

		var data = {
			action: 'of_ajax_post_action',
			type: 'image_reset',
			security: nonce,
			data: theID
		};

		$.post(ajaxurl, data, function(response) {

			//check nonce
			if(response==-1){ //failed

				var fail_popup = $('#of-popup-fail');
				fail_popup.fadeIn();
				window.setTimeout(function(){
					fail_popup.fadeOut();
				}, 2000);
			}

			else {

				var image_to_remove = $('#image_' + theID);
				var button_to_hide = $('#reset_' + theID);
				image_to_remove.fadeOut(500,function(){ $(this).remove(); });
				button_to_hide.fadeOut();
				clickedObject.parent().prev('input').val('');
			}


		});

	});

	// Style Select
	(function ($) {
		styleSelect = {
			init: function () {
				$('.select_wrapper').each(function () {
					$(this).prepend('<span>' + $(this).find('.select option:selected').text() + '</span>');
				});
				$('.select').live('change', function () {
					$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
				});
				$('.select').bind($.browser.msie ? 'click' : 'change', function(event) {
					$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
				});
			}
		};
		$(document).ready(function () {
			styleSelect.init()
		})
	})(jQuery);


	/** Aquagraphite Slider MOD */

	//Hide (Collapse) the toggle containers on load
	$(".slide_body").hide();

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$(".slide_edit_button").live( 'click', function(){
		$(this).parent().toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
	});

	// Update slide title upon typing
	function update_slider_title(e) {
		var element = e;
		if ( this.timer ) {
			clearTimeout( element.timer );
		}
		this.timer = setTimeout( function() {
			$(element).parent().prev().find('strong').text( element.value );
		}, 100);
		return true;
	}

	$('.of-slider-title').live('keyup', function(){
		update_slider_title(this);
	});


	//Remove individual slide
	$('.slide_delete_button').live('click', function(){
		// event.preventDefault();
		var agree = confirm("Are you sure you wish to delete this slide?");
		if (agree) {
			var $trash = $(this).parents('li');
			//$trash.slideUp('slow', function(){ $trash.remove(); }); //chrome + confirm bug made slideUp not working...
			$trash.animate({
				opacity: 0.25,
				height: 0,
			}, 500, function() {
				$(this).remove();
			});
			return false; //Prevent the browser jump to the link anchor
		} else {
			return false;
		}
	});

	//Add new slide
	$(".slide_add_button").live('click', function(){
		var slidesContainer = $(this).prev();
		var sliderId = slidesContainer.attr('id');
		var sliderInt = $('#'+sliderId).attr('rel');

		var numArr = $('#'+sliderId +' li').find('.order').map(function() {
			var str = this.id;
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;
		}).get();

		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;

		var newSlide = '<li class="temphide"><div class="slide_header"><strong>Slide ' + newNum + '</strong><input type="hidden" class="slide of-input order" name="' + sliderId + '[' + newNum + '][order]" id="' + sliderId + '_slide_order-' + newNum + '" value="' + newNum + '"><a class="slide_edit_button" href="#">Edit</a></div><div class="slide_body" style="display: none; "><label>Title</label><input class="slide of-input of-slider-title" name="' + sliderId + '[' + newNum + '][title]" id="' + sliderId + '_' + newNum + '_slide_title" value=""><label>Image URL</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][url]" id="' + sliderId + '_' + newNum + '_slide_url" value=""><div class="upload_button_div"><span class="button media_upload_button" id="' + sliderId + '_' + newNum + '" rel="'+sliderInt+'">Upload</span><span class="button mlu_remove_button hide" id="reset_' + sliderId + '_' + newNum + '" title="' + sliderId + '_' + newNum + '">Remove</span></div><div class="screenshot"></div><label>Link URL (optional)</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][link]" id="' + sliderId + '_' + newNum + '_slide_link" value=""><label>Description (optional)</label><textarea class="slide of-input" name="' + sliderId + '[' + newNum + '][description]" id="' + sliderId + '_' + newNum + '_slide_description" cols="8" rows="8"></textarea><a class="slide_delete_button" href="#">Delete</a><div class="clear"></div></div></li>';

		slidesContainer.append(newSlide);
		$('.temphide').fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});

		of_image_upload(); // re-initialise upload image..

		return false; //prevent jumps, as always..
	});

	//Sort slides
	jQuery('.slider').find('ul').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).sortable({
			placeholder: "placeholder",
			opacity: 0.6
		});
	});


	/**	Sorter (Layout Manager) */
	jQuery('.sorter').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).find('ul').sortable({
			items: 'li',
			placeholder: "placeholder",
			connectWith: '.sortlist_' + id,
			opacity: 0.6,
			update: function() {
				$(this).find('.position').each( function() {

					var listID = $(this).parent().attr('id');
					var parentID = $(this).parent().parent().attr('id');
					parentID = parentID.replace(id + '_', '')
					var optionID = $(this).parent().parent().parent().attr('id');
					$(this).prop("name", optionID + '[' + parentID + '][' + listID + ']');

				});
			}
		});
	});


	/**	Ajax Backup & Restore MOD */
	//backup button
	$('#of_backup_button').live('click', function(){

		var answer = confirm("Click OK to backup your current saved options.")

		if (answer){

			var clickedObject = $(this);
			var clickedID = $(this).attr('id');

			var nonce = $('#security').val();

			var data = {
				action: 'of_ajax_post_action',
				type: 'backup_options',
				security: nonce
			};

			$.post(ajaxurl, data, function(response) {

				//check nonce
				if(response==-1){ //failed

					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();
					}, 2000);
				}

				else {

					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}

			});

		}

		return false;

	});

	//restore button
	$('#of_restore_button').live('click', function(){

		var answer = confirm("'Warning: All of your current options will be replaced with the data from your last backup! Proceed?")

		if (answer){

			var clickedObject = $(this);
			var clickedID = $(this).attr('id');

			var nonce = $('#security').val();

			var data = {
				action: 'of_ajax_post_action',
				type: 'restore_options',
				security: nonce
			};

			$.post(ajaxurl, data, function(response) {

				//check nonce
				if(response==-1){ //failed

					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();
					}, 2000);
				}

				else {

					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}

			});

		}

		return false;

	});

	/**	Ajax Transfer (Import/Export) Option */
	$('#of_import_button').live('click', function(){

		var answer = confirm("Click OK to import options.")

		if (answer){

			var clickedObject = $(this);
			var clickedID = $(this).attr('id');

			var nonce = $('#security').val();

			var import_data = $('#export_data').val();

			var data = {
				action: 'of_ajax_post_action',
				type: 'import_options',
				security: nonce,
				data: import_data
			};

			$.post(ajaxurl, data, function(response) {
				var fail_popup = $('#of-popup-fail');
				var success_popup = $('#of-popup-save');

				//check nonce
				if(response==-1){ //failed
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();
					}, 2000);
				}
				else
				{
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}

			});

		}

		return false;

	});

	/** AJAX Save Options */
	$('#of_save').live('click',function() {

		var nonce = $('#security').val();

		$('.ajax-loading-img').fadeIn();

		//get serialized data from all our option fields
		var serializedReturn = $('#of_form :input[name][name!="security"][name!="of_reset"]').serialize();

		var data = {
			type: 'save',
			action: 'of_ajax_post_action',
			security: nonce,
			data: serializedReturn
		};

		$.post(ajaxurl, data, function(response) {
			var success = $('#of-popup-save');
			var fail = $('#of-popup-fail');
			var loading = $('.ajax-loading-img');
			loading.fadeOut();

			if (response==1) {
				success.fadeIn();
			} else {
				fail.fadeIn();
			}

			window.setTimeout(function(){
				success.fadeOut();
				fail.fadeOut();
			}, 2000);
		});

		return false;

	});


	/* AJAX Options Reset */
	$('#of_reset').click(function() {

		//confirm reset
		var answer = confirm("Click OK to reset. All settings will be lost and replaced with default settings!");

		//ajax reset
		if (answer){

			var nonce = $('#security').val();

			$('.ajax-reset-loading-img').fadeIn();

			var data = {

				type: 'reset',
				action: 'of_ajax_post_action',
				security: nonce,
			};

			$.post(ajaxurl, data, function(response) {
				var success = $('#of-popup-reset');
				var fail = $('#of-popup-fail');
				var loading = $('.ajax-reset-loading-img');
				loading.fadeOut();

				if (response==1)
				{
					success.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
				else
				{
					fail.fadeIn();
					window.setTimeout(function(){
						fail.fadeOut();
					}, 2000);
				}


			});

		}

		return false;

	});


	/**	Tipsy @since v1.3 */
	if (jQuery().tipsy) {
		$('.typography-size, .typography-height, .typography-face, .typography-style, .of-typography-color').tipsy({
			fade: true,
			gravity: 's',
			opacity: 0.7,
		});
	}


	/**
	 * JQuery UI Slider function
	 * Dependencies 	 : jquery, jquery-ui-slider
	 * Feature added by : Smartik - http://smartik.ws/
	 * Date 			 : 03.17.2013
	 */
	jQuery('.smof_sliderui').each(function() {

		var obj   = jQuery(this);
		var sId   = "#" + obj.data('id');
		var val   = parseInt(obj.data('val'));
		var min   = parseInt(obj.data('min'));
		var max   = parseInt(obj.data('max'));
		var step  = parseInt(obj.data('step'));

		//slider init
		obj.slider({
			value: val,
			min: min,
			max: max,
			step: step,
			slide: function( event, ui ) {
				jQuery(sId).val( ui.value );
			}
		});

	});


	/**
	 * Switch
	 * Dependencies 	 : jquery
	 * Feature added by : Smartik - http://smartik.ws/
	 * Date 			 : 03.17.2013
	 */
	jQuery(".cb-enable").click(function(){
		var parent = $(this).parents('.switch-options');
		jQuery('.cb-disable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.main_checkbox',parent).attr('checked', true);

		//fold/unfold related options
		var obj = jQuery(this);
		var $fold='.f_'+obj.data('id');
		jQuery($fold).slideDown('normal', "swing");
	});
	jQuery(".cb-disable").click(function(){
		var parent = $(this).parents('.switch-options');
		jQuery('.cb-enable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.main_checkbox',parent).attr('checked', false);

		//fold/unfold related options
		var obj = jQuery(this);
		var $fold='.f_'+obj.data('id');
		jQuery($fold).slideUp('normal', "swing");
	});
	//disable text select(for modern chrome, safari and firefox is done via CSS)
	if (($.browser.msie && $.browser.version < 10) || $.browser.opera) {
		$('.cb-enable span, .cb-disable span').find().attr('unselectable', 'on');
	}


	/**
	 * Google Fonts
	 * Dependencies 	 : google.com, jquery
	 * Feature added by : Smartik - http://smartik.ws/
	 * Date 			 : 03.17.2013
	 */
	function GoogleFontSelect( slctr, mainID ){

		//get current value - selected and saved
		var _selected = $(slctr).val(),
			_linkclass = 'style_link_'+ mainID,
			_previewer = mainID +'_ggf_previewer',
			// Font-stylings that should be visible only at custom font
			_suboptions = mainID +'_suboptions';

		//remove other elements crested in <head>
		$( '.'+ _linkclass ).remove();

		if( _selected ){ //if var exists and isset

			//Check if selected is not equal with "Select a font" and execute the script.
			if ( _selected === 'none' || _selected === 'Font not specifined' ) {

				//if selected is not a font remove style "font-family" at preview box
				$('.'+ _previewer ).css('font-family', '' );

				$('.'+ _suboptions ).slideUp();

			}
			// Selected web safe font combination
			else if(_selected.indexOf(',') != -1){

				//show in the preview box the font
				$('.'+ _previewer ).css('font-family', _selected);

				$('.'+ _suboptions ).slideUp();
			}
			// Selected a custom (Google font)
			else{

				//replace spaces with "+" sign
				var the_font = _selected.replace(/\s+/g, '+');

				//add reference to google font family
				$('head').append('<link href="http://fonts.googleapis.com/css?family='+ the_font +'" rel="stylesheet" type="text/css" class="'+ _linkclass +'">');

				//show in the preview box the font
				$('.'+ _previewer ).css('font-family', _selected +', sans-serif' );

				$('.'+ _suboptions ).slideDown();

			}

		}

	}

	//init for each element
	jQuery( '.google_font_select' ).each(function(){
		var $this = jQuery(this),
			mainID = $this.attr('id'),
			value = $this.val();
		GoogleFontSelect( this, mainID );

		// Wrapping all the custom options inside the separate div
		var parentSection = $this.parents('.section'),
			subOptionsContainer = jQuery('<div class="suboptions-container '+mainID+'_suboptions"></div>').insertAfter(parentSection),
			subOptionsPattern = mainID.replace(/family$/, ''),
			curElement = subOptionsContainer.next();
		while (curElement.attr('id').indexOf(subOptionsPattern) != -1){
			curElement.appendTo(subOptionsContainer);
			curElement = subOptionsContainer.next();
		}
		subOptionsContainer[(value == 'none' || value == 'Font not specified' || value.indexOf(',') != -1)?'hide':'show']();
	});

	//init when value is changed
	jQuery( '.google_font_select' ).on('change keyup', function(){
		var mainID = jQuery(this).attr('id');
		GoogleFontSelect( this, mainID );
	});



}); //end doc ready

jQuery(document).ready(function($) {
	var colors = {
		color_0: {
			body_bg: '#eee',
			header_bg: '#fff',
			header_text: '#666',
			header_text_hover: '#d13a7a',
			search_bg: '#d13a7a',
			search_text: '#fff',
			header_ext_bg: '#f5f5f5',
			header_ext_text: '#999',
			header_ext_text_hover: '#d13a7a',
			menu_hover_bg: '#fff',
			menu_hover_text: '#d13a7a',
			menu_active_bg: '#fff',
			menu_active_text: '#d13a7a',
			menu_button_bg: '#d13a7a',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#6254a8',
			menu_button_hover_text: '#fff',
			drop_bg: '#fff',
			drop_text: '#666',
			drop_hover_bg: '#d13a7a',
			drop_hover_text: '#fff',
			drop_active_bg: '#fff',
			drop_active_text: '#d13a7a',
			main_bg: '#fff',
			main_bg_alternative: '#f2f2f2',
			main_border: '#e8e8e8',
			main_heading: '#444',
			main_text: '#666',
			main_primary: '#d13a7a',
			main_secondary: '#6254a8',
			main_fade: '#999',
			alt_bg: '#f2f2f2',
			alt_bg_alternative: '#fff',
			alt_border: '#ddd',
			alt_heading: '#333',
			alt_text: '#555',
			alt_primary: '#d13a7a',
			alt_secondary: '#6254a8',
			alt_fade: '#999',
			subfooter_bg: '#1a1a1a',
			subfooter_border: '#222',
			subfooter_text: '#808080',
			subfooter_heading: '#ccc',
			subfooter_link: '#ccc',
			subfooter_link_hover: '#fff',
			footer_bg: '#222',
			footer_text: '#666',
			footer_link: '#999',
			footer_link_hover: '#fff'
		},
		color_1: {
			body_bg: '#222',
			header_bg: '#444',
			header_text: '#ccc',
			header_text_hover: '#1abc9c',
			search_bg: '#1abc9c',
			search_text: '#fff',
			header_ext_bg: '#393939',
			header_ext_text: '#ccc',
			header_ext_text_hover: '#1abc9c',
			menu_hover_bg: '#444',
			menu_hover_text: '#1abc9c',
			menu_active_bg: '#444',
			menu_active_text: '#1abc9c',
			menu_button_bg: '#1abc9c',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#fab908',
			menu_button_hover_text: '#fff',
			drop_bg: '#444',
			drop_text: '#ccc',
			drop_hover_bg: '#1abc9c',
			drop_hover_text: '#fff',
			drop_active_bg: '#444',
			drop_active_text: '#1abc9c',
			main_bg: '#444',
			main_bg_alternative: '#393939',
			main_border: '#595959',
			main_heading: '#fff',
			main_text: '#ccc',
			main_primary: '#1abc9c',
			main_secondary: '#fab908',
			main_fade: '#888',
			alt_bg: '#393939',
			alt_bg_alternative: '#444',
			alt_border: '#444',
			alt_heading: '#fff',
			alt_text: '#ccc',
			alt_primary: '#1abc9c',
			alt_secondary: '#fab908',
			alt_fade: '#888',
			subfooter_bg: '#303030',
			subfooter_border: '#444',
			subfooter_text: '#808080',
			subfooter_heading: '#ccc',
			subfooter_link: '#ccc',
			subfooter_link_hover: '#fab908',
			footer_bg: '#222',
			footer_text: '#666',
			footer_link: '#aaa',
			footer_link_hover: '#fab908'
		},
		color_2: {
			body_bg: '#342845',
			header_bg: '#523f6d',
			header_text: '#fff',
			header_text_hover: '#a3b745',
			search_bg: '#523f6d',
			search_text: '#fff',
			header_ext_bg: '#413256',
			header_ext_text: '#bfb9c8',
			header_ext_text_hover: '#a3b745',
			menu_hover_bg: '#523f6d',
			menu_hover_text: '#a3b745',
			menu_active_bg: '#523f6d',
			menu_active_text: '#a3b745',
			menu_button_bg: '#a3b745',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#fff',
			menu_button_hover_text: '#a3b745',
			drop_bg: '#523f6d',
			drop_text: '#fff',
			drop_hover_bg: '#a3b745',
			drop_hover_text: '#fff',
			drop_active_bg: '#523f6d',
			drop_active_text: '#a3b745',
			main_bg: '#f1f0f2',
			main_bg_alternative: '#fff',
			main_border: '#e2e1e5',
			main_heading: '#403949',
			main_text: '#403949',
			main_primary: '#a3b745',
			main_secondary: '#d46f15',
			main_fade: '#979699',
			alt_bg: '#e2e1e5',
			alt_bg_alternative: '#fff',
			alt_border: '#d3d2d6',
			alt_heading: '#403949',
			alt_text: '#403949',
			alt_primary: '#a3b745',
			alt_secondary: '#d46f15',
			alt_fade: '#979699',
			subfooter_bg: '#523f6d',
			subfooter_border: '#63517d',
			subfooter_text: '#a598b7',
			subfooter_heading: '#dedae3',
			subfooter_link: '#dedae3',
			subfooter_link_hover: '#fff',
			footer_bg: '#413256',
			footer_text: '#a598b7',
			footer_link: '#dedae3',
			footer_link_hover: '#fff'
		},
		color_3: {
			body_bg: '#e3e6e8',
			header_bg: '#363b3f',
			header_text: '#fff',
			header_text_hover: '#e14d43',
			search_bg: '#e14d43',
			search_text: '#fff',
			header_ext_bg: '#25282b',
			header_ext_text: '#c2c4c5',
			header_ext_text_hover: '#e14d43',
			menu_hover_bg: '#363b3f',
			menu_hover_text: '#e14d43',
			menu_active_bg: '#363b3f',
			menu_active_text: '#e14d43',
			menu_button_bg: '#e14d43',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#fff',
			menu_button_hover_text: '#e14d43',
			drop_bg: '#363b3f',
			drop_text: '#fff',
			drop_hover_bg: '#e14d43',
			drop_hover_text: '#fff',
			drop_active_bg: '#363b3f',
			drop_active_text: '#e14d43',
			main_bg: '#fff',
			main_bg_alternative: '#edf0f2',
			main_border: '#e1e5e8',
			main_heading: '#25282b',
			main_text: '#363b3f',
			main_primary: '#e14d43',
			main_secondary: '#69a8bb',
			main_fade: '#999c9f',
			alt_bg: '#edf0f2',
			alt_bg_alternative: '#fff',
			alt_border: '#d7dde0',
			alt_heading: '#25282b',
			alt_text: '#363b3f',
			alt_primary: '#e14d43',
			alt_secondary: '#69a8bb',
			alt_fade: '#999c9f',
			subfooter_bg: '#363b3f',
			subfooter_border: '#494e52',
			subfooter_text: '#999c9f',
			subfooter_heading: '#c2c4c5',
			subfooter_link: '#c2c4c5',
			subfooter_link_hover: '#69a8bb',
			footer_bg: '#25282b',
			footer_text: '#7a7f83',
			footer_link: '#c2c4c5',
			footer_link_hover: '#69a8bb'
		},
		color_4: {
			body_bg: '#ddd',
			header_bg: '#1a1a1a',
			header_text: '#ddd',
			header_text_hover: '#32beeb',
			search_bg: '#32beeb',
			search_text: '#fff',
			header_ext_bg: '#222',
			header_ext_text: '#999',
			header_ext_text_hover: '#32beeb',
			menu_hover_bg: '#32beeb',
			menu_hover_text: '#fff',
			menu_active_bg: '#1a1a1a',
			menu_active_text: '#32beeb',
			menu_button_bg: '#32beeb',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#28aad4',
			menu_button_hover_text: '#fff',
			drop_bg: '#32beeb',
			drop_text: '#fff',
			drop_hover_bg: '#1a1a1a',
			drop_hover_text: '#fff',
			drop_active_bg: '#28aad4',
			drop_active_text: '#fff',
			main_bg: '#fff',
			main_bg_alternative: '#edf1f2',
			main_border: '#e1e5e8',
			main_heading: '#222',
			main_text: '#444',
			main_primary: '#32beeb',
			main_secondary: '#666',
			main_fade: '#999c9f',
			alt_bg: '#edf1f2',
			alt_bg_alternative: '#fff',
			alt_border: '#d7dde0',
			alt_heading: '#222',
			alt_text: '#444',
			alt_primary: '#32beeb',
			alt_secondary: '#666',
			alt_fade: '#999c9f',
			subfooter_bg: '#1a1a1a',
			subfooter_border: '#222',
			subfooter_text: '#777',
			subfooter_heading: '#ccc',
			subfooter_link: '#ccc',
			subfooter_link_hover: '#32beeb',
			footer_bg: '#222',
			footer_text: '#666',
			footer_link: '#bbb',
			footer_link_hover: '#32beeb'
		},
		color_5: {
			body_bg: '#87a8a5',
			header_bg: '#738e96',
			header_text: '#fff',
			header_text_hover: '#b2dab5',
			search_bg: '#b2dab5',
			search_text: '#38505c',
			header_ext_bg: '#627c83',
			header_ext_text: '#d5dddf',
			header_ext_text_hover: '#fff',
			menu_hover_bg: '#738e96',
			menu_hover_text: '#b2dab5',
			menu_active_bg: '#738e96',
			menu_active_text: '#b2dab5',
			menu_button_bg: '#b2dab5',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#aa9d88',
			menu_button_hover_text: '#fff',
			drop_bg: '#738e96',
			drop_text: '#fff',
			drop_hover_bg: '#627c83',
			drop_hover_text: '#fff',
			drop_active_bg: '#627c83',
			drop_active_text: '#b2dab5',
			main_bg: '#fff',
			main_bg_alternative: '#edf1f2',
			main_border: '#e1e5e8',
			main_heading: '#38505c',
			main_text: '#505c5f',
			main_primary: '#9ebaa0',
			main_secondary: '#aa9d88',
			main_fade: '#999c9f',
			alt_bg: '#edf1f2',
			alt_bg_alternative: '#fff',
			alt_border: '#d7dde0',
			alt_heading: '#38505c',
			alt_text: '#505c5f',
			alt_primary: '#9ebaa0',
			alt_secondary: '#aa9d88',
			alt_fade: '#999c9f',
			subfooter_bg: '#738e96',
			subfooter_border: '#839da4',
			subfooter_text: '#d5dddf',
			subfooter_heading: '#fff',
			subfooter_link: '#fff',
			subfooter_link_hover: '#fff',
			footer_bg: '#627c83',
			footer_text: '#bbc5c7',
			footer_link: '#d5dddf',
			footer_link_hover: '#fff'
		},
		color_6: {
			body_bg: '#59524c',
			header_bg: '#59524c',
			header_text: '#fff',
			header_text_hover: '#c7a589',
			search_bg: '#c7a589',
			search_text: '#fff',
			header_ext_bg: '#46403c',
			header_ext_text: '#cdcbc9',
			header_ext_text_hover: '#c7a589',
			menu_hover_bg: '#46403c',
			menu_hover_text: '#fff',
			menu_active_bg: '#59524c',
			menu_active_text: '#c7a589',
			menu_button_bg: '#c7a589',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#9ea476',
			menu_button_hover_text: '#fff',
			drop_bg: '#46403c',
			drop_text: '#fff',
			drop_hover_bg: '#e5e3e1',
			drop_hover_text: '#46403c',
			drop_active_bg: '#46403c',
			drop_active_text: '#c7a589',
			main_bg: '#f2f1f0',
			main_bg_alternative: '#fff',
			main_border: '#e0dedc',
			main_heading: '#46403c',
			main_text: '#46403c',
			main_primary: '#c7a589',
			main_secondary: '#9ea476',
			main_fade: '#979699',
			alt_bg: '#e5e3e1',
			alt_bg_alternative: '#f2f1f0',
			alt_border: '#d6d4d2',
			alt_heading: '#46403c',
			alt_text: '#46403c',
			alt_primary: '#c7a589',
			alt_secondary: '#9ea476',
			alt_fade: '#979699',
			subfooter_bg: '#59524c',
			subfooter_border: '#69625c',
			subfooter_text: '#b1a9a2',
			subfooter_heading: '#ddd6d0',
			subfooter_link: '#ddd6d0',
			subfooter_link_hover: '#fff',
			footer_bg: '#46403c',
			footer_text: '#98918a',
			footer_link: '#b1a9a2',
			footer_link_hover: '#fff'
		},
		color_7: {
			body_bg: '#333',
			header_bg: '#cf4944',
			header_text: '#fff',
			header_text_hover: '#ebbc00',
			search_bg: '#b43c38',
			search_text: '#fff',
			header_ext_bg: '#333',
			header_ext_text: '#ccc',
			header_ext_text_hover: '#fff',
			menu_hover_bg: '#b43c38',
			menu_hover_text: '#fff',
			menu_active_bg: '#ebbc00',
			menu_active_text: '#fff',
			menu_button_bg: '#ebbc00',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#b43c38',
			menu_button_hover_text: '#fff',
			drop_bg: '#b43c38',
			drop_text: '#fff',
			drop_hover_bg: '#ebbc00',
			drop_hover_text: '#fff',
			drop_active_bg: '#b43c38',
			drop_active_text: '#ebbc00',
			main_bg: '#fff',
			main_bg_alternative: '#f2efed',
			main_border: '#e8e4e1',
			main_heading: '#453d3d',
			main_text: '#444',
			main_primary: '#e87821',
			main_secondary: '#ebbc00',
			main_fade: '#9e9a98',
			alt_bg: '#f2efed',
			alt_bg_alternative: '#fff',
			alt_border: '#e0dbd7',
			alt_heading: '#453d3d',
			alt_text: '#444',
			alt_primary: '#e87821',
			alt_secondary: '#ebbc00',
			alt_fade: '#9e9a98',
			subfooter_bg: '#cf4944',
			subfooter_border: '#d65d59',
			subfooter_text: '#ecc5c3',
			subfooter_heading: '#fff',
			subfooter_link: '#fff',
			subfooter_link_hover: '#fff',
			footer_bg: '#333',
			footer_text: '#777',
			footer_link: '#bbb',
			footer_link_hover: '#ebbc00'
		},
		color_8: {
			body_bg: '#38424a',
			header_bg: '#21282e',
			header_text: '#b0b6be',
			header_text_hover: '#71a7d3',
			search_bg: '#71a7d3',
			search_text: '#fff',
			header_ext_bg: '#1c2126',
			header_ext_text: '#b0b6be',
			header_ext_text_hover: '#937cbf',
			menu_hover_bg: '#1c2126',
			menu_hover_text: '#b0b6be',
			menu_active_bg: '#21282e',
			menu_active_text: '#71a7d3',
			menu_button_bg: '#71a7d3',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#937cbf',
			menu_button_hover_text: '#fff',
			drop_bg: '#1c2126',
			drop_text: '#b0b6be',
			drop_hover_bg: '#71a7d3',
			drop_hover_text: '#fff',
			drop_active_bg: '#1c2126',
			drop_active_text: '#71a7d3',
			main_bg: '#21282e',
			main_bg_alternative: '#1c2126',
			main_border: '#303940',
			main_heading: '#d0d5db',
			main_text: '#bfc4c9',
			main_primary: '#71a7d3',
			main_secondary: '#937cbf',
			main_fade: '#757b83',
			alt_bg: '#1c2126',
			alt_bg_alternative: '#21282e',
			alt_border: '#303940',
			alt_heading: '#d0d5db',
			alt_text: '#bfc4c9',
			alt_primary: '#71a7d3',
			alt_secondary: '#937cbf',
			alt_fade: '#757b83',
			subfooter_bg: '#1c2126',
			subfooter_border: '#21282e',
			subfooter_text: '#939aa2',
			subfooter_heading: '#ccd0d4',
			subfooter_link: '#ccd0d4',
			subfooter_link_hover: '#937cbf',
			footer_bg: '#21282e',
			footer_text: '#939aa2',
			footer_link: '#ccd0d4',
			footer_link_hover: '#937cbf'
		},
		color_9: {
			body_bg: '#eee',
			header_bg: '#fff',
			header_text: '#666',
			header_text_hover: '#1b98e0',
			search_bg: '#fff',
			search_text: '#1b98e0',
			header_ext_bg: '#f5f5f5',
			header_ext_text: '#777',
			header_ext_text_hover: '#1b98e0',
			menu_hover_bg: '#1b98e0',
			menu_hover_text: '#fff',
			menu_active_bg: '#fff',
			menu_active_text: '#1b98e0',
			menu_button_bg: '#1b98e0',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#1487ca',
			menu_button_hover_text: '#fff',
			drop_bg: '#1b98e0',
			drop_text: '#fff',
			drop_hover_bg: '#fff',
			drop_hover_text: '#1b98e0',
			drop_active_bg: '#1487ca',
			drop_active_text: '#fff',
			main_bg: '#fff',
			main_bg_alternative: '#f2f2f2',
			main_border: '#e8e8e8',
			main_heading: '#555',
			main_text: '#666',
			main_primary: '#1b98e0',
			main_secondary: '#447490',
			main_fade: '#999',
			alt_bg: '#f2f2f2',
			alt_bg_alternative: '#fff',
			alt_border: '#ddd',
			alt_heading: '#444',
			alt_text: '#666',
			alt_primary: '#1b98e0',
			alt_secondary: '#447490',
			alt_fade: '#999',
			subfooter_bg: '#333',
			subfooter_border: '#444',
			subfooter_text: '#aaa',
			subfooter_heading: '#ddd',
			subfooter_link: '#ddd',
			subfooter_link_hover: '#1b98e0',
			footer_bg: '#fff',
			footer_text: '#999',
			footer_link: '#666',
			footer_link_hover: '#1b98e0'
		},
		color_10: {
			body_bg: '#fe4641',
			header_bg: '#fff',
			header_text: '#444',
			header_text_hover: '#fda527',
			header_ext_bg: '#fe4641',
			header_ext_text: '#fff',
			header_ext_text_hover: '#fff',
			search_bg: '#fff',
			search_text: '#fe4641',
			menu_hover_bg: '#fff',
			menu_hover_text: '#fda527',
			menu_active_bg: '#fff',
			menu_active_text: '#fe4641',
			drop_bg: '#fff',
			drop_text: '#444',
			drop_hover_bg: '#fff',
			drop_hover_text: '#fda527',
			drop_active_bg: '#fff',
			drop_active_text: '#fe4641',
			menu_button_bg: '#fe4641',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#fda527',
			menu_button_hover_text: '#fff',
			main_bg: '#fff',
			main_bg_alternative: '#f5f5f5',
			main_border: '#e5e5e5',
			main_heading: '#222',
			main_text: '#444',
			main_primary: '#fe4641',
			main_secondary: '#fda527',
			main_fade: '#999',
			alt_bg: '#f5f5f5',
			alt_bg_alternative: '#fff',
			alt_border: '#ddd',
			alt_heading: '#222',
			alt_text: '#444',
			alt_primary: '#fe4641',
			alt_secondary: '#fda527',
			alt_fade: '#999',
			subfooter_bg: '#252525',
			subfooter_border: '#333',
			subfooter_text: '#888',
			subfooter_heading: '#ddd',
			subfooter_link: '#ddd',
			subfooter_link_hover: '#fda527',
			footer_bg: '#181818',
			footer_text: '#666',
			footer_link: '#aaa',
			footer_link_hover: '#fda527'
		},
		color_11: {
			body_bg: '#301c2a',
			header_bg: '#fff',
			header_text: '#66525f',
			header_text_hover: '#f4a641',
			header_ext_bg: '#921245',
			header_ext_text: '#fff',
			header_ext_text_hover: '#fff',
			search_bg: '#921245',
			search_text: '#fff',
			menu_hover_bg: '#fff',
			menu_hover_text: '#f4a641',
			menu_active_bg: '#fff',
			menu_active_text: '#f4a641',
			drop_bg: '#921245',
			drop_text: '#fff',
			drop_hover_bg: '#f4a641',
			drop_hover_text: '#fff',
			drop_active_bg: '#921245',
			drop_active_text: '#f4a641',
			menu_button_bg: '#f4a641',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#921245',
			menu_button_hover_text: '#fff',
			main_bg: '#fff',
			main_bg_alternative: '#f5f5f5',
			main_border: '#ebe6e9',
			main_heading: '#66525f',
			main_text: '#66525f',
			main_primary: '#f4a641',
			main_secondary: '#921245',
			main_fade: '#b39fac',
			alt_bg: '#f5f5f5',
			alt_bg_alternative: '#fff',
			alt_border: '#ded9dc',
			alt_heading: '#66525f',
			alt_text: '#66525f',
			alt_primary: '#f4a641',
			alt_secondary: '#921245',
			alt_fade: '#b39fac',
			subfooter_bg: '#301c2a',
			subfooter_border: '#442b3d',
			subfooter_text: '#b8a5b2',
			subfooter_heading: '#fff',
			subfooter_link: '#f4a641',
			subfooter_link_hover: '#fff',
			footer_bg: '#301c2a',
			footer_text: '#b8a5b2',
			footer_link: '#f4a641',
			footer_link_hover: '#fff'
		},
		color_12: {
			body_bg: '#111',
			header_bg: '#fff',
			header_text: '#444',
			header_text_hover: '#000',
			header_ext_bg: '#111',
			header_ext_text: '#ddd',
			header_ext_text_hover: '#fff',
			search_bg: '#000',
			search_text: '#fff',
			menu_hover_bg: '#fff',
			menu_hover_text: '#000',
			menu_active_bg: '#fff',
			menu_active_text: '#c20',
			drop_bg: '#fff',
			drop_text: '#444',
			drop_hover_bg: '#111',
			drop_hover_text: '#fff',
			drop_active_bg: '#fff',
			drop_active_text: '#c20',
			menu_button_bg: '#111',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#c20',
			menu_button_hover_text: '#fff',
			main_bg: '#fff',
			main_bg_alternative: '#f2f2f2',
			main_border: '#e5e5e5',
			main_heading: '#000',
			main_text: '#444',
			main_primary: '#c20',
			main_secondary: '#000',
			main_fade: '#999',
			alt_bg: '#f2f2f2',
			alt_bg_alternative: '#fff',
			alt_border: '#ddd',
			alt_heading: '#000',
			alt_text: '#444',
			alt_primary: '#c20',
			alt_secondary: '#000',
			alt_fade: '#999',
			subfooter_bg: '#000',
			subfooter_border: '#333',
			subfooter_text: '#666',
			subfooter_heading: '#ccc',
			subfooter_link: '#ccc',
			subfooter_link_hover: '#fff',
			footer_bg: '#111',
			footer_text: '#555',
			footer_link: '#888',
			footer_link_hover: '#fff'
		},
		color_13: {
			body_bg: '#2c3e50',
			header_bg: '#2c3e50',
			header_text: '#edf0f2',
			header_text_hover: '#fc4349',
			header_ext_bg: '#384b5f',
			header_ext_text: '#d3d8db',
			header_ext_text_hover: '#fff',
			search_bg: '#6dbcdb',
			search_text: '#fff',
			menu_hover_bg: '#2c3e50',
			menu_hover_text: '#fc4349',
			menu_active_bg: '#2c3e50',
			menu_active_text: '#6dbcdb',
			drop_bg: '#2c3e50',
			drop_text: '#edf0f2',
			drop_hover_bg: '#2c3e50',
			drop_hover_text: '#fc4349',
			drop_active_bg: '#2c3e50',
			drop_active_text: '#6dbcdb',
			menu_button_bg: '#6dbcdb',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#fc4349',
			menu_button_hover_text: '#fff',
			main_bg: '#fff',
			main_bg_alternative: '#f2f4f5',
			main_border: '#e4e8eb',
			main_heading: '#292e33',
			main_text: '#5c6166',
			main_primary: '#6dbcdb',
			main_secondary: '#fc4349',
			main_fade: '#a4abb3',
			alt_bg: '#f2f4f5',
			alt_bg_alternative: '#fff',
			alt_border: '#e3e6e8',
			alt_heading: '#292e33',
			alt_text: '#5c6166',
			alt_primary: '#6dbcdb',
			alt_secondary: '#fc4349',
			alt_fade: '#a4abb3',
			subfooter_bg: '#2c3e50',
			subfooter_border: '#3f4e5d',
			subfooter_text: '#939da3',
			subfooter_heading: '#d3d8db',
			subfooter_link: '#6dbcdb',
			subfooter_link_hover: '#fc4349',
			footer_bg: '#384b5f',
			footer_text: '#939da3',
			footer_link: '#d3d8db',
			footer_link_hover: '#fc4349'
		},
		color_14: {
			body_bg: '#d9dedd',
			header_bg: '#29b28f',
			header_text: '#fff',
			header_text_hover: '#fff',
			header_ext_bg: '#24a584',
			header_ext_text: '#cae5df',
			header_ext_text_hover: '#fff',
			search_bg: '#24a584',
			search_text: '#fff',
			menu_hover_bg: '#24a584',
			menu_hover_text: '#fff',
			menu_active_bg: '#24a584',
			menu_active_text: '#fff',
			drop_bg: '#24a584',
			drop_text: '#fff',
			drop_hover_bg: '#fff',
			drop_hover_text: '#29b28f',
			drop_active_bg: '#1e9879',
			drop_active_text: '#fff',
			menu_button_bg: '#fff',
			menu_button_text: '#0190a8',
			menu_button_hover_bg: '#0190a8',
			menu_button_hover_text: '#fff',
			main_bg: '#f2f7f7',
			main_bg_alternative: '#e6eded',
			main_border: '#dae0e0',
			main_heading: '#2b3233',
			main_text: '#5c6566',
			main_primary: '#29b28f',
			main_secondary: '#0190a8',
			main_fade: '#a4b1b3',
			alt_bg: '#e6eded',
			alt_bg_alternative: '#f2f7f7',
			alt_border: '#d0d6d6',
			alt_heading: '#2b3233',
			alt_text: '#5c6566',
			alt_primary: '#29b28f',
			alt_secondary: '#0190a8',
			alt_fade: '#a4b1b3',
			subfooter_bg: '#445a58',
			subfooter_border: '#556b69',
			subfooter_text: '#c9d1d0',
			subfooter_heading: '#fff',
			subfooter_link: '#fff',
			subfooter_link_hover: '#fff',
			footer_bg: '#3a4e4c',
			footer_text: '#9ea9a8',
			footer_link: '#c9d1d0',
			footer_link_hover: '#fff'
		},
		color_15: {
			body_bg: '#e3e6e8',
			header_bg: '#fff',
			header_text: '#676f7c',
			header_text_hover: '#a0d468',
			header_ext_bg: '#f2f3f5',
			header_ext_text: '#979ea8',
			header_ext_text_hover: '#a0d468',
			search_bg: '#a0d468',
			search_text: '#fff',
			menu_hover_bg: '#fff',
			menu_hover_text: '#a0d468',
			menu_active_bg: '#fff',
			menu_active_text: '#a0d468',
			drop_bg: '#fff',
			drop_text: '#676f7c',
			drop_hover_bg: '#a0d468',
			drop_hover_text: '#fff',
			drop_active_bg: '#fff',
			drop_active_text: '#a0d468',
			menu_button_bg: '#a0d468',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#4fc0ea',
			menu_button_hover_text: '#fff',
			main_bg: '#fff',
			main_bg_alternative: '#f2f3f5',
			main_border: '#e8e9eb',
			main_heading: '#434955',
			main_text: '#676f7c',
			main_primary: '#a0d468',
			main_secondary: '#4fc0ea',
			main_fade: '#aab2bd',
			alt_bg: '#f2f3f5',
			alt_bg_alternative: '#fff',
			alt_border: '#d9dbde',
			alt_heading: '#434955',
			alt_text: '#676f7c',
			alt_primary: '#a0d468',
			alt_secondary: '#4fc0ea',
			alt_fade: '#aab2bd',
			subfooter_bg: '#a0d468',
			subfooter_border: '#8fbf5c',
			subfooter_text: '#f3ffe5',
			subfooter_heading: '#fff',
			subfooter_link: '#434955',
			subfooter_link_hover: '#fff',
			footer_bg: '#656d78',
			footer_text: '#a2a9b4',
			footer_link: '#eaeef1',
			footer_link_hover: '#a0d468'
		},
		color_16: {
			body_bg: '#f2f1f0',
			header_bg: '#fff',
			header_text: '#333',
			header_text_hover: '#f9a02c',
			header_ext_bg: '#f6f6f6',
			header_ext_text: '#666',
			header_ext_text_hover: '#f9a02c',
			search_bg: '#fff',
			search_text: '#000',
			menu_hover_bg: '#fff',
			menu_hover_text: '#f9a02c',
			menu_active_bg: '#fff',
			menu_active_text: '#f9a02c',
			drop_bg: '#fff',
			drop_text: '#333',
			drop_hover_bg: '#f9a02c',
			drop_hover_text: '#fff',
			drop_active_bg: '#fff',
			drop_active_text: '#f9a02c',
			menu_button_bg: '#f9a02c',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#333',
			menu_button_hover_text: '#fff',
			main_bg: '#fff',
			main_bg_alternative: '#f6f6f6',
			main_border: '#ebebeb',
			main_heading: '#000',
			main_text: '#333',
			main_primary: '#f9a02c',
			main_secondary: '#666',
			main_fade: '#999',
			alt_bg: '#f6f6f6',
			alt_bg_alternative: '#fff',
			alt_border: '#e5e5e5',
			alt_heading: '#000',
			alt_text: '#333',
			alt_primary: '#f9a02c',
			alt_secondary: '#666',
			alt_fade: '#999',
			subfooter_bg: '#f6f6f6',
			subfooter_border: '#e2e2e2',
			subfooter_text: '#666',
			subfooter_heading: '#000',
			subfooter_link: '#f9a02c',
			subfooter_link_hover: '#000',
			footer_bg: '#fff',
			footer_text: '#999',
			footer_link: '#666',
			footer_link_hover: '#f9a02c'
		},
		color_17: {
			body_bg: '#d9cfb8',
			header_bg: '#4e4540',
			header_text: '#f7f4ed',
			header_text_hover: '#47bbca',
			header_ext_bg: '#3d3632',
			header_ext_text: '#f7f4ed',
			header_ext_text_hover: '#47bbca',
			search_bg: '#47bbca',
			search_text: '#fff',
			menu_hover_bg: '#4e4540',
			menu_hover_text: '#f7f4ed',
			menu_active_bg: '#4e4540',
			menu_active_text: '#f26c51',
			drop_bg: '#4e4540',
			drop_text: '#f7f4ed',
			drop_hover_bg: '#3d3632',
			drop_hover_text: '#f7f4ed',
			drop_active_bg: '#4e4540',
			drop_active_text: '#f26c51',
			menu_button_bg: '#f26c51',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#47bbca',
			menu_button_hover_text: '#fff',
			main_bg: '#f7f4ed',
			main_bg_alternative: '#edeae4',
			main_border: '#e5e1d7',
			main_heading: '#4e4540',
			main_text: '#4e4540',
			main_primary: '#f26c51',
			main_secondary: '#47bbca',
			main_fade: '#99948a',
			alt_bg: '#edeae4',
			alt_bg_alternative: '#f7f4ed',
			alt_border: '#dbd5ca',
			alt_heading: '#4e4540',
			alt_text: '#4e4540',
			alt_primary: '#f26c51',
			alt_secondary: '#47bbca',
			alt_fade: '#99948a',
			subfooter_bg: '#4e4540',
			subfooter_border: '#5c524d',
			subfooter_text: '#ada29a',
			subfooter_heading: '#f7f4ed',
			subfooter_link: '#f26c51',
			subfooter_link_hover: '#47bbca',
			footer_bg: '#3d3632',
			footer_text: '#978f8a',
			footer_link: '#c4b8b1',
			footer_link_hover: '#47bbca'
		},
		color_18: {
			body_bg: '#242d39',
			header_bg: '#323f4f',
			header_text: '#e8eff5',
			header_text_hover: '#fd6861',
			header_ext_bg: '#242d39',
			header_ext_text: '#b8c1cc',
			header_ext_text_hover: '#8ed8f5',
			search_bg: '#242d39',
			search_text: '#fff',
			menu_hover_bg: '#323f4f',
			menu_hover_text: '#8ed8f5',
			menu_active_bg: '#323f4f',
			menu_active_text: '#fd6861',
			drop_bg: '#242d39',
			drop_text: '#e8eff5',
			drop_hover_bg: '#242d39',
			drop_hover_text: '#8ed8f5',
			drop_active_bg: '#242d39',
			drop_active_text: '#fd6861',
			menu_button_bg: '#fd6861',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#e8eff5',
			menu_button_hover_text: '#242d39',
			main_bg: '#465568',
			main_bg_alternative: '#323f4f',
			main_border: '#596b80',
			main_heading: '#fff',
			main_text: '#e8eff5',
			main_primary: '#fd6861',
			main_secondary: '#8ed8f5',
			main_fade: '#7c8a97',
			alt_bg: '#323f4f',
			alt_bg_alternative: '#465568',
			alt_border: '#465568',
			alt_heading: '#fff',
			alt_text: '#e8eff5',
			alt_primary: '#fd6861',
			alt_secondary: '#8ed8f5',
			alt_fade: '#7c8a97',
			subfooter_bg: '#323f4f',
			subfooter_border: '#414f61',
			subfooter_text: '#959eab',
			subfooter_heading: '#cbcfd4',
			subfooter_link: '#cbcfd4',
			subfooter_link_hover: '#8ed8f5',
			footer_bg: '#242d39',
			footer_text: '#8a9099',
			footer_link: '#cbcfd4',
			footer_link_hover: '#8ed8f5'
		},
		color_19: {
			body_bg: '#222731',
			header_bg: '#00d5c3',
			header_text: '#fff',
			header_text_hover: '#222731',
			header_ext_bg: '#0cb',
			header_ext_text: '#cdfaf6',
			header_ext_text_hover: '#fff',
			search_bg: '#00d5c3',
			search_text: '#fff',
			menu_hover_bg: '#00d5c3',
			menu_hover_text: '#fff',
			menu_active_bg: '#00d5c3',
			menu_active_text: '#222731',
			drop_bg: '#374258',
			drop_text: '#fff',
			drop_hover_bg: '#00d5c3',
			drop_hover_text: '#fff',
			drop_active_bg: '#374258',
			drop_active_text: '#00d5c3',
			menu_button_bg: '#374258',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#fff',
			menu_button_hover_text: '#374258',
			main_bg: '#4c576d',
			main_bg_alternative: '#374258',
			main_border: '#636e85',
			main_heading: '#fff',
			main_text: '#e8eff5',
			main_primary: '#00d5c3',
			main_secondary: '#6baeff',
			main_fade: '#7b8496',
			alt_bg: '#374258',
			alt_bg_alternative: '#4c576d',
			alt_border: '#4a566f',
			alt_heading: '#fff',
			alt_text: '#e8eff5',
			alt_primary: '#00d5c3',
			alt_secondary: '#6baeff',
			alt_fade: '#7b8496',
			subfooter_bg: '#374258',
			subfooter_border: '#4a566f',
			subfooter_text: '#b6bec9',
			subfooter_heading: '#fff',
			subfooter_link: '#fff',
			subfooter_link_hover: '#00d5c3',
			footer_bg: '#303a4d',
			footer_text: '#7c8a97',
			footer_link: '#fff',
			footer_link_hover: '#00d5c3'
		}
	}

	function update_custom_colors(color_scheme){
		for (var field_id in color_scheme) {
			var color_hex = color_scheme[field_id];
			jQuery('#section-' + field_id + ' .colorSelector').ColorPickerSetColor(color_hex);
			jQuery('#section-' + field_id + ' .colorSelector').children('div').css('backgroundColor', color_hex);
			jQuery('#section-' + field_id + ' .of-color').val(color_hex);
		}
	}

	jQuery('#color_scheme').change(function() {
		switch ($(this).val()){
			case 'White Pink': update_custom_colors(colors.color_0); break;
			case 'Grey Turquoise': update_custom_colors(colors.color_1); break;
			case 'Ectoplasm': update_custom_colors(colors.color_2); break;
			case 'Midnight Red': update_custom_colors(colors.color_3); break;
			case 'Stylish Cyan': update_custom_colors(colors.color_4); break;
			case 'Light Ocean': update_custom_colors(colors.color_5); break;
			case 'Coffee Shop': update_custom_colors(colors.color_6); break;
			case 'Bright Sunrise': update_custom_colors(colors.color_7); break;
			case 'Twilight': update_custom_colors(colors.color_8); break;
			case 'White Blue': update_custom_colors(colors.color_9); break;
			case 'White Alizarin': update_custom_colors(colors.color_10); break;
			case 'White Royal': update_custom_colors(colors.color_11); break;
			case 'Black & White': update_custom_colors(colors.color_12); break;
			case 'Nautical Knot': update_custom_colors(colors.color_13); break;
			case 'Mild Ocean': update_custom_colors(colors.color_14); break;
			case 'White Green': update_custom_colors(colors.color_15); break;
			case 'White Yellow': update_custom_colors(colors.color_16); break;
			case 'Retro Package': update_custom_colors(colors.color_17); break;
			case 'City Hunter': update_custom_colors(colors.color_18); break;
			case 'Dark Cyan': update_custom_colors(colors.color_19); break;
		}
	});

	jQuery('#section-header_is_sticky .controls .switch-options').click(function(){
		if (jQuery('#section-header_is_sticky .controls .cb-enable').hasClass('selected')) {
			if (window.main_header_layout == 'standard' || window.main_header_layout == 'extended') {
				jQuery('#section-header_main_shrinked_height').slideDown('normal', "swing");
			}
		} else {
			jQuery('#section-header_main_shrinked_height').slideUp('normal', "swing");
		}
	});

	jQuery('#section-main_header_layout .of-radio-img-img').on('click', function(){

		var layout = 'standard';
		if (jQuery(this).siblings('#of-radio-img-main_header_layout2').length) {
			layout = 'extended';
		}
		if (jQuery(this).siblings('#of-radio-img-main_header_layout3').length) {
			layout = 'advanced';
		}
		if (jQuery(this).siblings('#of-radio-img-main_header_layout4').length) {
			layout = 'centered';
		}

		window.main_header_layout = layout;

		if (layout == 'centered') {
			jQuery('#section-header_invert_logo_pos').slideUp('normal', "swing");
		} else {
			jQuery('#section-header_invert_logo_pos').slideDown('normal', "swing");
		}

		if (layout == 'standard') {
			if (jQuery('#section-header_is_sticky .controls .cb-enable').hasClass('selected')) {
				jQuery('#section-header_main_shrinked_height').slideDown('normal', "swing");
			} else {
				jQuery('#section-header_main_shrinked_height').slideUp('normal', "swing");
			}
			jQuery('#section-header_extra_height').slideUp('normal', "swing");

		} else if (layout == 'extended') {
			if (jQuery('#section-header_is_sticky .controls .cb-enable').hasClass('selected')) {
				jQuery('#section-header_main_shrinked_height').slideDown('normal', "swing");
			} else {
				jQuery('#section-header_main_shrinked_height').slideUp('normal', "swing");
			}
			jQuery('#section-header_extra_height').slideDown('normal', "swing");

		} else if (layout == 'advanced' || layout == 'centered') {
			jQuery('#section-header_main_shrinked_height').slideUp('normal', "swing");
			jQuery('#section-header_extra_height').slideDown('normal', "swing");

		}

		if (layout == 'standard' || layout == 'centered') {
			jQuery('#section-header_show_language').slideUp('normal', "swing");
			jQuery('#section-header_language_type').slideUp('normal', "swing");
			jQuery('#section-header_language_amount').slideUp('normal', "swing");
			jQuery('#section-header_language_1_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_url').slideUp('normal', "swing");
			jQuery('#section-header_language_3_name').slideUp('normal', "swing");
			jQuery('#section-header_language_3_url').slideUp('normal', "swing");
			jQuery('#section-header_language_4_name').slideUp('normal', "swing");
			jQuery('#section-header_language_4_url').slideUp('normal', "swing");
			jQuery('#section-header_language_5_name').slideUp('normal', "swing");
			jQuery('#section-header_language_5_url').slideUp('normal', "swing");
			jQuery('#section-header_language_6_name').slideUp('normal', "swing");
			jQuery('#section-header_language_6_url').slideUp('normal', "swing");
			jQuery('#section-header_language_7_name').slideUp('normal', "swing");
			jQuery('#section-header_language_7_url').slideUp('normal', "swing");
			jQuery('#section-header_language_8_name').slideUp('normal', "swing");
			jQuery('#section-header_language_8_url').slideUp('normal', "swing");
			jQuery('#section-header_language_9_name').slideUp('normal', "swing");
			jQuery('#section-header_language_9_url').slideUp('normal', "swing");
			jQuery('#section-header_language_10_name').slideUp('normal', "swing");
			jQuery('#section-header_language_10_url').slideUp('normal', "swing");

			jQuery('#section-header_show_contacts').slideUp('normal', "swing");
			jQuery('#section-header_phone').slideUp('normal', "swing");
			jQuery('#section-header_email').slideUp('normal', "swing");

			jQuery('#section-header_show_socials').slideUp('normal', "swing");
			jQuery('#section-header_social_facebook').slideUp('normal', "swing");
			jQuery('#section-header_social_twitter').slideUp('normal', "swing");
			jQuery('#section-header_social_google').slideUp('normal', "swing");
			jQuery('#section-header_social_linkedin').slideUp('normal', "swing");
			jQuery('#section-header_social_youtube').slideUp('normal', "swing");
			jQuery('#section-header_social_vimeo').slideUp('normal', "swing");
			jQuery('#section-header_social_flickr').slideUp('normal', "swing");
			jQuery('#section-header_social_instagram').slideUp('normal', "swing");
			jQuery('#section-header_social_behance').slideUp('normal', "swing");
			jQuery('#section-header_social_xing').slideUp('normal', "swing");
			jQuery('#section-header_social_pinterest').slideUp('normal', "swing");
			jQuery('#section-header_social_skype').slideUp('normal', "swing");
			jQuery('#section-header_social_tumblr').slideUp('normal', "swing");
			jQuery('#section-header_social_dribbble').slideUp('normal', "swing");
			jQuery('#section-header_social_vk').slideUp('normal', "swing");
			jQuery('#section-header_social_soundcloud').slideUp('normal', "swing");
			jQuery('#section-header_social_yelp').slideUp('normal', "swing");
			jQuery('#section-header_social_twitch').slideUp('normal', "swing");
			jQuery('#section-header_social_rss').slideUp('normal', "swing");

			jQuery('#section-header_show_custom').slideUp('normal', "swing");
			jQuery('#section-header_custom_icon').slideUp('normal', "swing");
			jQuery('#section-header_custom_text').slideUp('normal', "swing");

		} else {
			jQuery('#section-header_show_contacts').slideDown('normal', "swing");
			jQuery('#section-header_show_contacts .controls .switch-options .selected').click();

			jQuery('#section-header_show_socials').slideDown('normal', "swing");
			jQuery('#section-header_show_socials .controls .switch-options .selected').click();

			jQuery('#section-header_show_custom').slideDown('normal', "swing");
			jQuery('#section-header_show_custom .controls .switch-options .selected').click();

			jQuery('#section-header_show_language').slideDown('normal', "swing");
			jQuery('#section-header_show_language .controls').click();
		}
	});

	jQuery('#section-header_show_language .controls').live('click', function() {

		if (jQuery('#section-header_show_language .controls .cb-enable').hasClass('selected')) {
			jQuery('#section-header_language_type').slideDown('normal', "swing");
			jQuery('#header_language_type').change();

		} else {
			jQuery('#section-header_language_type').slideUp('normal', "swing");
			jQuery('#section-header_language_amount').slideUp('normal', "swing");
			jQuery('#section-header_language_1_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_url').slideUp('normal', "swing");
			jQuery('#section-header_language_3_name').slideUp('normal', "swing");
			jQuery('#section-header_language_3_url').slideUp('normal', "swing");
			jQuery('#section-header_language_4_name').slideUp('normal', "swing");
			jQuery('#section-header_language_4_url').slideUp('normal', "swing");
			jQuery('#section-header_language_5_name').slideUp('normal', "swing");
			jQuery('#section-header_language_5_url').slideUp('normal', "swing");
			jQuery('#section-header_language_6_name').slideUp('normal', "swing");
			jQuery('#section-header_language_6_url').slideUp('normal', "swing");
			jQuery('#section-header_language_7_name').slideUp('normal', "swing");
			jQuery('#section-header_language_7_url').slideUp('normal', "swing");
			jQuery('#section-header_language_8_name').slideUp('normal', "swing");
			jQuery('#section-header_language_8_url').slideUp('normal', "swing");
			jQuery('#section-header_language_9_name').slideUp('normal', "swing");
			jQuery('#section-header_language_9_url').slideUp('normal', "swing");
			jQuery('#section-header_language_10_name').slideUp('normal', "swing");
			jQuery('#section-header_language_10_url').slideUp('normal', "swing");

		}

	});


	jQuery('#header_language_type').live('change', function(){
		if (jQuery(this).val() == 'Your own links') {
			jQuery('#section-header_language_amount').slideDown('normal', "swing");
			jQuery('#section-header_language_1_name').slideDown('normal', "swing");
			jQuery('#header_language_amount').change();

		} else {
			jQuery('#section-header_language_amount').slideUp('normal', "swing");
			jQuery('#section-header_language_1_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_url').slideUp('normal', "swing");
			jQuery('#section-header_language_3_name').slideUp('normal', "swing");
			jQuery('#section-header_language_3_url').slideUp('normal', "swing");
			jQuery('#section-header_language_4_name').slideUp('normal', "swing");
			jQuery('#section-header_language_4_url').slideUp('normal', "swing");
			jQuery('#section-header_language_5_name').slideUp('normal', "swing");
			jQuery('#section-header_language_5_url').slideUp('normal', "swing");
			jQuery('#section-header_language_6_name').slideUp('normal', "swing");
			jQuery('#section-header_language_6_url').slideUp('normal', "swing");
			jQuery('#section-header_language_7_name').slideUp('normal', "swing");
			jQuery('#section-header_language_7_url').slideUp('normal', "swing");
			jQuery('#section-header_language_8_name').slideUp('normal', "swing");
			jQuery('#section-header_language_8_url').slideUp('normal', "swing");
			jQuery('#section-header_language_9_name').slideUp('normal', "swing");
			jQuery('#section-header_language_9_url').slideUp('normal', "swing");
			jQuery('#section-header_language_10_name').slideUp('normal', "swing");
			jQuery('#section-header_language_10_url').slideUp('normal', "swing");

		}
	});

	jQuery('#header_language_amount').live('change', function(){
		for(var i = 2; i <= 10; i++) {
			if (i <= jQuery(this).val()-0) {
				jQuery('#section-header_language_'+i+'_name').slideDown('normal', "swing");
				jQuery('#section-header_language_'+i+'_url').slideDown('normal', "swing");
			} else {
				jQuery('#section-header_language_'+i+'_name').slideUp('normal', "swing");
				jQuery('#section-header_language_'+i+'_url').slideUp('normal', "swing");
			}
		}
	});

	if (jQuery('#section-main_header_layout .of-radio-img-img.of-radio-img-selected').length) {
		jQuery('#section-main_header_layout .of-radio-img-img.of-radio-img-selected').click();
	} else {
		jQuery('#section-main_header_layout .of-radio-img-img')[0].click();
	}


	jQuery('.of-color').on('change', function(){
		jQuery(this).siblings('.colorSelector').ColorPickerSetColor(jQuery(this).val());
		jQuery(this).siblings('.colorSelector').children('div').css('backgroundColor', jQuery(this).val());
	})

});
