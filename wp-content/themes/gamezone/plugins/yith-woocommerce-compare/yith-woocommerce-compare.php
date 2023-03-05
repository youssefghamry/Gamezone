<?php

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'gamezone_yith_wcwl_compare_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'gamezone_yith_wcwl_compare_theme_setup9', 9 );
    function gamezone_yith_wcwl_compare_theme_setup9() {
        if ( is_admin() ) {
            add_filter( 'gamezone_filter_tgmpa_required_plugins', 'gamezone_yith_wcwl_compare_tgmpa_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( ! function_exists( 'gamezone_yith_wcwl_compare_tgmpa_required_plugins' ) ) {
    
    function gamezone_yith_wcwl_compare_tgmpa_required_plugins( $list = array() ) {
        if ( gamezone_storage_isset( 'required_plugins', 'yith-woocommerce-compare' )) {
            $list[] = array(
                'name'     => gamezone_storage_get_array( 'required_plugins', 'yith-woocommerce-compare' ),
                'slug'     => 'yith-woocommerce-compare',
                'required' => false,
            );
        }
        return $list;
    }
}

// Check if plugin installed and activated
if ( ! function_exists( 'gamezone_exists_yith_wcwl_compare' ) ) {
    function gamezone_exists_yith_wcwl_compare() {
        return defined( 'YITH_WOOCOMPARE_VERSION' );
    }
}
