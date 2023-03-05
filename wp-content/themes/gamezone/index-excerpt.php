<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

gamezone_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	gamezone_show_layout(get_query_var('blog_archive_start'));

	?><div class="posts_container"><?php
	
	$gamezone_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$gamezone_sticky_out = gamezone_get_theme_option('sticky_style')=='columns' 
							&& is_array($gamezone_stickies) && count($gamezone_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($gamezone_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($gamezone_sticky_out && !is_sticky()) {
			$gamezone_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $gamezone_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($gamezone_sticky_out) {
		$gamezone_sticky_out = false;
		?></div><?php
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