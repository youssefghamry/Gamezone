<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.10
 */

$gamezone_footer_id = str_replace('footer-custom-', '', gamezone_get_theme_option("footer_style"));
if ((int) $gamezone_footer_id == 0) {
	$gamezone_footer_id = gamezone_get_post_id(array(
												'name' => $gamezone_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$gamezone_footer_id = apply_filters('gamezone_filter_get_translated_layout', $gamezone_footer_id);
}
$gamezone_footer_meta = get_post_meta($gamezone_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($gamezone_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($gamezone_footer_id))); 
						if (!empty($gamezone_footer_meta['margin']) != '') 
							echo ' '.esc_attr(gamezone_add_inline_css_class('margin-top: '.gamezone_prepare_css_value($gamezone_footer_meta['margin']).';'));
						if (!gamezone_is_inherit(gamezone_get_theme_option('footer_scheme')))
							echo ' scheme_' . esc_attr(gamezone_get_theme_option('footer_scheme'));
						?>">
	<?php
    // Custom footer's layout
    do_action('gamezone_action_show_layout', $gamezone_footer_id);
	?>
</footer><!-- /.footer_wrap -->
