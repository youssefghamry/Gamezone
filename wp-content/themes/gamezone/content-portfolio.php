<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_blog_style = explode('_', gamezone_get_theme_option('blog_style'));
$gamezone_columns = empty($gamezone_blog_style[1]) ? 2 : max(2, $gamezone_blog_style[1]);
$gamezone_post_format = get_post_format();
$gamezone_post_format = empty($gamezone_post_format) ? 'standard' : str_replace('post-format-', '', $gamezone_post_format);
$gamezone_animation = gamezone_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($gamezone_columns).' post_format_'.esc_attr($gamezone_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!gamezone_is_off($gamezone_animation) ? ' data-animation="'.esc_attr(gamezone_get_animation_classes($gamezone_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$gamezone_image_hover = gamezone_get_theme_option('image_hover');
	// Featured image
	gamezone_show_post_featured(array(
		'thumb_size' => gamezone_get_thumb_size(strpos(gamezone_get_theme_option('body_style'), 'full')!==false || $gamezone_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $gamezone_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $gamezone_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>