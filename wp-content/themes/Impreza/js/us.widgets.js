/* G-Alert */
(function ($) {
	"use strict";

	$.fn.gAlert = function () {

		return this.each(function () {
			var alert = $(this),
				alertClose = alert.find('.g-alert-close');

			if (alertClose) {
				alertClose.click(function(){
					alert.animate({ height: '0', margin: 0}, 400, function(){
						alert.css('display', 'none');
					});
				});
			}
		});
	};
})(jQuery);

jQuery(document).ready(function() {
	"use strict";

	jQuery('.g-alert').gAlert();
});

/* W-Lang */
(function ($) {
	"use strict";

	$.fn.wLang = function () {

		return this.each(function () {
			var langWidget = $(this),
				langList = langWidget.find('.w-lang-list'),
				currentLang = langWidget.find('.w-lang-current');

			langList.slideUp(0);

			currentLang.click(function() {
				langWidget.addClass('active');
				langList.slideDown(200);
			});

			$(document).mouseup(function (e)
			{
				if (langWidget.has(e.target).length === 0)
				{
					langList.slideUp(200, function() {
						langWidget.removeClass('active');
					});
				}
			});
		});
	};
})(jQuery);

jQuery(document).ready(function() {
	"use strict";

	jQuery('.w-lang').wLang();
});

/* W-Search */
(function ($) {
	"use strict";

	$.fn.wSearch = function () {


		return this.each(function () {
			var searchForm = $(this).find('.w-search-form'),
				searchShow = $(this).find('.w-search-show'),
				searchClose = $(this).find('.w-search-close'),
				searchInput = searchForm.find('.w-search-input input');

			if (searchShow) {
				searchShow.click(function(){
					searchForm.animate({ top: '0px'}, 250, function(){
						searchInput.focus();
					});
				});
			}

			searchInput.keyup(function(e) {
				if (e.keyCode == 27) {
					searchForm.animate({ top: '-100%'}, 250);
				}
			});

			if (searchClose) {
				searchClose.click(function(){
					searchForm.animate({ top: '-100%'}, 250);
				});
			}
		});
	};
})(jQuery);

jQuery(document).ready(function() {
	"use strict";

	jQuery('.w-search').wSearch();
});

