<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.10
 */

// Logo
if (gamezone_is_on(gamezone_get_theme_option('logo_in_footer'))) {
	$gamezone_logo_image = '';
	if (gamezone_is_on(gamezone_get_theme_option('logo_retina_enabled')) && gamezone_get_retina_multiplier(2) > 1)
		$gamezone_logo_image = gamezone_get_theme_option( 'logo_footer_retina' );
	if (empty($gamezone_logo_image)) 
		$gamezone_logo_image = gamezone_get_theme_option( 'logo_footer' );
	$gamezone_logo_text   = get_bloginfo( 'name' );
	if (!empty($gamezone_logo_image) || !empty($gamezone_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($gamezone_logo_image)) {
					$gamezone_attr = gamezone_getimagesize($gamezone_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($gamezone_logo_image).'" class="logo_footer_image" alt="'.esc_attr__('img', 'gamezone').'"'.(!empty($gamezone_attr[3]) ? ' ' . wp_kses_data($gamezone_attr[3]) : '').'></a>' ;
				} else if (!empty($gamezone_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($gamezone_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>