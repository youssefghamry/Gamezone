<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_header_css = '';
$gamezone_header_image = get_header_image();
$gamezone_header_video = gamezone_get_header_video();
if (!empty($gamezone_header_image) && gamezone_trx_addons_featured_image_override(is_singular() || gamezone_storage_isset('blog_archive') || is_category())) {
	$gamezone_header_image = gamezone_get_current_mode_image($gamezone_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($gamezone_header_image) || !empty($gamezone_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($gamezone_header_video!='') echo ' with_bg_video';
					if ($gamezone_header_image!='') echo ' '.esc_attr(gamezone_add_inline_css_class('background-image: url('.esc_url($gamezone_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (gamezone_is_on(gamezone_get_theme_option('header_fullheight'))) echo ' header_fullheight gamezone-full-height';
					if (!gamezone_is_inherit(gamezone_get_theme_option('header_scheme')))
						echo ' scheme_' . esc_attr(gamezone_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($gamezone_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (gamezone_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Mobile header
	if (gamezone_is_on(gamezone_get_theme_option("header_mobile_enabled"))) {
		get_template_part( 'templates/header-mobile' );
	}
	
	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
?></header>