/* W-Tabs */
(function ($) {
	"use strict";

	$.fn.wTabs = function () {


		return this.each(function () {
			var tabs = $(this),
				items = tabs.find('.w-tabs-item'),
				sections = tabs.find('.w-tabs-section'),
				resizeTimer = null,
				itemsWidth = 0,
				running = false,
				firstActiveItem = tabs.find('.w-tabs-item.active').first(),
				firstActiveSection = tabs.find('.w-tabs-section.active').first();



			if ( ! tabs.hasClass('layout_accordion')) {
				if ( ! firstActiveItem.length) {
					firstActiveItem = tabs.find('.w-tabs-item').first();
					firstActiveSection = tabs.find('.w-tabs-section').first();
				}
			}

			if (firstActiveItem.length) {
				tabs.find('.w-tabs-item.active').removeClass('active');
				tabs.find('.w-tabs-section.active').removeClass('active');

				firstActiveItem.addClass('active');
				firstActiveSection.addClass('active');
			}




			items.each(function(){
				itemsWidth += $(this).outerWidth(true);
			});

			function tabs_resize(){
				if ( ! (tabs.hasClass('layout_accordion') && ! tabs.data('accordionLayoutDynamic'))) {
					if (itemsWidth > tabs.width()) {
						tabs.data('accordionLayoutDynamic', true);
						if ( ! tabs.hasClass('layout_accordion')) {
							tabs.addClass('layout_accordion');
						}
					} else {
						if (tabs.hasClass('layout_accordion')) {
							tabs.removeClass('layout_accordion');
						}
					}
				}
			}

			tabs_resize();

			$(window).resize(function(){
				window.clearTimeout(resizeTimer);
				resizeTimer = window.setTimeout(function(){
					tabs_resize();
				}, 50);

			});

			sections.each(function(index){
				var item = $(items[index]),
					section = $(sections[index]),
					section_title = section.find('.w-tabs-section-header'),
					section_content = section.find('.w-tabs-section-content');

				if (section.hasClass('active')) {
					section_content.slideDown();
				}

				section_title.click(function(){
					if (tabs.hasClass('type_toggle')) {
						if ( ! running) {
							if (section.hasClass('active')) {
								running = true;
								if (item) {
									item.removeClass('active');
								}
								section_content.slideUp(null, function(){
									section.removeClass('active');
									running = false;
								});
							} else {
								running = true;
								if (item) {
									item.addClass('active');
								}
								section_content.slideDown(null, function(){
									section.addClass('active');

									section.find('.w-map').each(function(map){
										var mapObj = jQuery(this).data('gMap.reference'),
											center = mapObj.getCenter();

										google.maps.event.trigger(jQuery(this)[0], 'resize');
										if (jQuery(this).data('gMap.infoWindows').length) {
											jQuery(this).data('gMap.infoWindows')[0].open(mapObj, jQuery(this).data('gMap.overlays')[0]);
										}
										mapObj.setCenter(center);
									});
									$(window).resize();

									running = false;
								});
							}
						}


					} else if (( ! section.hasClass('active')) && ( ! running)) {
						running = true;
						items.each(function(){
							if ($(this).hasClass('active')) {
								$(this).removeClass('active');
							}
						});
						if (item) {
							item.addClass('active');
						}

						sections.each(function(){
							if ($(this).hasClass('active')) {
								$(this).find('.w-tabs-section-content').slideUp();
							}
						});

						section_content.slideDown(null, function(){
							sections.each(function(){
								if ($(this).hasClass('active')) {
									$(this).removeClass('active');
								}
							});
							section.addClass('active');

							section.find('.w-map').each(function(map){
								var mapObj = jQuery(this).data('gMap.reference'),
									center = mapObj.getCenter();

								google.maps.event.trigger(jQuery(this)[0], 'resize');
								if (jQuery(this).data('gMap.infoWindows').length) {
									jQuery(this).data('gMap.infoWindows')[0].open(mapObj, jQuery(this).data('gMap.overlays')[0]);
								}
								mapObj.setCenter(center);
							});
							$(window).resize();

							if (tabs.hasClass('layout_accordion') && jQuery(window).width() < 768) {
								jQuery("html, body").animate({
									scrollTop: section.offset().top-(jQuery('.l-header').height())+"px"
								}, {
									duration: 1200,
									easing: "easeInOutQuint"
								});
							}

							running = false;
						});

					}

				});

				if (item)
				{
					item.click(function(){
						section_title.click();
					});
				}


			});

		});
	};
})(jQuery);

jQuery(document).ready(function() {
	"use strict";

	jQuery('.w-tabs').wTabs();
});

