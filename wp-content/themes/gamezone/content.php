<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_seo = gamezone_is_on(gamezone_get_theme_option('seo_snippets'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												);
		if ($gamezone_seo) {
			?> itemscope="itemscope" 
			   itemprop="articleBody" 
			   itemtype="//schema.org/<?php echo esc_attr(gamezone_get_markup_schema()); ?>"
			   itemid="<?php echo esc_url(get_the_permalink()); ?>"
			   content="<?php the_title_attribute(); ?>"<?php
		}
?>><?php

	do_action('gamezone_action_before_post_data'); 

	// Structured data snippets
	if ($gamezone_seo)
		get_template_part('templates/seo');

	// Featured image
	if ( gamezone_is_off(gamezone_get_theme_option('hide_featured_on_single'))
			&& !gamezone_sc_layouts_showed('featured') 
			&& strpos(get_the_content(), '[trx_widget_banner]')===false) {
		do_action('gamezone_action_before_post_featured');
		gamezone_show_post_featured(array(
			'thumb_size' => gamezone_get_thumb_size( 'big' ),
			'post_info' => '<div class="post_info_bottom">'
				. '<div class="post_categories">'.wp_kses(gamezone_get_post_categories(' '), 'gamezone_kses_content').'</div>'
				. '</div>'
		));
		do_action('gamezone_action_after_post_featured');

	} else if (has_post_thumbnail()) {
		?><meta itemprop="image" itemtype="//schema.org/ImageObject" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>"><?php
	}

	// Title and post meta
	if ( (!gamezone_sc_layouts_showed('title') || !gamezone_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('gamezone_action_before_post_title'); 
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (!gamezone_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.($gamezone_seo ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			// Post meta
			if (!gamezone_sc_layouts_showed('postmeta') && gamezone_is_on(gamezone_get_theme_option('show_post_meta'))) {
				gamezone_show_post_meta(apply_filters('gamezone_filter_post_meta_args', array(
					'components' => gamezone_array_get_keys_by_value(gamezone_get_theme_option('meta_parts')),
					'counters' => gamezone_array_get_keys_by_value(gamezone_get_theme_option('counters')),
					'seo' => gamezone_is_on(gamezone_get_theme_option('seo_snippets'))
					), 'single', 1)
				);
			}
			?>
		</div><!-- .post_header -->
		<?php
		do_action('gamezone_action_after_post_title'); 
	}

	do_action('gamezone_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content( );

		do_action('gamezone_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'gamezone' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'gamezone' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {
			
			do_action('gamezone_action_before_post_meta'); 

			?><div class="post_meta post_meta_single"><?php
				
				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'gamezone').'</span> ', ', ', '</span>' );

				// Share
				if (gamezone_is_on(gamezone_get_theme_option('show_share_links'))) {
					gamezone_show_share_links(array(
							'type' => 'block',
							'caption' => '',
							'before' => '<span class="post_meta_item post_share">',
							'after' => '</span>'
						));
				}
			?></div><?php

			do_action('gamezone_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('gamezone_action_after_post_content'); 

	// Author bio.
	if ( gamezone_get_theme_option('show_author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {
		do_action('gamezone_action_before_post_author'); 
		get_template_part( 'templates/author-bio' );
		do_action('gamezone_action_after_post_author'); 
	}

	do_action('gamezone_action_after_post_data'); 
	?>
</article>
