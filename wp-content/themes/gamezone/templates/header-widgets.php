<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

// Header sidebar
$gamezone_header_name = gamezone_get_theme_option('header_widgets');
$gamezone_header_present = !gamezone_is_off($gamezone_header_name) && is_active_sidebar($gamezone_header_name);
if ($gamezone_header_present) { 
	gamezone_storage_set('current_sidebar', 'header');
	$gamezone_header_wide = gamezone_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($gamezone_header_name) ) {
		dynamic_sidebar($gamezone_header_name);
	}
	$gamezone_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($gamezone_widgets_output)) {
		$gamezone_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $gamezone_widgets_output);
		$gamezone_need_columns = strpos($gamezone_widgets_output, 'columns_wrap')===false;
		if ($gamezone_need_columns) {
			$gamezone_columns = max(0, (int) gamezone_get_theme_option('header_columns'));
			if ($gamezone_columns == 0) $gamezone_columns = min(6, max(1, substr_count($gamezone_widgets_output, '<aside ')));
			if ($gamezone_columns > 1)
				$gamezone_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($gamezone_columns).' widget', $gamezone_widgets_output);
			else
				$gamezone_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($gamezone_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$gamezone_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($gamezone_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'gamezone_action_before_sidebar' );
				gamezone_show_layout($gamezone_widgets_output);
				do_action( 'gamezone_action_after_sidebar' );
				if ($gamezone_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$gamezone_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>