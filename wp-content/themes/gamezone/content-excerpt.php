<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_post_format = get_post_format();
$gamezone_post_format = empty($gamezone_post_format) ? 'standard' : str_replace('post-format-', '', $gamezone_post_format);
$gamezone_animation = gamezone_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($gamezone_post_format) ); ?>
	<?php echo (!gamezone_is_off($gamezone_animation) ? ' data-animation="'.esc_attr(gamezone_get_animation_classes($gamezone_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	gamezone_show_post_featured(array( 'thumb_size' => gamezone_get_thumb_size( strpos(gamezone_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ,
		'post_info' => (has_post_thumbnail() && in_array($gamezone_post_format, array('standard', 'image', 'video'))
			? '<div class="post_info_bottom">'
			. '<div class="post_categories">'.wp_kses(gamezone_get_post_categories(' '), 'gamezone_kses_content').'</div>'
			. '</div>'
			: '')
	));

	if (!has_post_thumbnail()&& !in_array($gamezone_post_format, array('audio') )) {

		?>
		<div class="post_info_top">
			<div class="post_categories"><?php echo wp_kses(gamezone_get_post_categories(' '), 'gamezone_kses_content') ?></div>
		</div>
		<?php


	}


	?>

	<div class="post_excerpt_content_inner entry-header">

	<?php
	// Title and post meta
	if (get_the_title() != '') {
		?>

		<div class="post_header entry-header">
			<?php
			do_action('gamezone_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );


			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (gamezone_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'gamezone' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'gamezone' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$gamezone_show_learn_more = !in_array($gamezone_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
				if (has_excerpt()) {
					the_excerpt();
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($gamezone_post_format, array('link', 'aside', 'status'))) {
					the_content();
				} else if ($gamezone_post_format == 'quote') {
					if (($quote = gamezone_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
						gamezone_show_layout(wpautop($quote));
					else
						the_excerpt();
				} else if (substr(get_the_content(), 0, 1)!='[') {
					the_excerpt();
				}
			?></div><?php

		}
	?></div><!-- .entry-content -->
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
	<div class="clearfix"></div>
</article>