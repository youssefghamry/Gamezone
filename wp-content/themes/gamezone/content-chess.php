<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_blog_style = explode('_', gamezone_get_theme_option('blog_style'));
$gamezone_columns = empty($gamezone_blog_style[1]) ? 1 : max(1, $gamezone_blog_style[1]);
$gamezone_expanded = !gamezone_sidebar_present() && gamezone_is_on(gamezone_get_theme_option('expand_content'));
$gamezone_post_format = get_post_format();
$gamezone_post_format = empty($gamezone_post_format) ? 'standard' : str_replace('post-format-', '', $gamezone_post_format);
$gamezone_animation = gamezone_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($gamezone_columns).' post_format_'.esc_attr($gamezone_post_format) ); ?>
	<?php echo (!gamezone_is_off($gamezone_animation) ? ' data-animation="'.esc_attr(gamezone_get_animation_classes($gamezone_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($gamezone_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'. the_title_attribute( array( 'echo' => false ) ) .'" icon="'.esc_attr(gamezone_get_post_icon()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	gamezone_show_post_featured( array(
											'class' => $gamezone_columns == 1 ? 'gamezone-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => gamezone_get_thumb_size(
																	strpos(gamezone_get_theme_option('body_style'), 'full')!==false
																		? ( $gamezone_columns > 1 ? 'huge' : 'original' )
																		: (	$gamezone_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('gamezone_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('gamezone_action_before_post_meta'); 

			// Post meta
			$gamezone_components = gamezone_array_get_keys_by_value(gamezone_get_theme_option('meta_parts'));
			$gamezone_counters = gamezone_array_get_keys_by_value(gamezone_get_theme_option('counters'));
			$gamezone_post_meta = empty($gamezone_components) 
										? '' 
										: gamezone_show_post_meta(apply_filters('gamezone_filter_post_meta_args', array(
												'components' => $gamezone_components,
												'counters' => $gamezone_counters,
												'seo' => false,
												'echo' => false
												), $gamezone_blog_style[0], $gamezone_columns)
											);
			gamezone_show_layout($gamezone_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$gamezone_show_learn_more = !in_array($gamezone_post_format, array('link', 'aside', 'status', 'quote'));
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
				?>
			</div>
			<?php
			// Post meta
			if (in_array($gamezone_post_format, array('link', 'aside', 'status', 'quote'))) {
				gamezone_show_layout($gamezone_post_meta);
			}
			// More button
			if ( $gamezone_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'gamezone'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>