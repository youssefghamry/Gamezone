<?php
/**
 * The template for homepage posts with "Classic" style
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

gamezone_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	gamezone_show_layout(get_query_var('blog_archive_start'));

	$gamezone_classes = 'posts_container '
						. (substr(gamezone_get_theme_option('blog_style'), 0, 7) == 'classic' ? 'columns_wrap columns_padding_bottom' : 'masonry_wrap');
	$gamezone_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$gamezone_sticky_out = gamezone_get_theme_option('sticky_style')=='columns' 
							&& is_array($gamezone_stickies) && count($gamezone_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($gamezone_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$gamezone_sticky_out) {
		if (gamezone_get_theme_option('first_post_large') && !is_paged() && !in_array(gamezone_get_theme_option('body_style'), array('fullwide', 'fullscreen'))) {
			the_post();
			get_template_part( 'content', 'excerpt' );
		}
		
		?><div class="<?php echo esc_attr($gamezone_classes); ?>"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($gamezone_sticky_out && !is_sticky()) {
			$gamezone_sticky_out = false;
			?></div><div class="<?php echo esc_attr($gamezone_classes); ?>"><?php
		}
		get_template_part( 'content', $gamezone_sticky_out && is_sticky() ? 'sticky' : 'classic' );
	}
	
	?></div><?php

	gamezone_show_pagination();

	gamezone_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>