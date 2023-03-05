<?php
/**
 * The "Portfolio" template to show post's content
 *
 * Used in the widget Recent News.
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */
 
$widget_args = get_query_var('trx_addons_args_recent_news');
$style = $widget_args['style'];
$number = $widget_args['number'];
$count = $widget_args['count'];
$columns = $widget_args['columns'];
$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$animation = apply_filters('trx_addons_blog_animation', '');

if ($columns > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $columns)); ?>"><?php
}
?><article 
	<?php post_class( 'post_item post_layout_'.esc_attr($style).' post_format_'.esc_attr($post_format) ); ?>
	<?php echo (!empty($animation) ? ' data-animation="'.esc_attr($animation).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}
	
	trx_addons_get_template_part('templates/tpl.featured.php',
								'trx_addons_args_featured',
								apply_filters('trx_addons_filter_args_featured', array(
												'thumb_size' => gamezone_get_thumb_size('big-med'),
												'hover' => 'simple',
									             'post_info' =>trx_addons_sc_show_post_meta('recent_news', apply_filters('trx_addons_filter_show_post_meta', array(
																	 'counters' => 'comments,likes',
																	 'components' => 'counters',
																	 'echo' => false
																 ), 'recent_news-portfolio', $args['columns'])
															 )
													. '<h5 class="post_title entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">' . wp_kses( get_the_title(), 'gamezone_kses_content' ) . '</a></h5>'

												), 'recent_news-portfolio')
							);
?>
</article><?php

if ($columns > 1) {
	?></div><?php
}
?>