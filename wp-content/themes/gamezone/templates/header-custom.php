<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.06
 */

$gamezone_header_css = '';
$gamezone_header_image = get_header_image();
$gamezone_header_video = gamezone_get_header_video();
if (!empty($gamezone_header_image) && gamezone_trx_addons_featured_image_override(is_singular() || gamezone_storage_isset('blog_archive') || is_category())) {
	$gamezone_header_image = gamezone_get_current_mode_image($gamezone_header_image);
}

$gamezone_header_id = str_replace('header-custom-', '', gamezone_get_theme_option("header_style"));
if ((int) $gamezone_header_id == 0) {
	$gamezone_header_id = gamezone_get_post_id(array(
												'name' => $gamezone_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$gamezone_header_id = apply_filters('gamezone_filter_get_translated_layout', $gamezone_header_id);
}
$gamezone_header_meta = get_post_meta($gamezone_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($gamezone_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($gamezone_header_id)));
				echo !empty($gamezone_header_image) || !empty($gamezone_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($gamezone_header_video!='') 
					echo ' with_bg_video';
				if ($gamezone_header_image!='') 
					echo ' '.esc_attr(gamezone_add_inline_css_class('background-image: url('.esc_url($gamezone_header_image).');'));
				if (!empty($gamezone_header_meta['margin']) != '') 
					echo ' '.esc_attr(gamezone_add_inline_css_class('margin-bottom: '.esc_attr(gamezone_prepare_css_value($gamezone_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (gamezone_is_on(gamezone_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight gamezone-full-height';
				if (!gamezone_is_inherit(gamezone_get_theme_option('header_scheme')))
					echo ' scheme_' . esc_attr(gamezone_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($gamezone_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('gamezone_action_show_layout', $gamezone_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>