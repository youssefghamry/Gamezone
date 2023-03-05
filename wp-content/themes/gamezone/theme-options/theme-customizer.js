/* global gamezone_color_schemes, gamezone_dependencies, Color */

/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {

	"use strict";
	
	var cssTemplate = {},
		updateCSS = true,
		htmlEncoder = document.createElement('div');

	// Add Templates with color schemes
	for (var i in gamezone_color_schemes) {
		cssTemplate[i] = wp.template( 'gamezone-color-scheme-'+i );
	}
	// Add Template with theme fonts
	cssTemplate['theme_fonts'] = wp.template( 'gamezone-fonts' );
	
	// Set initial state of controls
	api.bind('ready', function() {

		// Add 'reset' button
		jQuery('#customize-header-actions #save').before('<input type="button" class="button customize-action-reset" value="'+gamezone_customizer_vars['msg_reset']+'">');
		jQuery('#customize-header-actions .customize-action-reset').on('click', function(e) {
			if (confirm(gamezone_customizer_vars['msg_reset_confirm'])) {
				api('reset_options').set(1);
				jQuery('#customize-header-actions #save').removeAttr('disabled').trigger('click');
				setTimeout(function() { location.reload(true); }, 1000);
			}
		});

		// Add 'Refresh' button
		jQuery('#customize-header-actions .spinner').after('<button class="button customize-action-refresh icon-spin3"></button>');
		jQuery('#customize-header-actions .customize-action-refresh').on('click', function(e) {
			api.previewer.send( 'refresh-preview' );
			setTimeout(function() { api.previewer.refresh(); }, 500);
			e.preventDefault();
			return false;
		});

		// Add suffix after the theme's name
		if (gamezone_customizer_vars && gamezone_customizer_vars['theme_name_suffix'])
			jQuery('#customize-info .site-title').append(gamezone_customizer_vars['theme_name_suffix']);

		// Blur the "load fonts" fields - regenerate options lists in the font-family controls
		jQuery('#customize-theme-controls [id^="customize-control-load_fonts"]').on('focusout', gamezone_customizer_update_load_fonts);		

		// Click on the actions button
		jQuery('#customize-theme-controls .control-section .customize-control-button input[type="button"]').on('click', gamezone_customizer_actions);

		// Check dependencies in the each section on ready
		jQuery('#customize-theme-controls .control-section').each(function () {
			gamezone_customizer_check_dependencies(jQuery(this));
		});

		// Check dependencies in the each section before open (for dinamically created sections)
		jQuery('#customize-theme-controls .control-section > .accordion-section-title').on('click', function() {
			var id = jQuery(this).parent().attr('aria-owns');
			if (id!='') {
				var section = jQuery('#'+id);
				if (section.length > 0) gamezone_customizer_check_dependencies(section);
			}
		});
		
	});
	
	// On change any control - check for dependencies
	api.bind('change', function(obj) {
		gamezone_customizer_check_dependencies(jQuery('#customize-theme-controls #customize-control-'+obj.id).parents('.control-section'));
		gamezone_customizer_refresh_preview(obj);
	});

	// Return value of the control
	function gamezone_customizer_get_field_value(fld) {
		var ctrl = fld.parents('.customize-control');
		var val = fld.attr('type')=='checkbox' || fld.attr('type')=='radio' 
					? (ctrl.find('[data-customize-setting-link]:checked').length > 0
						? (ctrl.find('[data-customize-setting-link]:checked').val()!=''
							&& ''+ctrl.find('[data-customize-setting-link]:checked').val()!='0'
								? ctrl.find('[data-customize-setting-link]:checked').val()
								: 1
							)
						: 0
						)
					: fld.val();
		if (val===undefined || val===null) val = '';
		return val;
	}
	
	// Check for dependencies
	function gamezone_customizer_check_dependencies(cont) {
		cont.find('.customize-control').each(function() {
			var ctrl = jQuery(this), id = ctrl.attr('id');
			if (id == undefined) return;
			id = id.replace('customize-control-', '');
			var fld=null, val='', i;
			var depend = false;
			for (fld in gamezone_dependencies) {
				if (fld == id) {
					depend = gamezone_dependencies[id];
					break;
				}
			}
			if (depend) {
				var dep_cnt = 0, dep_all = 0;
				var dep_cmp = typeof depend.compare != 'undefined' ? depend.compare.toLowerCase() : 'and';
				var dep_strict = typeof depend.strict != 'undefined';
				for (i in depend) {
					if (i == 'compare' || i == 'strict') continue;
					dep_all++;
					fld = cont.find('[data-customize-setting-link="'+i+'"]');
					if (fld.length > 0) {
						val = gamezone_customizer_get_field_value(fld);
						for (var j in depend[i]) {
							if ( 
								   (depend[i][j]=='not_empty' && val!='') 	// Main field value is not empty - show current field
								|| (depend[i][j]=='is_empty' && val=='')	// Main field value is empty - show current field
								|| (val!=='' && (!isNaN(depend[i][j]) 		// Main field value equal to specified value - show current field
													? val==depend[i][j]
													: (dep_strict 
															? val==depend[i][j]
															: (''+val).indexOf(depend[i][j])==0
														)
												)
									)
								|| (val!='' && (''+depend[i][j]).charAt(0)=='^' && (''+val).indexOf(depend[i][j].substr(1))==-1)	// Main field value not equal to specified value - show current field
							) {
								dep_cnt++;
								break;
							}
						}
					} else
						dep_all--;
					if (dep_cnt > 0 && dep_cmp == 'or')
						break;
				}
				if ((dep_cnt > 0 && dep_cmp == 'or') || (dep_cnt == dep_all && dep_cmp == 'and')) {
					ctrl.show().removeClass('gamezone_options_no_use');
				} else {
					ctrl.hide().addClass('gamezone_options_no_use');
				}
			}
			// Individual dependencies
			//------------------------------------
			if (id == 'color_scheme') {		// Disable color schemes less then main scheme!
				fld = ctrl.find('[data-customize-setting-link="'+id+'"]');
				if (fld.length > 0) {
					val = gamezone_customizer_get_field_value(fld);
					var num = 0;
					for (i in gamezone_color_schemes) {
						num++;
						if (i == val) break;
					}
					cont.find('.customize-control').each(function() {
						var ctrl2 = jQuery(this), id2 = ctrl2.attr('id');
						if (id2 == undefined) return;
						id2 = id2.replace('customize-control-', '');
						if (id2 == id || id2.substr(-7)!='_scheme') return;
						var fld2 = ctrl2.find('[data-customize-setting-link="'+id2+'"]');
						if (fld2.attr('type')!='radio') fld2 = fld2.find('option');
						fld2.each(function(idx2) {
							var dom_obj = jQuery(this).get(0);
							dom_obj.disabled = idx2 != 0 && idx2 < num;
							if (dom_obj.disabled) {
								if (jQuery(this).val()==api(id2)()) {
									api(id2).set('inherit');
								}
							}
						});
					});
				}
			}
		});
	}

	// Refresh preview area on change any control
	function gamezone_customizer_refresh_preview(obj) {
		var id = obj.id, val = obj(), opt = '', rule = '';
		if (obj.transport!='postMessage' && id.indexOf('load_fonts-')==-1) return;
		var processed = false;

		// Update the CSS whenever a color setting is changed.
		if (updateCSS) {
			// Any color in the scheme_storage is changed
			if (id == 'scheme_storage') {
				processed = true;

			// If section Front page section 'About' need page content - refresh preview area
			} else if (id == 'front_page_about_content' && val.indexOf('%%CONTENT%%') >= 0) {
				api.previewer.send( 'refresh-preview' );
				setTimeout(function() { api.previewer.refresh(); }, 500);
				processed = true;

			// Any theme fonts parameter is changed
			} else {
				for (opt in gamezone_theme_fonts) {
					for (rule in gamezone_theme_fonts[opt]) {
						if (opt+'_'+rule == id) {
							// Store new value in the color table
							gamezone_customizer_update_theme_fonts(opt, rule, val);
							processed = true;
							break;
						}
					}
					if (processed) break;
				}
			}
			// Refresh CSS
			if (processed) gamezone_customizer_update_css();
		}
		// If not catch change above - send message to previewer
		if (!processed) {
			api.previewer.send( 'refresh-other-controls', {id: id, value: val} );
		}
	}
	
	// Actions buttons
	function gamezone_customizer_actions(e) {
		var action = jQuery(this).data('action');
		if (action == 'refresh') {
			api.previewer.send( 'refresh-preview' );
			setTimeout(function() { api.previewer.refresh(); }, 500);
		}
	}

	
	// Store new value in the theme fonts
	function gamezone_customizer_update_theme_fonts(opt, rule, value) {
		gamezone_theme_fonts[opt][rule] = value;
	}
	
	// Change theme fonts options if load fonts is changed
	function gamezone_customizer_update_load_fonts() {
		var opt_list=[], i, tag, sel, opt, name='', family='', val='', new_val = '', sel_idx = 0;
		updateCSS = false;
		for (i=1; i <= gamezone_customizer_vars['max_load_fonts']; i++) {
			name = api('load_fonts-'+i+'-name')();
			if (name == '') continue;
			family = api('load_fonts-'+i+'-family')();
			opt_list.push([name, family]);
		}
		for (tag in gamezone_theme_fonts) {
			sel = api.control( tag+'_font-family' ).container.find( 'select' );
			if (sel.length == 1) {
				opt = sel.find('option');
				sel_idx = sel.find(':selected').index();
				new_val = '';
				for (i=0; i < opt_list.length; i++) {
					val = '"'+opt_list[i][0]+'"'+(opt_list[i][1]!='inherit' ? ','+opt_list[i][1] : '');
					if (sel_idx-1 == i) new_val = val;
					opt.eq(i+1).val(val).text(opt_list[i][0]);
				}
				if (opt_list.length < opt.length-1) {
					for (i=opt.length-1; i > opt_list.length; i--) {
						opt.eq(i).remove();
					}
				}
				api(tag+'_font-family').set(sel_idx > 0 && sel_idx <= opt_list.length && new_val ? new_val : 'inherit');
			}
		}
		updateCSS = true;
	}

	
	// Generate the CSS for the current Color Scheme and send it to the preview window
	function gamezone_customizer_update_css() {

		if (!updateCSS) return;
	
		var css = '';
		
		// Make theme specific fonts rules
		var fonts = gamezone_customizer_add_theme_fonts(gamezone_theme_fonts);

		// Make styles and add into css
		css += gamezone_customizer_prepare_html_value(cssTemplate['theme_fonts']( fonts ));

		// Add colors
		for (var scheme in gamezone_color_schemes) {
			
			var i, colors = [];
			
			// Copy all colors!
			for (i in gamezone_color_schemes[scheme].colors) {
				colors[i] = gamezone_color_schemes[scheme].colors[i];
			}
			
			// Make theme specific colors and tints
			colors = gamezone_customizer_add_theme_colors(colors);

			// This way work correctly in any browser
            var tmpl = jQuery( '#tmpl-gamezone-color-scheme-' + scheme ).html().trim();
            for (i in colors) {
                var regex = new RegExp("{{ data\." + i +" }}", "g");
                tmpl = tmpl.replace(regex, colors[i]);
            }
            css += tmpl;
		}
		api.previewer.send( 'refresh-color-scheme-css', css );
	}

	// Additional (calculated) theme-specific colors
	function gamezone_customizer_add_theme_colors(colors) {
		if (gamezone_additional_colors) {
			var clr = '', v = '';
			for (var k in gamezone_additional_colors) {
				v = gamezone_additional_colors[k];
				clr = colors[v['color']];
				if (typeof v['hue'] != 'undefined' || typeof v['saturation'] != 'undefined' || typeof v['brightness'] != 'undefined') {
					clr = gamezone_hsb2hex(gamezone_hex2hsb(clr,
															typeof v['hue'] != 'undefined' ? v['hue'] : 0,
															typeof v['saturation'] != 'undefined' ? v['saturation'] : 0,
															typeof v['brightness'] != 'undefined' ? v['brightness'] : 0
															));
				}
				if (typeof v['alpha'] != 'undefined') {
					clr = Color(clr).toCSS('rgba', v['alpha']);
				}
				colors[k] = clr;
			}
		}
		return colors;
	}

	// Add custom theme fonts rules
	function gamezone_customizer_add_theme_fonts(fonts) {
		var rez = [];
		for (var tag in fonts) {
			rez[tag+'_font-family'] = typeof fonts[tag]['font-family'] != 'undefined' 
									&& fonts[tag]['font-family'] != '' 
									&& fonts[tag]['font-family'] != 'inherit'
												? 'font-family:' + fonts[tag]['font-family'] + ';' 
												: '';
			rez[tag+'_font-size'] = typeof fonts[tag]['font-size'] != 'undefined' 
									&& fonts[tag]['font-size'] != 'inherit'
												? 'font-size:' + gamezone_customizer_prepare_css_value(fonts[tag]['font-size']) + ";"
												: '';
			rez[tag+'_line-height'] = typeof fonts[tag]['line-height'] != 'undefined' 
									&& fonts[tag]['line-height'] != '' 
									&& fonts[tag]['line-height'] != 'inherit'
												? 'line-height:' + fonts[tag]['line-height'] + ";"
												: '';
			rez[tag+'_font-weight'] = typeof fonts[tag]['font-weight'] != 'undefined' 
									&& fonts[tag]['font-weight'] != '' 
									&& fonts[tag]['font-weight'] != 'inherit'
												? 'font-weight:' + fonts[tag]['font-weight'] + ";"
												: '';
			rez[tag+'_font-style'] = typeof fonts[tag]['font-style'] != 'undefined' 
									&& fonts[tag]['font-style'] != '' 
									&& fonts[tag]['font-style'] != 'inherit'
												? 'font-style:' + fonts[tag]['font-style'] + ";"
												: '';
			rez[tag+'_text-decoration'] = typeof fonts[tag]['text-decoration'] != 'undefined' 
									&& fonts[tag]['text-decoration'] != '' 
									&& fonts[tag]['text-decoration'] != 'inherit'
												? 'text-decoration:' + fonts[tag]['text-decoration'] + ";"
												: '';
			rez[tag+'_text-transform'] = typeof fonts[tag]['text-transform'] != 'undefined' 
									&& fonts[tag]['text-transform'] != '' 
									&& fonts[tag]['text-transform'] != 'inherit'
												? 'text-transform:' + fonts[tag]['text-transform'] + ";"
												: '';
			rez[tag+'_letter-spacing'] = typeof fonts[tag]['letter-spacing'] != 'undefined' 
									&& fonts[tag]['letter-spacing'] != '' 
									&& fonts[tag]['letter-spacing'] != 'inherit'
												? 'letter-spacing:' + fonts[tag]['letter-spacing'] + ";"
												: '';
			rez[tag+'_margin-top'] = typeof fonts[tag]['margin-top'] != 'undefined' 
									&& fonts[tag]['margin-top'] != '' 
									&& fonts[tag]['margin-top'] != 'inherit'
												? 'margin-top:' + gamezone_customizer_prepare_css_value(fonts[tag]['margin-top']) + ";"
												: '';
			rez[tag+'_margin-bottom'] = typeof fonts[tag]['margin-bottom'] != 'undefined' 
									&& fonts[tag]['margin-bottom'] != '' 
									&& fonts[tag]['margin-bottom'] != 'inherit'
												? 'margin-bottom:' + gamezone_customizer_prepare_css_value(fonts[tag]['margin-bottom']) + ";"
												: '';
		}
		return rez;
	}
	
	// Add ed to css value
	function gamezone_customizer_prepare_css_value(val) {
		if (val != '' && val != 'inherit') {
			var ed = val.substr(-1);
			if ('0'<=ed && ed<='9') val += 'px';
		}
		return val;
	}
	
	// Convert HTML entities in the css value
	function gamezone_customizer_prepare_html_value(val) {
		return val.replace(/\&quot\;/g, '"');
	}

} )( wp.customize );
