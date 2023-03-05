<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.10
 */

// Footer sidebar
$gamezone_footer_name = gamezone_get_theme_option('footer_widgets');
$gamezone_footer_present = !gamezone_is_off($gamezone_footer_name) && is_active_sidebar($gamezone_footer_name);
if ($gamezone_footer_present) { 
	gamezone_storage_set('current_sidebar', 'footer');
	$gamezone_footer_wide = gamezone_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($gamezone_footer_name) ) {
		dynamic_sidebar($gamezone_footer_name);
	}
	$gamezone_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($gamezone_out)) {
		$gamezone_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $gamezone_out);
		$gamezone_need_columns = true;
		if ($gamezone_need_columns) {
			$gamezone_columns = max(0, (int) gamezone_get_theme_option('footer_columns'));
			if ($gamezone_columns == 0) $gamezone_columns = min(4, max(1, substr_count($gamezone_out, '<aside ')));
			if ($gamezone_columns > 1)
				$gamezone_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($gamezone_columns).' widget', $gamezone_out);
			else
				$gamezone_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($gamezone_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$gamezone_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($gamezone_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'gamezone_action_before_sidebar' );
				gamezone_show_layout($gamezone_out);
				do_action( 'gamezone_action_after_sidebar' );
				if ($gamezone_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$gamezone_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>