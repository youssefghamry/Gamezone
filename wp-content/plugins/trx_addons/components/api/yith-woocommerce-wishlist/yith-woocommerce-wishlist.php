<?php
/**
 * Plugin support: WooCommerce
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if plugin installed and activated
// Attention! This function is used in many files and was moved to the api.php

if ( !function_exists( 'trx_addons_exists_yith_wcwl_wishlist' ) ) {
	function trx_addons_exists_yith_wcwl_wishlist() {
        return defined( 'YITH_WCWL' );
	}
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_yith_wcwl_wishlist_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_yith_wcwl_wishlist_importer_required_plugins', 10, 2 );
	function trx_addons_yith_wcwl_wishlist_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'yith-woocommerce-wishlist')!==false && !trx_addons_exists_yith_wcwl_wishlist() )
			$not_installed .= '<br>' . esc_html__('YITH WooCommerce Wishlist', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_yith_wcwl_wishlist_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_yith_wcwl_wishlist_importer_set_options' );
	function trx_addons_yith_wcwl_wishlist_importer_set_options($options=array()) {
        file_put_contents('test.txt', in_array('yith-woocommerce-wishlist', $options['required_plugins']));
        if ( trx_addons_exists_yith_wcwl_wishlist() && in_array('yith-woocommerce-wishlist', $options['required_plugins']) ) {
            $options['additional_options'][]    = 'yith_%';                    // Add slugs to export options for this plugin

            if (is_array($options['files']) && count($options['files']) > 0) {
                foreach ($options['files'] as $k => $v) {
                    $options['files'][$k]['file_with_yith-woocommerce-wishlist'] = str_replace('name.ext', 'yith-woocommerce-wishlist.txt', $v['file_with_']);
                }
            }
        }
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_yith_wcwl_wishlist_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_yith_wcwl_wishlist_importer_show_params', 10, 1 );
	function trx_addons_yith_wcwl_wishlist_importer_show_params($importer) {
		if ( trx_addons_exists_yith_wcwl_wishlist() && in_array('yith-woocommerce-wishlist', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'yith-woocommerce-wishlist',
				'title' => esc_html__('Import YITH WooCommerce Wishlist', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_yith_wcwl_wishlist_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_yith_wcwl_wishlist_importer_import_fields', 10, 1 );
	function trx_addons_yith_wcwl_wishlist_importer_import_fields($importer) {
		if ( trx_addons_exists_yith_wcwl_wishlist() && in_array('yith-woocommerce-wishlist', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'yith-woocommerce-wishlist',
				'title' => esc_html__('YITH WooCommerce Wishlist', 'trx_addons')
				)
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_yith_wcwl_wishlist_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_yith_wcwl_wishlist_importer_export_fields', 10, 1 );
	function trx_addons_yith_wcwl_wishlist_importer_export_fields($importer) {
		if ( trx_addons_exists_yith_wcwl_wishlist() && in_array('yith-woocommerce-wishlist', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'yith-woocommerce-wishlist',
				'title' => esc_html__('YITH WooCommerce Wishlist', 'trx_addons')
				)
			);
		}
	}
}
?>