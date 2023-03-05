<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_link = get_permalink();
$gamezone_post_format = get_post_format();
$gamezone_post_format = empty($gamezone_post_format) ? 'standard' : str_replace('post-format-', '', $gamezone_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($gamezone_post_format) ); ?>><?php
	gamezone_show_post_featured(array(
		'thumb_size' => apply_filters('gamezone_filter_related_thumb_size', gamezone_get_thumb_size( (int) gamezone_get_theme_option('related_posts') == 1 ? 'huge' : 'big' )),
		'show_no_image' => gamezone_get_theme_setting('allow_no_image'),
		'singular' => false,
		'post_info' => '<div class="post_header entry-header">'
							. '<div class="post_categories">'.wp_kses(gamezone_get_post_categories(''), 'gamezone_kses_content').'</div>'
							. '<h6 class="post_title entry-title"><a href="'.esc_url($gamezone_link).'">'.esc_html(get_the_title()).'</a></h6>'
							. (in_array(get_post_type(), array('post', 'attachment'))
									? '<span class="post_date"><a href="'.esc_url($gamezone_link).'">'.wp_kses_data(gamezone_get_date()).'</a></span>'
									: '')
						. '</div>'
		)
	);
?></div>