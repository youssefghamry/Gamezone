<?php
/**
 * Information about this theme
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.30
 */


// Redirect to the 'About Theme' page after switch theme
if (!function_exists('gamezone_about_after_switch_theme')) {
	add_action('after_switch_theme', 'gamezone_about_after_switch_theme', 1000);
	function gamezone_about_after_switch_theme() {
		update_option('gamezone_about_page', 1);
	}
}
if ( !function_exists('gamezone_about_after_setup_theme') ) {
	add_action( 'init', 'gamezone_about_after_setup_theme', 1000 );
	function gamezone_about_after_setup_theme() {
		if (get_option('gamezone_about_page') == 1) {
			update_option('gamezone_about_page', 0);
			wp_safe_redirect(admin_url().'themes.php?page=gamezone_about');
			exit();
		}
	}
}


// Add 'About Theme' item in the Appearance menu
if (!function_exists('gamezone_about_add_menu_items')) {
	add_action( 'admin_menu', 'gamezone_about_add_menu_items' );
	function gamezone_about_add_menu_items() {
		$theme = wp_get_theme();
		$theme_name = $theme->name . (GAMEZONE_THEME_FREE ? ' ' . esc_html__('Free', 'gamezone') : '');
		add_theme_page(
			// Translators: Add theme name to the page title
			sprintf(esc_html__('About %s', 'gamezone'), $theme_name),	//page_title
			// Translators: Add theme name to the menu title
			sprintf(esc_html__('About %s', 'gamezone'), $theme_name),	//menu_title
			'manage_options',											//capability
			'gamezone_about',											//menu_slug
			'gamezone_about_page_builder'								//callback
		);
	}
}


// Load page-specific scripts and styles
if (!function_exists('gamezone_about_enqueue_scripts')) {
	add_action( 'admin_enqueue_scripts', 'gamezone_about_enqueue_scripts' );
	function gamezone_about_enqueue_scripts() {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && $screen->id == 'appearance_page_gamezone_about') {
			// Scripts
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			
			if (function_exists('gamezone_plugins_installer_enqueue_scripts'))
				gamezone_plugins_installer_enqueue_scripts();
			
			// Styles
			wp_enqueue_style( 'fontello-icons',  gamezone_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			if ( ($fdir = gamezone_get_file_url('theme-specific/theme-about/theme-about.css')) != '' )
				wp_enqueue_style( 'gamezone-about',  $fdir, array(), null );
		}
	}
}


