<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_link = get_permalink();
$gamezone_post_format = get_post_format();
$gamezone_post_format = empty($gamezone_post_format) ? 'standard' : str_replace('post-format-', '', $gamezone_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_2 post_format_'.esc_attr($gamezone_post_format) ); ?>><?php
	gamezone_show_post_featured(array(
		'thumb_size' => apply_filters('gamezone_filter_related_thumb_size', gamezone_get_thumb_size( (int) gamezone_get_theme_option('related_posts') == 1 ? 'huge' : 'big' )),
		'post_info' => (has_post_thumbnail() && in_array($gamezone_post_format, array('standard', 'image', 'video'))
			? '<div class="post_info_bottom">'
			. '<div class="post_categories">'.wp_kses(gamezone_get_post_categories(' '), 'gamezone_kses_content').'</div>'
			. '</div>'
			: ''),
		'show_no_image' => gamezone_get_theme_setting('allow_no_image'),
		'singular' => false
		)
	);
	?><div class="post_header entry-header">

		<h6 class="post_title entry-title"><a href="<?php echo esc_url($gamezone_link); ?>"><?php the_title(); ?></a></h6>
		<?php

		do_action('gamezone_action_before_post_meta');

		// Post meta
		$gamezone_components = gamezone_array_get_keys_by_value(gamezone_get_theme_option('meta_parts'));
		$gamezone_counters = gamezone_array_get_keys_by_value(gamezone_get_theme_option('counters'));

		if (!empty($gamezone_components))
			gamezone_show_post_meta(apply_filters('gamezone_filter_post_meta_args', array(
					'components' => $gamezone_components,
					'counters' => $gamezone_counters,
					'seo' => false
				), 'excerpt', 1)
			);

		?>
	</div>
</div>