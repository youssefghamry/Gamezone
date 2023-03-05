<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

$gamezone_args = get_query_var('gamezone_logo_args');

// Site logo
$gamezone_logo_type   = isset($gamezone_args['type']) ? $gamezone_args['type'] : '';
$gamezone_logo_image  = gamezone_get_logo_image($gamezone_logo_type);
$gamezone_logo_text   = gamezone_is_on(gamezone_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$gamezone_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($gamezone_logo_image) || !empty($gamezone_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($gamezone_logo_image)) {
			if (empty($gamezone_logo_type) && function_exists('the_custom_logo') && (int) $gamezone_logo_image > 0) {
				the_custom_logo();
			} else {
				$gamezone_attr = gamezone_getimagesize($gamezone_logo_image);
				echo '<img src="'.esc_url($gamezone_logo_image).'" alt="'.esc_attr__('img', 'gamezone').'"'.(!empty($gamezone_attr[3]) ? ' '.wp_kses_data($gamezone_attr[3]) : '').'>';
			}
		} else {
			gamezone_show_layout(gamezone_prepare_macros($gamezone_logo_text), '<span class="logo_text">', '</span>');
			gamezone_show_layout(gamezone_prepare_macros($gamezone_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>