/* W-Timeline */
(function ($) {
	"use strict";

	$.fn.wTimeline = function () {

		return this.each(function () {
			var timeline = $(this),
				items = timeline.find('.w-timeline-item'),
				sections = timeline.find('.w-timeline-section'),
				running = false,
				sectionsWrapper = timeline.find('.w-timeline-sections'),
				sumWidth = 0,
				sectionsContainer = $('<div></div>', {id: 'section_container'}).css({position: 'relative'}),
				resizeTimer = null,
				sectionsPadding = $(sections[0]).innerWidth() - $(sections[0]).width(),
				activeIndex = 0,
				activeIndexFound = 0,
				sectionsContainerPresent,
				firstActiveItem = timeline.find('.w-timeline-item.active').first(),
				firstActiveSection = timeline.find('.w-timeline-section.active').first();

			if ( ! firstActiveItem.length) {
				firstActiveItem = timeline.find('.w-timeline-item').first();
				firstActiveSection = timeline.find('.w-timeline-section').first();
			}

			timeline.find('.w-timeline-item.active').removeClass('active');
			timeline.find('.w-timeline-section.active').removeClass('active');

			firstActiveItem.addClass('active');
			firstActiveSection.addClass('active');

			$(sections).each(function(sectionIndex, section) {
				if ($(section).hasClass('active')) {
					activeIndex = sectionIndex;
				}
			});

			$(sections).css({display: 'block'});
			$(sectionsWrapper).css({position: 'relative'});



			function timeline_resize(){
				sectionsWrapper.css({width: timeline.innerWidth()-sectionsWrapper.css('border-left-width')-sectionsWrapper.css('border-right-width')+'px'});
				$(sections).css({width: sectionsWrapper.innerWidth()-sectionsPadding+'px'});

				if ($(window).width() < 768 && ( ! window.disableResponsiveLayout)) {
					if ( ! timeline.hasClass('type_vertical')) {
						timeline.addClass('type_vertical');
					}
					if (sectionsContainerPresent === true || sectionsContainerPresent === undefined ){
						sectionsWrapper.css({ height: 'auto', overflow: 'visible'});
						$(sections).css({float: 'none'});
						$(sections).each(function(sectionIndex, section) {
							var section_content = $(section).find('.w-timeline-section-content');
							if (!$(section).hasClass('active')) {
								section_content.css('display', 'none');
							}
							sectionsWrapper.append(section);
						});
						sectionsContainer.remove();
						sectionsContainerPresent = false;
					}
				} else {
					if (timeline.hasClass('type_vertical')) {
						timeline.removeClass('type_vertical');
					}
					sectionsWrapper.css({ height: $(sections[activeIndex]).outerHeight()+'px', overflow: 'hidden'});
					sumWidth = sections.length*(sectionsWrapper.innerWidth());
					var leftPos = -activeIndex*(sectionsWrapper.innerWidth());
					sectionsContainer.css({width: sumWidth+'px', height: $(sections[activeIndex]).outerHeight()+'px', left: leftPos});
					if (sectionsContainerPresent === false || sectionsContainerPresent === undefined){
						sectionsContainer = $('<div></div>', {id: 'section_container'}).css({position: 'relative'});
						$(sections).css({float: 'left'});
						$(sections).each(function(sectionIndex, section) {
							var section_content = $(section).find('.w-timeline-section-content');
							section_content.css({'display': 'block', 'height': 'auto'});
							sectionsContainer.append(section);
						});

						sectionsContainer.css({width: sumWidth+'px', height: $(sections[activeIndex]).outerHeight()+'px', left: leftPos});
						sectionsWrapper.append(sectionsContainer);
						sectionsContainerPresent = true;
					}
				}
			}

			timeline_resize();

			$(window).resize(function(){
				window.clearTimeout(resizeTimer);
				resizeTimer = window.setTimeout(function(){
					timeline_resize();
				}, 50);

			});

			sections.each(function(index, element){
				var section = $(element),
					item = $(items[index]),
					section_title = section.find('.w-timeline-section-title'),
					section_content = section.find('.w-timeline-section-content');

				if(item.length)
				{
					item.click(function(){
						if (( ! section.hasClass('active')) && ( ! running)) {
							running = true;
							items.each(function(){
								if ($(this).hasClass('active')) {
									$(this).removeClass('active');
								}
							});
							if (item.length) {
								item.addClass('active');
							}

							var leftPos = -index*(sectionsWrapper.innerWidth());
							sectionsWrapper.animate({height: section.outerHeight()}, 300);
							sectionsContainer.animate({left: leftPos}, 300, function(){
								sections.each(function(){
									if ($(this).hasClass('active')) {
										$(this).removeClass('active');
									}
								});
								section.addClass('active');
								activeIndex = index;
								running = false;
							});

						}
					});
				}

				if(section_title.length)
				{
					section_title.click(function() {
						if (( ! section.hasClass('active')) && ( ! running)) {
							running = true;
							var currentHeight, newHeight;
							items.each(function(){
								if ($(this).hasClass('active')) {
									$(this).removeClass('active');
								}
							});
							if (item.length) {
								item.addClass('active');
							}

							sections.each(function(){
								if ($(this).hasClass('active')) {
									currentHeight = $(this).find('.w-timeline-section-content').height();
									$(this).find('.w-timeline-section-content').slideUp();
								}
							});

							newHeight = section_content.height();

							section_content.slideDown(null, function(){
								sections.each(function(){
									if ($(this).hasClass('active')) {
										$(this).removeClass('active');
									}
								});
								section.addClass('active');
								activeIndex = index;

								jQuery("html, body").animate({
									scrollTop: section.offset().top-(jQuery('.l-header').height())+"px"
								}, {
									duration: 1200,
									easing: "easeInOutQuint"
								});

								running = false;
							});

						}
					});
				}


			});

		});
	};
})(jQuery);

jQuery(document).ready(function() {
	"use strict";

	jQuery('.w-timeline').wTimeline();
});
