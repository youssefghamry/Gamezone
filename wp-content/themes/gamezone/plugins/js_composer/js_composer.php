<?php
/* WPBakery Page Builder support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('gamezone_vc_theme_setup9')) {
	add_action( 'after_setup_theme', 'gamezone_vc_theme_setup9', 9 );
	function gamezone_vc_theme_setup9() {
		
		add_filter( 'gamezone_filter_merge_styles',		'gamezone_vc_merge_styles' );

		if (gamezone_exists_visual_composer()) {
	
			// Add/Remove params in the standard VC shortcodes
			//-----------------------------------------------------
			add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,	'gamezone_vc_add_params_classes', 10, 3 );
			add_filter( 'vc_iconpicker-type-fontawesome',	'gamezone_vc_iconpicker_type_fontawesome' );
			
			// Color scheme
			$scheme = array(
				"param_name" => "scheme",
				"heading" => esc_html__("Color scheme", 'gamezone'),
				"description" => wp_kses_data( __("Select color scheme to decorate this block", 'gamezone') ),
				"group" => esc_html__('Colors', 'gamezone'),
				"admin_label" => true,
				"value" => array_flip(gamezone_get_list_schemes(true)),
				"type" => "dropdown"
			);
			$sc_list = apply_filters('gamezone_filter_add_scheme_in_vc', array('vc_section', 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text'));
			foreach ($sc_list as $sc)
				vc_add_param($sc, $scheme);

			// Alter height and hide on mobile for Empty Space
			vc_add_param("vc_empty_space", array(
				"param_name" => "alter_height",
				"heading" => esc_html__("Alter height", 'gamezone'),
				"description" => wp_kses_data( __("Select alternative height instead value from the field above", 'gamezone') ),
				"admin_label" => true,
				"value" => array(
					esc_html__('Tiny', 'gamezone') => 'tiny',
					esc_html__('Small', 'gamezone') => 'small',
					esc_html__('Medium', 'gamezone') => 'medium',
					esc_html__('Large', 'gamezone') => 'large',
					esc_html__('Huge', 'gamezone') => 'huge',
					esc_html__('From the value above', 'gamezone') => 'none'
				),
				"type" => "dropdown"
			));
			
			// Add Narrow style to the Progress bars
			vc_add_param("vc_progress_bar", array(
				"param_name" => "narrow",
				"heading" => esc_html__("Narrow", 'gamezone'),
				"description" => wp_kses_data( __("Use narrow style for the progress bar", 'gamezone') ),
				"std" => 0,
				"value" => array(esc_html__("Narrow style", 'gamezone') => "1" ),
				"type" => "checkbox"
			));
			
			// Add param 'Closeable' to the Message Box
			vc_add_param("vc_message", array(
				"param_name" => "closeable",
				"heading" => esc_html__("Closeable", 'gamezone'),
				"description" => wp_kses_data( __("Add 'Close' button to the message box", 'gamezone') ),
				"std" => 0,
				"value" => array(esc_html__("Closeable", 'gamezone') => "1" ),
				"type" => "checkbox"
			));
		}
		if (is_admin()) {
			add_filter( 'gamezone_filter_tgmpa_required_plugins', 'gamezone_vc_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'gamezone_vc_tgmpa_required_plugins' ) ) {
	
	function gamezone_vc_tgmpa_required_plugins($list=array()) {
		if (gamezone_storage_isset('required_plugins', 'js_composer')) {
			$path = gamezone_get_file_dir('plugins/js_composer/js_composer.zip');
			if (!empty($path) || gamezone_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> gamezone_storage_get_array('required_plugins', 'js_composer'),
					'slug' 		=> 'js_composer',
                    'version'   => '6.9.0',
					'source'	=> !empty($path) ? $path : 'upload://js_composer.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if WPBakery Page Builder installed and activated
if ( !function_exists( 'gamezone_exists_visual_composer' ) ) {
	function gamezone_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery Page Builder in frontend editor mode
if ( !function_exists( 'gamezone_vc_is_frontend' ) ) {
	function gamezone_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}
	
// Merge custom styles
if ( !function_exists( 'gamezone_vc_merge_styles' ) ) {
	
	function gamezone_vc_merge_styles($list) {
		if (gamezone_exists_visual_composer()) {
			$list[] = 'plugins/js_composer/_js_composer.scss';
		}
		return $list;
	}
}
	
// Add theme icons to the VC iconpicker list
if ( !function_exists( 'gamezone_vc_iconpicker_type_fontawesome' ) ) {
	
	function gamezone_vc_iconpicker_type_fontawesome($icons) {
		$list = gamezone_get_list_icons();
		if (!is_array($list) || count($list) == 0) return $icons;
		$rez = array();
		foreach ($list as $icon)
			$rez[] = array($icon => str_replace('icon-', '', $icon));
		return array_merge( $icons, array(esc_html__('Theme Icons', 'gamezone') => $rez) );
	}
}



// Shortcodes support
//------------------------------------------------------------------------

// Add params to the standard VC shortcodes
if ( !function_exists( 'gamezone_vc_add_params_classes' ) ) {
	
	function gamezone_vc_add_params_classes($classes, $sc, $atts) {
		// Add color scheme
		if (in_array($sc, apply_filters('gamezone_filter_add_scheme_in_vc', array('vc_section', 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text')))) {
			if (!empty($atts['scheme']) && !gamezone_is_inherit($atts['scheme']))
				$classes .= ($classes ? ' ' : '') . 'scheme_' . $atts['scheme'];
		}
		// Add other specific classes
		if (in_array($sc, array('vc_empty_space'))) {
			if (!empty($atts['alter_height']) && !gamezone_is_off($atts['alter_height']))
				$classes .= ($classes ? ' ' : '') . 'height_' . $atts['alter_height'];
		} else if (in_array($sc, array('vc_progress_bar'))) {
			if (!empty($atts['narrow']) && (int) $atts['narrow']==1)
				$classes .= ($classes ? ' ' : '') . 'vc_progress_bar_narrow';
		} else if (in_array($sc, array('vc_message'))) {
			if (!empty($atts['closeable']) && (int) $atts['closeable']==1)
				$classes .= ($classes ? ' ' : '') . 'vc_message_box_closeable';
		}
		return $classes;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (gamezone_exists_visual_composer()) { require_once GAMEZONE_THEME_DIR . 'plugins/js_composer/js_composer-styles.php'; }
?>