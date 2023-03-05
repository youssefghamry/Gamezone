<?php
/**
 * The Gallery template to display posts
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
$gamezone_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($gamezone_columns).' post_format_'.esc_attr($gamezone_post_format) ); ?>
	<?php echo (!gamezone_is_off($gamezone_animation) ? ' data-animation="'.esc_attr(gamezone_get_animation_classes($gamezone_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($gamezone_image[1]) && !empty($gamezone_image[2])) echo intval($gamezone_image[1]) .'x' . intval($gamezone_image[2]); ?>"
	data-src="<?php if (!empty($gamezone_image[0])) echo esc_url($gamezone_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$gamezone_image_hover = 'icon';	
	if (in_array($gamezone_image_hover, array('icons', 'zoom'))) $gamezone_image_hover = 'dots';
	$gamezone_components = gamezone_array_get_keys_by_value(gamezone_get_theme_option('meta_parts'));
	$gamezone_counters = gamezone_array_get_keys_by_value(gamezone_get_theme_option('counters'));
	gamezone_show_post_featured(array(
		'hover' => $gamezone_image_hover,
		'thumb_size' => gamezone_get_thumb_size( strpos(gamezone_get_theme_option('body_style'), 'full')!==false || $gamezone_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($gamezone_components)
										? gamezone_show_post_meta(apply_filters('gamezone_filter_post_meta_args', array(
											'components' => $gamezone_components,
											'counters' => $gamezone_counters,
											'seo' => false,
											'echo' => false
											), $gamezone_blog_style[0], $gamezone_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'gamezone') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>