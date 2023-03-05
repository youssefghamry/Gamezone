<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.10
 */


// Socials
if ( gamezone_is_on(gamezone_get_theme_option('socials_in_footer')) && ($gamezone_output = gamezone_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php gamezone_show_layout($gamezone_output); ?>
		</div>
	</div>
	<?php
}
?>