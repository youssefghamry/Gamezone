<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

						// Widgets area inside page content
						gamezone_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					gamezone_create_widgets_area('widgets_below_page');

					$gamezone_body_style = gamezone_get_theme_option('body_style');
					if ($gamezone_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$gamezone_footer_type = gamezone_get_theme_option("footer_type");
			if ($gamezone_footer_type == 'custom' && !gamezone_is_layouts_available())
				$gamezone_footer_type = 'default';
			get_template_part( "templates/footer-{$gamezone_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (gamezone_is_on(gamezone_get_theme_option('debug_mode')) && gamezone_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(gamezone_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>