<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'gamezone_trx_updater_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'gamezone_trx_updater_theme_setup9', 9 );
    function gamezone_trx_updater_theme_setup9() {
        if ( is_admin() ) {
            add_filter( 'gamezone_filter_tgmpa_required_plugins', 'gamezone_trx_updater_tgmpa_required_plugins', 8 );
        }
    }
}


// Filter to add in the required plugins list
if ( ! function_exists( 'gamezone_trx_updater_tgmpa_required_plugins' ) ) {
    
    function gamezone_trx_updater_tgmpa_required_plugins( $list = array() ) {
        if ( gamezone_storage_isset( 'required_plugins', 'trx_updater' ) ) {
            $path = gamezone_get_file_dir( 'plugins/trx_updater/trx_updater.zip' );
            if ( ! empty( $path ) || gamezone_get_theme_setting( 'tgmpa_upload' ) ) {
                $list[] = array(
                    'name'     => gamezone_storage_get_array( 'required_plugins', 'trx_updater' ),
                    'slug'     => 'trx_updater',
                    'version'  => '1.9.9',
                    'source'   => ! empty( $path ) ? $path : 'upload://trx_updater.zip',
                    'required' => false,
                );
            }
        }
        return $list;
    }
}


// Check if plugin installed and activated
if ( ! function_exists( 'gamezone_exists_trx_updater' ) ) {
    function gamezone_exists_trx_updater() {
        return defined( 'TRX_UPDATER_VERSION' );
    }
}
