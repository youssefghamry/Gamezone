<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

if (gamezone_sidebar_present()) {
	ob_start();
	$gamezone_sidebar_name = gamezone_get_theme_option('sidebar_widgets');
	gamezone_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($gamezone_sidebar_name) ) {
		dynamic_sidebar($gamezone_sidebar_name);
	}
	$gamezone_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($gamezone_out)) {
		$gamezone_sidebar_position = gamezone_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($gamezone_sidebar_position); ?> widget_area<?php if (!gamezone_is_inherit(gamezone_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(gamezone_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'gamezone_action_before_sidebar' );
				gamezone_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $gamezone_out));
				do_action( 'gamezone_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>