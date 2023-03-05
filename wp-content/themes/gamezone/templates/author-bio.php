<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */
?>

<?php
// Previous/next post navigation.
?><div class="nav-links-single"><?php
	the_post_navigation( array(
		'next_text' => '<span class="nav-arrow"></span>'
			. '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'gamezone' ) . '</span> '
			. '<span class="post_date">%date</span>'
			. '<h6 class="post-title">%title</h6>',

		'prev_text' => '<span class="nav-arrow"></span>'
			. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'gamezone' ) . '</span> '
			. '<span class="post_date">%date</span>'
			. '<h6 class="post-title">%title</h6>'

	) );
	?></div>

<div class="author_info author vcard" itemprop="author" itemscope itemtype="//schema.org/Person">

	<div class="author_avatar" itemprop="image">
		<?php 
		$gamezone_mult = gamezone_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 200*$gamezone_mult );
		?>
	</div><!-- .author_avatar -->

	<div class="author_description">
		<h5 class="author_title" itemprop="name"><?php
			// Translators: Add the author's name in the <span> 
			echo wp_kses_data(sprintf(__('About %s', 'gamezone'), '<span class="fn">'.get_the_author().'</span>'));
		?></h5>

		<div class="author_bio" itemprop="description">
			<?php echo wp_kses(wpautop(get_the_author_meta( 'description' )), 'gamezone_kses_content'); ?>
			<a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php
				// Translators: Add the author's name in the <span> 
				printf( esc_html__( 'read more', 'gamezone' ));
			?></a>
			<?php do_action('gamezone_action_user_meta'); ?>
		</div><!-- .author_bio -->

	</div><!-- .author_description -->

</div><!-- .author_info -->
