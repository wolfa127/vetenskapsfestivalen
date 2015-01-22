/**
 * Rows with columns
 */
(function() {
	tinymce.create('tinymce.plugins.columns', {
		init : function(ed, url) {
			// TODO fix this
			window.columnsImageUrl = url;

			ed.addButton('columns', {
				title: 'Columns',
				icon: 'us_columns',
				type: 'menubutton',
				menu: [
					{
						text: '2 columns',
						menu: [
							{
								text: '[____1/2____][____1/2____]',
								value: '[vc_row]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[__1/3__][______2/3______]',
								value: '[vc_row]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="2/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[______2/3______][__1/3__]',
								value: '[vc_row]<br />[vc_column width="2/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[_1/4_][_______3/4_______]',
								value: '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="3/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[_______3/4_______][_1/4_]',
								value: '[vc_row]<br />[vc_column width="3/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							}
						]
					},
					{
						text: '3 columns',
						menu: [
							{
								text: '[__1/3__][__1/3__][__1/3__]',
								value: '[vc_row]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[____1/2____][_1/4_][_1/4_]',
								value: '[vc_row]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[_1/4_][_1/4_][____1/2____]',
								value: '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[_1/4_][____1/2____][_1/4_]',
								value: '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							}
						]
					},
					{
						text: '4 columns',
						value: '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
						onclick: function() {
							ed.insertContent(this.value());
						}
					}
				]
			});
		},
		createControl : function(n, cm) {
			switch (n) {
				case 'columns':
					var c = cm.createMenuButton('columns', {
						title : 'Add a row with columns',
						image : window.columnsImageUrl+'/columns.png',
						icons : false
					});

					c.onRenderMenu.add(function(c, m) {

						var sub2 = m.addMenu({title : '2 columns', alt: '...'});

						sub2.add({title : '[____1/2____][____1/2____]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub2.add({title : '[__1/3__][______2/3______]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="2/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub2.add({title : '[______2/3______][__1/3__]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="2/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub2.add({title : '[_1/4_][_______3/4_______]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="3/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub2.add({title : '[_______3/4_______][_1/4_]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="3/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});


						var sub3 = m.addMenu({title : '3 columns'});

						sub3.add({title : '[__1/3__][__1/3__][__1/3__]', /*icon: 'columns-one_third-one_third-one_third', */onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub3.add({title : '[____1/2____][_1/4_][_1/4_]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub3.add({title : '[_1/4_][_1/4_][____1/2____]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub3.add({title : '[_1/4_][____1/2____][_1/4_]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						m.add({title : '4 columns', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});
					});

					// Return the new menu button instance
					return c;
			}

			return null;

		}
	});


	tinymce.PluginManager.add('columns', tinymce.plugins.columns);
})();


/**
 * Alert
 */
(function() {
	tinymce.create('tinymce.plugins.alert', {
		init : function(ed, url) {
			ed.addButton('alert', {
				title : 'Add Alert Message',
				image : url+'/alert.png',
				onclick : function () {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Alert',
						identifier: 'alert'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('alert', tinymce.plugins.alert);
})();
/**
 * Tabs
 */
(function() {
	tinymce.create('tinymce.plugins.tabs', {
		init : function(ed, url) {
			ed.addButton('tabs', {
				title : 'Add Tabs',
				image : url+'/tabs.png',
				onclick :  function () {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Tabs',
						identifier: 'tabs'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('tabs', tinymce.plugins.tabs);
})();
/**
 * Accordion
 */
(function() {
	tinymce.create('tinymce.plugins.accordion', {
		init : function(ed, url) {
			ed.addButton('accordion', {
				title : 'Add Accordion',
				image : url+'/accordion.png',
				onclick : function () {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Accordion',
						identifier: 'accordion'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('accordion', tinymce.plugins.accordion);
})();
/**
 * Toggle
 */
(function() {
	tinymce.create('tinymce.plugins.toggle', {
		init : function(ed, url) {
			ed.addButton('toggle', {
				title : 'Add a Toggles',
				image : url+'/toggle.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Toggle',
						identifier: 'toggle'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('toggle', tinymce.plugins.toggle);
})();
/**
 * Youtube
 */
(function() {
	tinymce.create('tinymce.plugins.video', {
		init : function(ed, url) {
			ed.addButton('video', {
				title : 'Add a Video',
				image : url+'/video.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Video',
						identifier: 'video'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('video', tinymce.plugins.video);
})();

/**
 * Team
 */
(function() {
	tinymce.create('tinymce.plugins.team', {
		init : function(ed, url) {
			ed.addButton('team', {
				title : 'Add Team Member',
				image : url+'/team.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Add Team Member',
						identifier: 'member'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('team', tinymce.plugins.team);
})();
/**
 * Button
 */
(function() {
	tinymce.create('tinymce.plugins.button_btn', {
		init : function(ed, url) {
			ed.addButton('button_btn', {
				title : 'Add Button',
				image : url+'/button.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Button',
						identifier: 'button'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('button_btn', tinymce.plugins.button_btn);
})();
/**
 * Section
 */
(function() {
	tinymce.create('tinymce.plugins.section', {
		init : function(ed, url) {
			ed.addButton('section', {
				title : 'Add Section',
				image : url+'/section.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Section',
						identifier: 'section'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('section', tinymce.plugins.section);
})();
/**
 * Separator
 */
(function() {
	tinymce.create('tinymce.plugins.separator_btn', {
		init : function(ed, url) {
			ed.addButton('separator_btn', {
				title : 'Add Separator',
				image : url+'/separator.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Separator',
						identifier: 'separator'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('separator_btn', tinymce.plugins.separator_btn);
})();

/**
 * Icon
 */
(function() {
	tinymce.create('tinymce.plugins.icon', {
		init : function(ed, url) {
			ed.addButton('icon', {
				title : 'Add Icon',
				image : url+'/icon.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Icon',
						identifier: 'icon'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('icon', tinymce.plugins.icon);
})();
/**
 * Iconbox
 */
(function() {
	tinymce.create('tinymce.plugins.iconbox', {
		init : function(ed, url) {
			ed.addButton('iconbox', {
				title : 'Add Iconbox',
				image : url+'/iconbox.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'IconBox',
						identifier: 'iconbox'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('iconbox', tinymce.plugins.iconbox);
})();
/**
 * Testimonial
 */
(function() {
	tinymce.create('tinymce.plugins.testimonial', {
		init : function(ed, url) {
			ed.addButton('testimonial', {
				title : 'Add Testimonial',
				image : url+'/testimonial.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Testimonial',
						identifier: 'testimonial'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('testimonial', tinymce.plugins.testimonial);
})();
/**
 * Services
 */
(function() {
	tinymce.create('tinymce.plugins.services', {
		init : function(ed, url) {
			ed.addButton('services', {
				title : 'Add Services',
				image : url+'/services.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Services',
						identifier: 'services'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('services', tinymce.plugins.services);
})();

/**
 * Timeline
 */
(function() {
	tinymce.create('tinymce.plugins.timeline', {
		init : function(ed, url) {
			ed.addButton('timeline', {
				title : 'Add Timeline',
				image : url+'/timeline.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Timeline',
						identifier: 'timeline'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('timeline', tinymce.plugins.timeline);
})();

/**
 * Recent Works
 */
(function() {
	tinymce.create('tinymce.plugins.portfolio', {
		init : function(ed, url) {
			ed.addButton('portfolio', {
				title : 'Add Portfolio',
				image : url+'/projects.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Portfolio',
						identifier: 'portfolio'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('portfolio', tinymce.plugins.portfolio);
})();

/**
 * Latest Posts
 */
(function() {
	tinymce.create('tinymce.plugins.latest_posts', {
		init : function(ed, url) {
			ed.addButton('latest_posts', {
				title : 'Add Latest Posts',
				image : url+'/latest_posts.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Latest Posts',
						identifier: 'latest_posts'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('latest_posts', tinymce.plugins.latest_posts);
})();

/**
 * Clients
 */
(function() {
	tinymce.create('tinymce.plugins.clients', {
		init : function(ed, url) {
			ed.addButton('clients', {
				title : 'Add Client Logos',
				image : url+'/clients.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Clients',
						identifier: 'clients'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('clients', tinymce.plugins.clients);
})();

/**
 * Actionbox
 */
(function() {
	tinymce.create('tinymce.plugins.actionbox', {
		init : function(ed, url) {
			ed.addButton('actionbox', {
				title : 'Add ActionBox',
				image : url+'/actionbox.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'ActionBox',
						identifier: 'actionbox'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('actionbox', tinymce.plugins.actionbox);
})();

/**
 * Callout
 */
(function() {
	tinymce.create('tinymce.plugins.callout', {
		init : function(ed, url) {
			ed.addButton('callout', {
				title : 'Add Callout',
				image : url+'/callout.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Callout',
						identifier: 'callout'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('callout', tinymce.plugins.callout);
})();

/**
 * Animate
 */
(function() {
	tinymce.create('tinymce.plugins.animate', {
		init : function(ed, url) {
			ed.addButton('animate', {
				title : 'Add Animation',
				image : url+'/animation.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Animation',
						identifier: 'animate'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('animate', tinymce.plugins.animate);
})();



/**
 * Gallery
 */
(function() {
	tinymce.create('tinymce.plugins.gallery', {
		init : function(ed, url) {
			ed.addButton('gallery', {
				title : 'Add Gallery',
				image : url+'/gallery.png',
				onclick : function() {
					ed.selection.setContent('[gallery type="xs, s, m, l or masonry" include=""]');

				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('gallery', tinymce.plugins.gallery);
})();

/**
 * Pricing Table
 */
(function() {
	tinymce.create('tinymce.plugins.pricing_table', {
		init : function(ed, url) {
			ed.addButton('pricing_table', {
				title : 'Add Pricing Table',
				image : url+'/pricing.png',
				onclick : function() {
					ed.selection.setContent('[pricing_table]<br>[pricing_column title="Standard" type="" price="$10" time="per month"]<br>[pricing_row]Feature 1[/pricing_row]<br>[pricing_row]Feature 2[/pricing_row]<br>[pricing_footer url="" type="default" size="" outlined="0"]Signup[/pricing_footer]<br>[/pricing_column]<br><br>[pricing_column title="Business" type="featured" price="$20" time="per month"]<br>[pricing_row]Feature 1[/pricing_row]<br>[pricing_row]Feature 2[/pricing_row]<br>[pricing_footer url="" type="primary" size="" outlined="1"]Signup[/pricing_footer]<br>[/pricing_column]<br>[/pricing_table]');

				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('pricing_table', tinymce.plugins.pricing_table);
})();

/**
 * Contact Form
 */
(function() {
	tinymce.create('tinymce.plugins.contact_form', {
		init : function(ed, url) {
			ed.addButton('contact_form', {
				title : 'Add Contact Form',
				image : url+'/form.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Contact Form',
						identifier: 'contact_form'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('contact_form', tinymce.plugins.contact_form);
})();

/**
 * Social Links
 */
(function() {
	tinymce.create('tinymce.plugins.social_links', {
		init : function(ed, url) {
			ed.addButton('social_links', {
				title : 'Social Links',
				image : url+'/social.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Social Links',
						identifier: 'social_links'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('social_links', tinymce.plugins.social_links);
})();

/**
 * Contacts
 */
(function() {
	tinymce.create('tinymce.plugins.contacts', {
		init : function(ed, url) {
			ed.addButton('contacts', {
				title : 'Add Contacts',
				image : url+'/contact.png',
				onclick : function () {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Contacts',
						identifier: 'contacts'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('contacts', tinymce.plugins.contacts);
})();

/**
 * Slider Revolution
 */
(function() {
	tinymce.create('tinymce.plugins.rev_slider', {
		init : function(ed, url) {
			ed.addButton('rev_slider', {
				title : 'Add Slider Revolution',
				image : url+'/slider.png',
				onclick : function () {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Slider Revolution',
						identifier: 'rev_slider'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('rev_slider', tinymce.plugins.rev_slider);
})();

/**
 * Google Maps
 */
(function() {
	tinymce.create('tinymce.plugins.gmaps', {
		init : function(ed, url) {
			ed.addButton('gmaps', {
				title : 'Add Google Maps',
				image : url+'/map.png',
				onclick : function () {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Google Maps',
						identifier: 'gmaps'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('gmaps', tinymce.plugins.gmaps);
})();

/**
 * Counter
 */
(function() {
	tinymce.create('tinymce.plugins.counter', {
		init : function(ed, url) {
			ed.addButton('counter', {
				title : 'Add a Counter',
				image : url+'/counter.png',
				onclick : function() {
					tinyMCE.activeEditor.execCommand("us_zillaPopup", false, {
						title: 'Counter',
						identifier: 'counter'
					});
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('counter', tinymce.plugins.counter);
})();
