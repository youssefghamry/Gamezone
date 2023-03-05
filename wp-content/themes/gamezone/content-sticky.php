<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$gamezone_post_format = get_post_format();
$gamezone_post_format = empty($gamezone_post_format) ? 'standard' : str_replace('post-format-', '', $gamezone_post_format);
$gamezone_animation = gamezone_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($gamezone_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($gamezone_post_format) ); ?>
	<?php echo (!gamezone_is_off($gamezone_animation) ? ' data-animation="'.esc_attr(gamezone_get_animation_classes($gamezone_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	gamezone_show_post_featured(array(
		'thumb_size' => gamezone_get_thumb_size($gamezone_columns==1 ? 'big' : ($gamezone_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($gamezone_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			gamezone_show_post_meta(apply_filters('gamezone_filter_post_meta_args', array(), 'sticky', $gamezone_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>