<?php
/**
 * ThemeREX Addons Third-party plugins API
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.29
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Define list with api
if (!function_exists('trx_addons_api_load')) {
	add_action( 'after_setup_theme', 'trx_addons_api_load', 2 );
	function trx_addons_api_load() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['api_list'] = apply_filters('trx_addons_api_list', array(
			
			'bbpress' => array(
							'title' => __('BB Press & Buddy Press', 'trx_addons')
						),
			'booked' => array(
							'title' => __('Booked Appointments', 'trx_addons')
						),
			'calculated-fields-form' => array(
							'title' => __('Calculated Fields Form', 'trx_addons')
						),
			'contact-form-7' => array(
							'title' => __('Contact Form 7', 'trx_addons')
						),
			'content_timeline' => array(
							'title' => __('Content Timeline', 'trx_addons')
						),
			'easy-digital-downloads' => array(
							'title' => __('Easy Digital Downloads', 'trx_addons')
						),
            'elegro-payment' => array(
                            'title' => __('Essential Grid', 'trx_addons')
                        ),
			'essential-grid' => array(
							'title' => __('Essential Grid', 'trx_addons')
						),
			'instagram-feed' => array(
							'title' => __('Instagram Feed', 'trx_addons')
						),
			'mailchimp-for-wp' => array(
							'title' => __('MailChimp for WordPress', 'trx_addons')
						),
			'mp-timetable' => array(
							'title' => __('MP TimeTable', 'trx_addons')
						),
			'revslider' => array(
							'title' => __('Revolution Slider', 'trx_addons')
						),
			'siteorigin-panels' => array(
							'title' => __('SiteOrigin Panels (free PageBuilder)', 'trx_addons'),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'the-events-calendar' => array(
							'title' => __('The Events Calendar', 'trx_addons'),
							'layouts_sc' => array(
								'default'	=> esc_html__('Default', 'trx_addons'),
								'detailed'	=> esc_html__('Detailed', 'trx_addons')
							)
						),
			'tourmaster' => array(
							'title' => __('Tour Master', 'trx_addons')
						),
			'trx_donations' => array(
							'title' => __('ThemeREX Donations', 'trx_addons')
						),
			'twitter' => array(
							'title' => __('Twitter', 'trx_addons'),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'ubermenu' => array(
							'title' => __('UberMenu', 'trx_addons')
						),
			'js_composer' => array(
							'title' => __('WPBakery Page Builder', 'trx_addons'),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'vc-extensions-bundle' => array(
							'title' => __('VC Extensions Bundle', 'trx_addons')
						),
			'woocommerce' => array(
							'title' => __('WooCommerce', 'trx_addons')
						),
            'yith-woocommerce-wishlist' => array(
                            'title' => __('YITH WooCommerce Wishlist', 'trx_addons')
                        ),
			'sitepress-multilingual-cms' => array(
							'title' => __('WPML - Sitepress Multilingual CMS', 'trx_addons')
						),
			)
		);
		if (is_array($TRX_ADDONS_STORAGE['api_list']) && count($TRX_ADDONS_STORAGE['api_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['api_list'] as $w=>$params) {
				if (empty($params['preloaded']) && trx_addons_components_is_allowed('api', $w)
					&& ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_API . "{$w}/{$w}.php")) != '') { 
					include_once $fdir;
				}
			}
		}
	}
}


// Add 'Third-party API' block in the ThemeREX Addons Components
if (!function_exists('trx_addons_api_components')) {
	add_filter( 'trx_addons_filter_components_blocks', 'trx_addons_api_components');
	function trx_addons_api_components($blocks=array()) {
		$blocks['api'] = __('Third-party plugins API', 'trx_addons');
		return $blocks;
	}
}


//-----------------------------------------------------------------------------------
//-- CHECK FOR COMPONENTS EXISTS
//--  Attention! This functions are used in many files and must be declared here!!!
//-----------------------------------------------------------------------------------

// Check if plugin 'WPBakery Page Builder' is installed and activated
if ( !function_exists( 'trx_addons_exists_visual_composer' ) ) {
	function trx_addons_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if plugin 'SiteOrigin Panels' is installed and activated
if ( !function_exists( 'trx_addons_exists_sop' ) ) {
	function trx_addons_exists_sop() {
		return class_exists('SiteOrigin_Panels');
	}
}

// Check if any PageBuilder is installed and activated
if ( !function_exists( 'trx_addons_exists_page_builder' ) ) {
	function trx_addons_exists_page_builder() {
		return trx_addons_exists_visual_composer() || trx_addons_exists_sop();
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'trx_addons_exists_revslider' ) ) {
	function trx_addons_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_woocommerce' ) ) {
	function trx_addons_exists_woocommerce() {
		return class_exists('Woocommerce');
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_edd' ) ) {
	function trx_addons_exists_edd() {
		return class_exists('Easy_Digital_Downloads');
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_wpml' ) ) {
	function trx_addons_exists_wpml() {
		return defined('ICL_SITEPRESS_VERSION') && class_exists('sitepress');
	}
}
?>