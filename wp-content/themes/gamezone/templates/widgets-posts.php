<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_post_id    = get_the_ID();
$gamezone_post_date  = gamezone_get_date();
$gamezone_post_title = get_the_title();
$gamezone_post_link  = get_permalink();
$gamezone_post_author_id   = get_the_author_meta('ID');
$gamezone_post_author_name = get_the_author_meta('display_name');
$gamezone_post_author_url  = get_author_posts_url($gamezone_post_author_id, '');

$gamezone_args = get_query_var('gamezone_args_widgets_posts');
$gamezone_show_date = isset($gamezone_args['show_date']) ? (int) $gamezone_args['show_date'] : 1;
$gamezone_show_image = isset($gamezone_args['show_image']) ? (int) $gamezone_args['show_image'] : 1;
$gamezone_show_author = isset($gamezone_args['show_author']) ? (int) $gamezone_args['show_author'] : 1;
$gamezone_show_counters = isset($gamezone_args['show_counters']) ? (int) $gamezone_args['show_counters'] : 1;
$gamezone_show_categories = isset($gamezone_args['show_categories']) ? (int) $gamezone_args['show_categories'] : 1;

$gamezone_output = gamezone_storage_get('gamezone_output_widgets_posts');

$gamezone_post_counters_output = '';
if ( $gamezone_show_counters ) {
	$gamezone_post_counters_output = '<span class="post_info_item post_info_counters">'
								. gamezone_get_post_counters('comments')
							. '</span>';
}


$gamezone_output .= '<article class="post_item with_thumb">';

if ($gamezone_show_image) {
	$gamezone_post_thumb = get_the_post_thumbnail($gamezone_post_id, gamezone_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) )
	));
	if ($gamezone_post_thumb) $gamezone_output .= '<div class="post_thumb">' . ($gamezone_post_link ? '<a href="' . esc_url($gamezone_post_link) . '">' : '') . ($gamezone_post_thumb) . ($gamezone_post_link ? '</a>' : '') . '</div>';
}

$gamezone_output .= '<div class="post_content">'
			. ($gamezone_show_categories 
					? '<div class="post_categories">'
						. gamezone_get_post_categories()
						. $gamezone_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($gamezone_post_link ? '<a href="' . esc_url($gamezone_post_link) . '">' : '') . ($gamezone_post_title) . ($gamezone_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('gamezone_filter_get_post_info', 
								'<div class="post_info">'
									. ($gamezone_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($gamezone_post_link ? '<a href="' . esc_url($gamezone_post_link) . '" class="post_info_date">' : '') 
											. esc_html($gamezone_post_date) 
											. ($gamezone_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($gamezone_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'gamezone') . ' ' 
											. ($gamezone_post_link ? '<a href="' . esc_url($gamezone_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($gamezone_post_author_name) 
											. ($gamezone_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$gamezone_show_categories && $gamezone_post_counters_output
										? $gamezone_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
gamezone_storage_set('gamezone_output_widgets_posts', $gamezone_output);
?>