// Build 'About Theme' page
if (!function_exists('gamezone_about_page_builder')) {
	function gamezone_about_page_builder() {
		$theme = wp_get_theme();
		?>
		<div class="gamezone_about">
			<div class="gamezone_about_header">
				<div class="gamezone_about_logo"><?php
					$logo = gamezone_get_file_url('theme-specific/theme-about/logo.jpg');
					if (empty($logo)) $logo = gamezone_get_file_url('screenshot.jpg');
					if (!empty($logo)) {
						?><img src="<?php echo esc_url($logo); ?>"><?php
					}
				?></div>
				
				<?php if (GAMEZONE_THEME_FREE) { ?>
					<a href="<?php echo esc_url(gamezone_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="gamezone_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'gamezone');
										?></a>
				<?php } ?>
				<h1 class="gamezone_about_title"><?php
					// Translators: Add theme name and version to the 'Welcome' message
					echo esc_html(sprintf(__('Welcome to %1$s %2$s v.%3$s', 'gamezone'),
								$theme->name,
								GAMEZONE_THEME_FREE ? __('Free', 'gamezone') : '',
								$theme->version
								));
				?></h1>
				<div class="gamezone_about_description">
					<?php
					if (GAMEZONE_THEME_FREE) {
						?><p><?php
							// Translators: Add the download url and the theme name to the message
							echo wp_kses_data(sprintf(__('Now you are using Free version of <a href="%1$s">%2$s Pro Theme</a>.', 'gamezone'),
														esc_url(gamezone_storage_get('theme_download_url')),
														$theme->name
														)
												);
							// Translators: Add the theme name and supported plugins list to the message
							echo '<br>' . wp_kses_data(sprintf(__('This version is SEO- and Retina-ready. It also has a built-in support for parallax and slider with swipe gestures. %1$s Free is compatible with many popular plugins, such as %2$s', 'gamezone'),
														$theme->name,
														gamezone_about_get_supported_plugins()
														)
												);
						?></p>
						<p><?php
							// Translators: Add the download url to the message
							echo wp_kses_data(sprintf(__('We hope you have a great acquaintance with our themes. If you are looking for a fully functional website, you can get the <a href="%s">Pro Version here</a>', 'gamezone'),
														esc_url(gamezone_storage_get('theme_download_url'))
														)
												);
						?></p><?php
					} else {
						?><p><?php
							// Translators: Add the theme name to the message
							echo wp_kses_data(sprintf(__('%s is a Premium WordPress theme. It has a built-in support for parallax, slider with swipe gestures, and is SEO- and Retina-ready', 'gamezone'),
														$theme->name
														)
												);
						?></p>
						<p><?php
							// Translators: Add supported plugins list to the message
							echo wp_kses_data(sprintf(__('The Premium Theme is compatible with many popular plugins, such as %s', 'gamezone'),
														gamezone_about_get_supported_plugins()
														)
												);
						?></p><?php
					}
					?>
				</div>
			</div>
			<div id="gamezone_about_tabs" class="gamezone_tabs gamezone_about_tabs">
				<ul>
					<li><a href="#gamezone_about_section_start"><?php esc_html_e('Getting started', 'gamezone'); ?></a></li>
					<li><a href="#gamezone_about_section_actions"><?php esc_html_e('Recommended actions', 'gamezone'); ?></a></li>
					<?php if (GAMEZONE_THEME_FREE) { ?>
						<li><a href="#gamezone_about_section_pro"><?php esc_html_e('Free vs PRO', 'gamezone'); ?></a></li>
					<?php } ?>
				</ul>
				<div id="gamezone_about_section_start" class="gamezone_tabs_section gamezone_about_section"><?php
				
					// Install required plugins
					if (!GAMEZONE_THEME_FREE_WP && !gamezone_exists_trx_addons()) {
						?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
							<h2 class="gamezone_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'gamezone'); ?>
							</h2>
							<div class="gamezone_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'gamezone');
							?></div>
							<?php gamezone_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
						<h2 class="gamezone_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'gamezone'); ?>
						</h2>
						<div class="gamezone_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'gamezone'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="gamezone_about_block_link button button-primary"><?php
							esc_html_e('Install plugins', 'gamezone');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
						<h2 class="gamezone_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'gamezone'); ?>
						</h2>
						<div class="gamezone_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'gamezone');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   class="gamezone_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'gamezone');
						?></a>
						<?php if (!GAMEZONE_THEME_FREE) { ?>
							<?php esc_html_e('or', 'gamezone'); ?>
							<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
							   class="gamezone_about_block_link button"><?php
								esc_html_e('Theme Options', 'gamezone');
							?></a>
						<?php } ?>
					</div></div><?php
					
					// Documentation
					?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
						<h2 class="gamezone_about_block_title">
							<i class="dashicons dashicons-book"></i>
							<?php esc_html_e('Read full documentation', 'gamezone');	?>
						</h2>
						<div class="gamezone_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Need more details? Please check our full online documentation for detailed information on how to use %s.', 'gamezone'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(gamezone_storage_get('theme_doc_url')); ?>"
						   target="_blank"
						   class="gamezone_about_block_link button button-primary"><?php
							esc_html_e('Documentation', 'gamezone');
						?></a>
					</div></div><?php
					
					// Video tutorials
					?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
						<h2 class="gamezone_about_block_title">
							<i class="dashicons dashicons-video-alt2"></i>
							<?php esc_html_e('Video tutorials', 'gamezone');	?>
						</h2>
						<div class="gamezone_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('No time for reading documentation? Check out our video tutorials and learn how to customize %s in detail.', 'gamezone'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(gamezone_storage_get('theme_video_url')); ?>"
						   target="_blank"
						   class="gamezone_about_block_link button button-primary"><?php
							esc_html_e('Watch videos', 'gamezone');
						?></a>
					</div></div><?php
					
					// Support
					if (!GAMEZONE_THEME_FREE) {
						?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
							<h2 class="gamezone_about_block_title">
								<i class="dashicons dashicons-sos"></i>
								<?php esc_html_e('Support', 'gamezone'); ?>
							</h2>
							<div class="gamezone_about_block_description"><?php
								// Translators: Add the theme name to the message
								echo esc_html(sprintf(__('We want to make sure you have the best experience using %s and that is why we gathered here all the necessary informations for you.', 'gamezone'), $theme->name));
							?></div>
							<a href="<?php echo esc_url(gamezone_storage_get('theme_support_url')); ?>"
							   target="_blank"
							   class="gamezone_about_block_link button button-primary"><?php
								esc_html_e('Support', 'gamezone');
							?></a>
						</div></div><?php
					}
					
					// Online Demo
					?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
						<h2 class="gamezone_about_block_title">
							<i class="dashicons dashicons-images-alt2"></i>
							<?php esc_html_e('On-line demo', 'gamezone'); ?>
						</h2>
						<div class="gamezone_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Visit the Demo Version of %s to check out all the features it has', 'gamezone'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(gamezone_storage_get('theme_demo_url')); ?>"
						   target="_blank"
						   class="gamezone_about_block_link button button-primary"><?php
							esc_html_e('View demo', 'gamezone');
						?></a>
					</div></div>
					
				</div>



				<div id="gamezone_about_section_actions" class="gamezone_tabs_section gamezone_about_section"><?php
				
					// Install required plugins
					if (!GAMEZONE_THEME_FREE_WP && !gamezone_exists_trx_addons()) {
						?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
							<h2 class="gamezone_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'gamezone'); ?>
							</h2>
							<div class="gamezone_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'gamezone');
							?></div>
							<?php gamezone_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
						<h2 class="gamezone_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'gamezone'); ?>
						</h2>
						<div class="gamezone_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'gamezone'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="gamezone_about_block_link button button button-primary"><?php
							esc_html_e('Install plugins', 'gamezone');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="gamezone_about_block"><div class="gamezone_about_block_inner">
						<h2 class="gamezone_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'gamezone'); ?>
						</h2>
						<div class="gamezone_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'gamezone');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   target="_blank"
						   class="gamezone_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'gamezone');
						?></a>
						<?php esc_html_e('or', 'gamezone'); ?>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
						   class="gamezone_about_block_link button"><?php
							esc_html_e('Theme Options', 'gamezone');
						?></a>
					</div></div>
					
				</div>



				<?php if (GAMEZONE_THEME_FREE) { ?>
					<div id="gamezone_about_section_pro" class="gamezone_tabs_section gamezone_about_section">
						<table class="gamezone_about_table" cellpadding="0" cellspacing="0" border="0">
							<thead>
								<tr>
									<td class="gamezone_about_table_info">&nbsp;</td>
									<td class="gamezone_about_table_check"><?php
										// Translators: Show theme name with suffix 'Free'
										echo esc_html(sprintf(__('%s Free', 'gamezone'), $theme->name));
									?></td>
									<td class="gamezone_about_table_check"><?php
										// Translators: Show theme name with suffix 'PRO'
										echo esc_html(sprintf(__('%s PRO', 'gamezone'), $theme->name));
									?></td>
								</tr>
							</thead>
							<tbody>
	
	
								<?php
								// Responsive layouts
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Mobile friendly', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('Responsive layout. Looks great on any device.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Built-in slider
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Built-in posts slider', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('Allows you to add beautiful slides using the built-in shortcode/widget "Slider" with swipe gestures support.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Revolution slider
								if (gamezone_storage_isset('required_plugins', 'revslider')) {
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Revolution Slider Compatibility', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('Our built-in shortcode/widget "Slider" is able to work not only with posts, but also with slides created  in "Revolution Slider".', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// SiteOrigin Panels
								if (gamezone_storage_isset('required_plugins', 'siteorigin-panels')) {
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Free PageBuilder', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('Full integration with a nice free page builder "SiteOrigin Panels".', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Additional widgets pack', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('A number of useful widgets to create beautiful homepages and other sections of your website with SiteOrigin Panels.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// WPBakery Page Builder
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('WPBakery Page Builder', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('Full integration with a very popular page builder "WPBakery Page Builder". A number of useful shortcodes and widgets to create beautiful homepages and other sections of your website.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Additional shortcodes pack', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('A number of useful shortcodes to create beautiful homepages and other sections of your website with WPBakery Page Builder.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Layouts builder
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Headers and Footers builder', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('Powerful visual builder of headers and footers! No manual code editing - use all the advantages of drag-and-drop technology.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// WooCommerce
								if (gamezone_storage_isset('required_plugins', 'woocommerce')) {
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('WooCommerce Compatibility', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('Ready for e-commerce. You can build an online store with this theme.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Easy Digital Downloads
								if (gamezone_storage_isset('required_plugins', 'easy-digital-downloads')) {
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Easy Digital Downloads Compatibility', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('Ready for digital e-commerce. You can build an online digital store with this theme.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Other plugins
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Many other popular plugins compatibility', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('PRO version is compatible (was tested and has built-in support) with many popular plugins.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Support
								?>
								<tr>
									<td class="gamezone_about_table_info">
										<h2 class="gamezone_about_table_info_title">
											<?php esc_html_e('Support', 'gamezone'); ?>
										</h2>
										<div class="gamezone_about_table_info_description"><?php
											esc_html_e('Our premium support is going to take care of any problems, in case there will be any of course.', 'gamezone');
										?></div>
									</td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="gamezone_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Get PRO version
								?>
								<tr>
									<td class="gamezone_about_table_info">&nbsp;</td>
									<td class="gamezone_about_table_check" colspan="2">
										<a href="<?php echo esc_url(gamezone_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="gamezone_about_block_link gamezone_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'gamezone');
										?></a>
									</td>
								</tr>
	
							</tbody>
						</table>
					</div>
				<?php } ?>
				
			</div>
		</div>
		<?php
	}
}


// Utils
//------------------------------------

// Return supported plugin's names
if (!function_exists('gamezone_about_get_supported_plugins')) {
	function gamezone_about_get_supported_plugins() {
		return '"' . join('", "', array_values(gamezone_storage_get('required_plugins'))) . '"';
	}
}

require_once GAMEZONE_THEME_DIR . 'includes/plugins-installer/plugins-installer.php';
?>