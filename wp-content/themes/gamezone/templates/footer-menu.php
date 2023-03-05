<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.10
 */

// Footer menu
$gamezone_menu_footer = gamezone_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($gamezone_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php gamezone_show_layout($gamezone_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>