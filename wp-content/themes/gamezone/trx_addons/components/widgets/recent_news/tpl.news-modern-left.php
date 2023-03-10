<?php
/**
 * The "News Excerpt" template to show post's content
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
$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$animation = '';
if ($number === 1) {
	?>
	<article
		<?php post_class( 'post_item post_layout_'.esc_attr($style)
			.' post_format_'.esc_attr($post_format)
		. ' first-wrap'
		); ?>
		>
		<?php
		trx_addons_get_template_part('templates/tpl.featured.php',
			'trx_addons_args_featured',
			apply_filters('trx_addons_filter_args_featured', array(
				'post_info' => '<div class="post_info">'
					. '<span class="post_categories">'.trx_addons_get_post_categories().'</span>'
					. '<h5 class="post_title entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">' . wp_kses( get_the_title(), 'gamezone_kses_content' ) . '</a></h5>'
					. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
						? gamezone_show_post_meta( array('components' => 'date,counters', 'counters' => 'comments,likes', 'seo' => false, 'echo' => false))
						: '')
					. '</div>',
				'thumb_bg' => true,
				'hover' => 'simple',
				'thumb_size' => gamezone_get_thumb_size('height-extra')
			),
				'recent_news-announce')
		);
		?>
	</article>
<div class="second-wrap"><?php
}


if ($number !== 1) {
?>
<article
	<?php post_class( 'post_item post_layout_'.esc_attr($style)
		.' post_format_'.esc_attr($post_format)
	); ?>
	>

	<?php
	trx_addons_get_template_part('templates/tpl.featured.php',
		'trx_addons_args_featured',
		apply_filters('trx_addons_filter_args_featured', array(
			'hover' => 'simple',
			'thumb_size' => 'gamezone-thumb-big-avatar',
			'post_info' => '<div class="post_info"><span class="post_categories">'.trx_addons_get_post_categories().'</span></div>'
		), 'recent_news-magazine')
	);

	if ( !in_array($post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			the_title('<h5 class="post_title entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">', '</a></h5>' );
			?>
			<div class="second-wrap-post-info">
				<span class="post_date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></span>
				<?php
				if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
					trx_addons_get_template_part('templates/tpl.post-counters.php',
						'trx_addons_args_post_counters',
						array(
							'counters' => 'comments,likes'
						)
					);
				}

				?>
			</div><!-- .entry-header -->
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article>

	<?php
}
if ($count === $number) {
	?></div><?php
}
?>