<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.22
 */

if (!defined("GAMEZONE_THEME_FREE")) define("GAMEZONE_THEME_FREE", false);
if (!defined("GAMEZONE_THEME_FREE_WP")) define("GAMEZONE_THEME_FREE_WP", false);

// Theme storage
$GAMEZONE_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'gamezone'),

			
			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'contact-form-7'				=> esc_html__('Contact Form 7', 'gamezone'),
			'mailchimp-for-wp'				=> esc_html__('MailChimp for WP', 'gamezone'),
			'woocommerce'					=> esc_html__('WooCommerce', 'gamezone'),
            'elegro-payment'				=> esc_html__('Elegro Crypto Payment', 'gamezone'),
            'trx_updater'					=> esc_html__('ThemeREX Updater', 'gamezone'),
            'yith-woocommerce-compare'		=> esc_html__('YITH WooCommerce Compare', 'gamezone'),
            'yith-woocommerce-wishlist'		=> esc_html__('YITH WooCommerce Wishlist', 'gamezone')
		),

		// List of plugins for the FREE version only
		//-----------------------------------------------------
		GAMEZONE_THEME_FREE ? array() : array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'essential-grid'			=> esc_html__('Essential Grid', 'gamezone'),
					'the-events-calendar'		=> esc_html__('The Events Calendar', 'gamezone'),
					'js_composer'				=> esc_html__('WPBakery Page Builder', 'gamezone'),

					)
	),
	
	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> 'http://gamezone.themerex.net/',
	'theme_doc_url'		=> 'http://gamezone.themerex.net/doc/',
	'theme_download_url'=> 'https://themeforest.net/user/themerex',


	'theme_support_url'	=> 'https://themerex.net/support',								// ThemeREX


	'theme_video_url'	=> 'https://www.youtube.com/channel/UCnFisBimrK2aIE-hnY70kCA',	// ThemeREX

	// Responsive resolutions
	// Parameters to create css media query: min, max, 
	'responsive' => array(
						// By device
						'desktop'	=> array('min' => 1680),
						'notebook'	=> array('min' => 1280, 'max' => 1679),
						'tablet'	=> array('min' =>  768, 'max' => 1279),
						'mobile'	=> array('max' =>  767),
						// By size
						'xxl'		=> array('max' => 1679),
						'xl'		=> array('max' => 1439),
						'lg'		=> array('max' => 1279),
						'md'		=> array('max' => 1023),
						'sm'		=> array('max' =>  767),
						'sm_wp'		=> array('max' =>  600),
						'xs'		=> array('max' =>  479)
						)
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('gamezone_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'gamezone_customizer_theme_setup1', 1 );
	function gamezone_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		gamezone_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for the main and the child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes

			'customize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame

			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts

			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'

			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// vc (default) - standard VC icons selector (very slow and don't support images)
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> false,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false,		// Allow upload not pre-packaged plugins via TGMPA
			
			'allow_no_image'		=> false		// Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		gamezone_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Roboto',
				'family' => 'sans-serif',
				'styles' => '300,300italic,400,400italic,500,500italic,700,700italic'		// Parameter 'style' used only for the Google fonts
				),

		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		gamezone_storage_set('load_fonts_subset', 'latin,latin-ext');

		gamezone_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'gamezone'),
				'description'		=> esc_html__('Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.1px',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.9em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '2.5em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '0.95em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.75px',
				'margin-top'		=> '1.47em',
				'margin-bottom'		=> '0.63em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '2.25em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '0.94em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.7px',
				'margin-top'		=> '1.675em',
				'margin-bottom'		=> '0.78em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '1.625em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.038em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.5px',
				'margin-top'		=> '2.35em',
				'margin-bottom'		=> '0.7879em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '1.3125em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.143em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.82px',
				'margin-top'		=> '2.7923em',
				'margin-bottom'		=> '0.9em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '1.125em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.1667em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.35px',
				'margin-top'		=> '3.35em',
				'margin-bottom'		=> '1em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '1em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.3px',
				'margin-top'		=> '3.75em',
				'margin-bottom'		=> '0.9412em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'gamezone'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '12px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '22px',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'gamezone'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'gamezone'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '0.8125em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'gamezone'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'gamezone'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '11px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'gamezone'),
				'description'		=> esc_html__('Font settings of the main menu items', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '0.8125em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'gamezone'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'gamezone'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '1.076em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		gamezone_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'gamezone'),
							'description'	=> esc_html__('Colors of the main content area', 'gamezone')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'gamezone'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'gamezone')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'gamezone'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'gamezone')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'gamezone'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'gamezone')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'gamezone'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'gamezone')
							),
			)
		);
		gamezone_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'gamezone'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'gamezone')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'gamezone'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'gamezone')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'gamezone'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'gamezone')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'gamezone'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'gamezone')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'gamezone'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'gamezone')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'gamezone'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'gamezone')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'gamezone'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'gamezone')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'gamezone'),
							'description'	=> esc_html__('Color of the links inside this block', 'gamezone')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'gamezone'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'gamezone')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'gamezone'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'gamezone')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'gamezone'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'gamezone')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'gamezone'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'gamezone')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'gamezone'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'gamezone')
							)
			)
		);
		gamezone_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'gamezone'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff',//+
					'bd_color'			=> '#efeff0',//+
		
					// Text and links colors
					'text'				=> '#727279',//+
					'text_light'		=> '#94949b',//+
					'text_dark'			=> '#1c192c',//+
					'text_link'			=> '#28ae4e',//+
					'text_hover'		=> '#149739',//+
					'text_link2'		=> '#ee5307',//+
					'text_hover2'		=> '#e25008',//+
					'text_link3'		=> '#fec632',//+
					'text_hover3'		=> '#eeb82b',//+
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f6f6f6',//+
					'alter_bg_hover'	=> '#f2f2f2',//+
					'alter_bd_color'	=> '#ededed',//+
					'alter_bd_hover'	=> '#12101c',//+
					'alter_text'		=> '#727279',//+
					'alter_light'		=> '#898989',//+
					'alter_dark'		=> '#1c192c',//+
					'alter_link'		=> '#28ae4e',//+
					'alter_hover'		=> '#1c192c',//+
					'alter_link2'		=> '#ee5307',//+
					'alter_hover2'		=> '#e25008',//+
					'alter_link3'		=> '#fec632',//+
					'alter_hover3'		=> '#eeb82b',//+
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1c192c',//+
					'extra_bg_hover'	=> '#2e3846',//+
					'extra_bd_color'	=> '#343434',//+
					'extra_bd_hover'	=> '#2e3846',//+
					'extra_text'		=> '#898989',//+
					'extra_light'		=> '#afafaf',//+
					'extra_dark'		=> '#cdcdd5',//+
					'extra_link'		=> '#ffffff',//+
					'extra_hover'		=> '#e0041d',//+
					'extra_link2'		=> '#1c192c',//+
					'extra_hover2'		=> '#a8a8a8',//+
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#ffffff',//+
					'input_bg_hover'	=> '#ffffff',//+
					'input_bd_color'	=> '#ededed',//+
					'input_bd_hover'	=> '#1c192c',//+
					'input_text'		=> '#727279',//+
					'input_light'		=> '#a7a7a7',
					'input_dark'		=> '#0f1214',//+
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#ffffff',//+
					'inverse_light'		=> '#f9fafb',//+
					'inverse_dark'		=> '#1d1d1d',//+
					'inverse_link'		=> '#ffffff',//+
					'inverse_hover'		=> '#ffffff' //+
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'gamezone'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#1c192c',//+
					'bd_color'			=> '#3b4044',//+
		
					// Text and links colors
					'text'				=> '#cdcdd5',//+
					'text_light'		=> '#cdcdd5',//+
					'text_dark'			=> '#ffffff',//+
					'text_link'			=> '#28ae4e',//+
					'text_hover'		=> '#149739',//+
					'text_link2'		=> '#ee5307',//+
					'text_hover2'		=> '#e25008',//+
					'text_link3'		=> '#fec632',//+
					'text_hover3'		=> '#eeb82b',//+

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#12101c',//+
					'alter_bg_hover'	=> '#232033',//+
					'alter_bd_color'	=> '#2b2f33',//+
					'alter_bd_hover'	=> '#4a4a4a',
					'alter_text'		=> '#cdcdd5',//+
					'alter_light'		=> '#b0b0bb',//+
					'alter_dark'		=> '#ffffff',//+
					'alter_link'		=> '#28ae4e',//+
					'alter_hover'		=> '#149739',//+
					'alter_link2'		=> '#ee5307',//+
					'alter_hover2'		=> '#e25008',//+
					'alter_link3'		=> '#fec632',//+
					'alter_hover3'		=> '#eeb82b',//+

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#ffffff',//+
					'extra_bg_hover'	=> '#f3f5f7',//+
					'extra_bd_color'	=> '#e5e5e5',//+
					'extra_bd_hover'	=> '#2e3846',//+
					'extra_text'		=> '#333333',//+
					'extra_light'		=> '#b7b7b7',//+
					'extra_dark'		=> '#1c192c',//+
					'extra_link'		=> '#28ae4e',//+
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#1c192c',//+
					'extra_hover2'		=> '#a8a8a8',//+
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#0f1214',//+
					'input_bg_hover'	=> '#1c192c',//+
					'input_bd_color'	=> '#2e2d32',
					'input_bd_hover'	=> '#4a4957',//+
					'input_text'		=> '#f4f4f4',//+
					'input_light'		=> '#5f5f5f',
					'input_dark'		=> '#f4f4f4',//+
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#f4f4f4',//+
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#1d1d1d',//+
					'inverse_link'		=> '#ffffff',//+
					'inverse_hover'		=> '#ffffff' //+
				)
			)
		
		));
		
		// Simple schemes substitution
		gamezone_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		gamezone_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' => 0.9),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_color_06'	=> array('color' => 'alter_bg_color',	'alpha' => 0.6),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'alter_link_02'		=> array('color' => 'alter_link',		'alpha' => 0.2),
			'alter_link_07'		=> array('color' => 'alter_link',		'alpha' => 0.7),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'extra_link_02'		=> array('color' => 'extra_link',		'alpha' => 0.2),
			'extra_link_07'		=> array('color' => 'extra_link',		'alpha' => 0.7),
			'text_dark_09'		=> array('color' => 'text_dark',		'alpha' => 0.9),
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'text_dark_045'		=> array('color' => 'text_dark',		'alpha' => 0.45),
			'text_dark_04'		=> array('color' => 'text_dark',		'alpha' => 0.4),
			'text_dark_03'		=> array('color' => 'text_dark',		'alpha' => 0.3),
			'text_dark_02'		=> array('color' => 'text_dark',		'alpha' => 0.2),
			'text_dark_005'		=> array('color' => 'text_dark',		'alpha' => 0.05),
			'text_dark_017'		=> array('color' => 'text_dark',		'alpha' => 0.17),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'extra_link2_00'		=> array('color' => 'extra_link2',		'alpha' => 0.0),
			'extra_link2_07'		=> array('color' => 'extra_link2',		'alpha' => 0.7),
			'extra_link2_03'		=> array('color' => 'extra_link2',		'alpha' => 0.3),
			'extra_link2_09'		=> array('color' => 'extra_link2',		'alpha' => 0.9),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		gamezone_storage_set('theme_thumbs', apply_filters('gamezone_filter_add_thumb_sizes', array(
			'gamezone-thumb-huge'		=> array(
												'size'	=> array(1170, 658, true),
												'title' => esc_html__( 'Huge image', 'gamezone' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			'gamezone-thumb-big' 		=> array(
												'size'	=> array( 760, 567, true),
												'title' => esc_html__( 'Large image', 'gamezone' ),
												'subst'	=> 'trx_addons-thumb-big'
												),


			'gamezone-thumb-med' 		=> array(
												'size'	=> array( 370, 252, true),
												'title' => esc_html__( 'Medium image', 'gamezone' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			'gamezone-thumb-tiny' 		=> array(
												'size'	=> array(  90,  90, true),
												'title' => esc_html__( 'Small square avatar', 'gamezone' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),

			'gamezone-thumb-masonry-big' => array(
												'size'	=> array( 760,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'gamezone' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			'gamezone-thumb-masonry'		=> array(
												'size'	=> array( 370,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'gamezone' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												),
			'gamezone-thumb-big-avatar' 		=> array(
												'size'	=> array( 600, 550, true),
												'title' => esc_html__( 'Large avatar image', 'gamezone' ),
												'subst'	=> 'trx_addons-thumb-big-avatar'
												),
			'gamezone-thumb-big-med'		=> array(
												'size'	=> array( 600, 430, true),
												'title' => esc_html__( 'Large medium image', 'gamezone' ),
												'subst'	=> 'trx_addons-thumb-big-med'
												)
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'gamezone_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'gamezone_importer_set_options', 9 );
	function gamezone_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(gamezone_get_protocol() . '://demofiles.themerex.net/gamezone/');
			// Required plugins
			$options['required_plugins'] = array_keys(gamezone_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('Gamezone Demo', 'gamezone');
			$options['files']['default']['domain_dev'] = esc_url('https://gamezone.themerex.net');		// Developers domain
			$options['files']['default']['domain_demo']= esc_url('https://gamezone.themerex.net');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// Banners
			$options['banners'] = array(
				array(
					'image' => gamezone_get_file_url('theme-specific/theme-about/images/frontpage.png'),
					'title' => esc_html__('Front Page Builder', 'gamezone'),
					'content' => wp_kses(__("Create your front page right in the WordPress Customizer. There's no need in WPBakery Page Builder, or any other builder. Simply enable/disable sections, fill them out with content, and customize to your liking.", 'gamezone'), 'gamezone_kses_content'),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('Watch Video Introduction', 'gamezone'),
					'duration' => 20
					),
				array(
					'image' => gamezone_get_file_url('theme-specific/theme-about/images/layouts.png'),
					'title' => esc_html__('Layouts Builder', 'gamezone'),
					'content' => wp_kses(__('Use Layouts Builder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'gamezone'), 'gamezone_kses_content'),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('Learn More', 'gamezone'),
					'duration' => 20
					),
				array(
					'image' => gamezone_get_file_url('theme-specific/theme-about/images/documentation.png'),
					'title' => esc_html__('Read Full Documentation', 'gamezone'),
					'content' => wp_kses(__('Need more details? Please check our full online documentation for detailed information on how to use Gamezone.', 'gamezone'), 'gamezone_kses_content'),
					'link_url' => esc_url(gamezone_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online Documentation', 'gamezone'),
					'duration' => 15
					),
				array(
					'image' => gamezone_get_file_url('theme-specific/theme-about/images/video-tutorials.png'),
					'title' => esc_html__('Video Tutorials', 'gamezone'),
					'content' => wp_kses(__('No time for reading documentation? Check out our video tutorials and learn how to customize Gamezone in detail.', 'gamezone'), 'gamezone_kses_content'),
					'link_url' => esc_url(gamezone_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video Tutorials', 'gamezone'),
					'duration' => 15
					),
				array(
					'image' => gamezone_get_file_url('theme-specific/theme-about/images/studio.png'),
					'title' => esc_html__('Website Customization', 'gamezone'),
					'content' => wp_kses(__("Need a website fast? Order our custom service, and we'll build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.", 'gamezone'), 'gamezone_kses_content'),
					esc_url('//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall'),
					'link_caption' => esc_html__('Contact Us', 'gamezone'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('gamezone_create_theme_options')) {

	function gamezone_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __('<b>Attention!</b> Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'gamezone');

		gamezone_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'gamezone'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'gamezone'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'gamezone'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'gamezone') ),
				"class" => "gamezone_column-1_2 gamezone_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'gamezone'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'gamezone') ),
				"class" => "gamezone_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_zoom' => array(
				"title" => esc_html__('Logo zoom', 'gamezone'),
				"desc" => wp_kses_data( __("Zoom the logo. 1 - original size. Maximum size of logo depends on the actual size of the picture", 'gamezone') ),
				"std" => 1,
				"min" => 0.2,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'gamezone'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'gamezone') ),
				"class" => "gamezone_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'gamezone'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'gamezone') ),
				"class" => "gamezone_column-1_2 gamezone_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'gamezone'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'gamezone') ),
				"class" => "gamezone_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'gamezone'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'gamezone') ),
				"class" => "gamezone_column-1_2 gamezone_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'gamezone'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'gamezone') ),
				"class" => "gamezone_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "image"
				),

			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'gamezone'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'gamezone'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'gamezone'),
				"desc" => wp_kses_data( __('Select width of the body content', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'gamezone')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => gamezone_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'gamezone'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'gamezone') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'gamezone')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'gamezone'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'gamezone')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'gamezone'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'gamezone'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'gamezone')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'gamezone'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'gamezone')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'gamezone'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'gamezone') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'gamezone'),
				"desc" => '',
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'gamezone'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'gamezone')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'gamezone'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'gamezone')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'gamezone'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'gamezone')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'gamezone'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'gamezone')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
				),



			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'gamezone'),
				"desc" => '',
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'gamezone'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'gamezone') ),
				"std" => 0,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'gamezone'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'gamezone') ),
                "std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'gamezone'), 'gamezone_kses_content' ),
                "type"  => "text"
            ),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'gamezone'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'gamezone'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'gamezone'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone')
				),
				"std" => 'default',
				"options" => gamezone_get_list_header_footer_types(),
				"type" => GAMEZONE_THEME_FREE || !gamezone_exists_trx_addons() ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'gamezone'),
				"desc" => wp_kses( __("Select custom header from Layouts Builder", 'gamezone'), 'gamezone_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => GAMEZONE_THEME_FREE ? 'header-custom-sow-header-default' : 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'gamezone'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone')
				),
				"std" => 'default',
				"options" => array(),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'gamezone'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone')
				),
				"std" => 0,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'gamezone'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'gamezone') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwidth', 'gamezone'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'gamezone'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'gamezone') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'gamezone'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'gamezone') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'gamezone'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => gamezone_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'gamezone'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'gamezone') ),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'gamezone'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'gamezone')

				),
				"type" => GAMEZONE_THEME_FREE || !gamezone_exists_trx_addons() ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'gamezone'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'gamezone'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'gamezone')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'gamezone'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'gamezone') ),
				"std" => 1,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'gamezone'),
				"desc" => '',
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'gamezone'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'gamezone') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'gamezone')
				),
				"std" => 0,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'gamezone'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'gamezone') ),
				"priority" => 500,
				"dependency" => array(
					'header_type' => array('default')
				),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'gamezone'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'gamezone') ),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 0,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'gamezone'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'gamezone') ),
				"std" => '',
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'gamezone'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'gamezone'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'gamezone'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'gamezone'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'gamezone'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'gamezone'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'gamezone'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'gamezone')
				),
				"std" => 'default',
				"options" => gamezone_get_list_header_footer_types(),
				"type" => GAMEZONE_THEME_FREE || !gamezone_exists_trx_addons() ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'gamezone'),
				"desc" => wp_kses( __("Select custom footer from Layouts Builder", 'gamezone'), 'gamezone_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'gamezone')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => GAMEZONE_THEME_FREE ? 'footer-custom-sow-footer-default' : 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'gamezone'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'gamezone')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'gamezone'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'gamezone')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => gamezone_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwidth', 'gamezone'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'gamezone') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'gamezone')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'gamezone'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'gamezone') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'gamezone'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'gamezone') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'gamezone'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'gamezone') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'gamezone'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'gamezone') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => !gamezone_exists_trx_addons() ? "hidden" : "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'gamezone'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'gamezone') ),
				"translate" => true,
				"std" => esc_html__('Copyright &copy; {Y} by ThemeREX. All rights reserved.', 'gamezone'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'gamezone'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'gamezone') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'gamezone'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'gamezone') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'gamezone'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'gamezone'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'gamezone'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'gamezone') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'gamezone'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'gamezone') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'gamezone'),
						'fullpost'	=> esc_html__('Full post',	'gamezone')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'gamezone'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'gamezone') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 60,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'gamezone'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'gamezone') ),
					"std" => 2,
					"options" => gamezone_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'gamezone'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'gamezone') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'gamezone'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'gamezone') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'gamezone'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'gamezone') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'gamezone'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'gamezone') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'gamezone'),
						'links'	=> esc_html__("Older/Newest", 'gamezone'),
						'more'	=> esc_html__("Load more", 'gamezone'),
						'infinite' => esc_html__("Infinite scroll", 'gamezone')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'gamezone'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'gamezone') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'gamezone'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'gamezone'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'gamezone') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'gamezone'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'gamezone') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'gamezone'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'gamezone') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'gamezone'),
					"desc" => '',
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'gamezone'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'gamezone') ),
					"std" => 'hide',
					"options" => array(),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'gamezone'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'gamezone') ),
					"std" => 'hide',
					"options" => array(),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'gamezone'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'gamezone') ),
					"std" => 'hide',
					"options" => array(),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'gamezone'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'gamezone') ),
					"std" => 'hide',
					"options" => array(),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'gamezone'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'gamezone'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'gamezone') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'gamezone'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'gamezone') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'gamezone'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'gamezone') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'gamezone'),
						'columns' => esc_html__('Mini-cards',	'gamezone')
					),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'gamezone'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'gamezone') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'gamezone'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'gamezone') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'gamezone') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=0|date=1|counters=1|author=0|share=0|edit=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'gamezone'),
						'date'		 => esc_html__('Post date', 'gamezone'),
						'author'	 => esc_html__('Post author', 'gamezone'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'gamezone'),
						'share'		 => esc_html__('Share links', 'gamezone'),
						'edit'		 => esc_html__('Edit link', 'gamezone')
					),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'gamezone'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'gamezone') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'gamezone')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'gamezone'),
						'likes' => esc_html__('Likes', 'gamezone'),
						'comments' => esc_html__('Comments', 'gamezone')
					),
					"type" => GAMEZONE_THEME_FREE || !gamezone_exists_trx_addons() ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'gamezone'),
					"desc" => wp_kses_data( __('Settings of the single post', 'gamezone') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'gamezone'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'gamezone') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'gamezone')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'gamezone'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'gamezone') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'gamezone'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'gamezone') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'gamezone'),
					"desc" => wp_kses_data( __("Meta parts for single posts. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'gamezone') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'gamezone') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'gamezone'),
						'date'		 => esc_html__('Post date', 'gamezone'),
						'author'	 => esc_html__('Post author', 'gamezone'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'gamezone'),
						'share'		 => esc_html__('Share links', 'gamezone'),
						'edit'		 => esc_html__('Edit link', 'gamezone')
					),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'gamezone'),
					"desc" => wp_kses_data( __("Likes and Views are available only if plugin ThemeREX Addons is active", 'gamezone') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'gamezone'),
						'likes' => esc_html__('Likes', 'gamezone'),
						'comments' => esc_html__('Comments', 'gamezone')
					),
					"type" => GAMEZONE_THEME_FREE || !gamezone_exists_trx_addons() ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'gamezone'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'gamezone') ),
					"std" => 1,
					"type" => !gamezone_exists_trx_addons() ? "hidden" : "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'gamezone'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'gamezone') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'gamezone'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'gamezone'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'gamezone') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'gamezone')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'gamezone'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'gamezone') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => gamezone_get_list_range(1,9),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'gamezone'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'gamezone') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => gamezone_get_list_range(1,4),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "switch"
					),
				'related_style' => array(
					"title" => esc_html__('Related posts style', 'gamezone'),
					"desc" => wp_kses_data( __('Select style of the related posts output', 'gamezone') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => gamezone_get_list_styles(1,2),
					"type" => GAMEZONE_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'gamezone'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'gamezone'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'gamezone') ),
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'gamezone'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'gamezone')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'gamezone'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'gamezone')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'gamezone'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'gamezone')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'gamezone'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'gamezone')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'gamezone'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'gamezone')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'gamezone'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'gamezone') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'gamezone'),
				"desc" => '',
				"std" => '$gamezone_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'gamezone'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'gamezone') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'gamezone')
				),
				"hidden" => true,
				"std" => '',
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'gamezone'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'gamezone') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'gamezone')
				),
				"hidden" => true,
				"std" => '',
				"type" => GAMEZONE_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'gamezone'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'gamezone'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'gamezone') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'gamezone') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'gamezone'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'gamezone') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'gamezone') ),
				"class" => "gamezone_column-1_3 gamezone_new_row",
				"refresh" => false,
				"std" => '$gamezone_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=gamezone_get_theme_setting('max_load_fonts'); $i++) {
			if (gamezone_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(__('Font %s', 'gamezone'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'gamezone'),
				"desc" => '',
				"class" => "gamezone_column-1_3 gamezone_new_row",
				"refresh" => false,
				"std" => '$gamezone_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'gamezone'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'gamezone') )
							: '',
				"class" => "gamezone_column-1_3",
				"refresh" => false,
				"std" => '$gamezone_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'gamezone'),
					'serif' => esc_html__('serif', 'gamezone'),
					'sans-serif' => esc_html__('sans-serif', 'gamezone'),
					'monospace' => esc_html__('monospace', 'gamezone'),
					'cursive' => esc_html__('cursive', 'gamezone'),
					'fantasy' => esc_html__('fantasy', 'gamezone')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'gamezone'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'gamezone') )
								. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'gamezone') )
							: '',
				"class" => "gamezone_column-1_3",
				"refresh" => false,
				"std" => '$gamezone_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = gamezone_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(__('%s settings', 'gamezone'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses( sprintf(__('Font settings of the "%s" tag.', 'gamezone'), $tag), 'gamezone_kses_content' ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$load_order = 1;
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
					$load_order = 2;		// Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'gamezone'),
						'100' => esc_html__('100 (Light)', 'gamezone'), 
						'200' => esc_html__('200 (Light)', 'gamezone'), 
						'300' => esc_html__('300 (Thin)',  'gamezone'),
						'400' => esc_html__('400 (Normal)', 'gamezone'),
						'500' => esc_html__('500 (Semibold)', 'gamezone'),
						'600' => esc_html__('600 (Semibold)', 'gamezone'),
						'700' => esc_html__('700 (Bold)', 'gamezone'),
						'800' => esc_html__('800 (Black)', 'gamezone'),
						'900' => esc_html__('900 (Black)', 'gamezone')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'gamezone'),
						'normal' => esc_html__('Normal', 'gamezone'), 
						'italic' => esc_html__('Italic', 'gamezone')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'gamezone'),
						'none' => esc_html__('None', 'gamezone'), 
						'underline' => esc_html__('Underline', 'gamezone'),
						'overline' => esc_html__('Overline', 'gamezone'),
						'line-through' => esc_html__('Line-through', 'gamezone')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'gamezone'),
						'none' => esc_html__('None', 'gamezone'), 
						'uppercase' => esc_html__('Uppercase', 'gamezone'),
						'lowercase' => esc_html__('Lowercase', 'gamezone'),
						'capitalize' => esc_html__('Capitalize', 'gamezone')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "gamezone_column-1_5",
					"refresh" => false,
					"load_order" => $load_order,
					"std" => '$gamezone_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		gamezone_storage_set_array_before('options', 'panel_colors', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			gamezone_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'gamezone'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'gamezone') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'gamezone')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			gamezone_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'gamezone'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'gamezone') ),
				"class" => "gamezone_column-1_2 gamezone_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('gamezone_options_get_list_cpt_options')) {
	function gamezone_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'gamezone'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'gamezone'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'gamezone') ),
						"std" => 'inherit',
						"options" => gamezone_get_list_header_footer_types(true),
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'gamezone'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'gamezone'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'gamezone'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'gamezone'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'gamezone'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'gamezone') ),
						"std" => 0,
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "checkbox"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'gamezone'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'gamezone'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'gamezone'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'gamezone'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'gamezone'), $title) ),
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'gamezone'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'gamezone'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'gamezone'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'gamezone') ),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'gamezone'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'gamezone'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'gamezone') ),
						"std" => 'inherit',
						"options" => gamezone_get_list_header_footer_types(true),
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'gamezone'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'gamezone') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'gamezone'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'gamezone') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'gamezone'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'gamezone') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => gamezone_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwidth', 'gamezone'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'gamezone') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'gamezone'),
						"desc" => '',
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'gamezone'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'gamezone') ),
						"std" => 'hide',
						"options" => array(),
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'gamezone'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'gamezone') ),
						"std" => 'hide',
						"options" => array(),
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'gamezone'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'gamezone') ),
						"std" => 'hide',
						"options" => array(),
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'gamezone'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'gamezone') ),
						"std" => 'hide',
						"options" => array(),
						"type" => GAMEZONE_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('gamezone_options_get_list_choises')) {
	add_filter('gamezone_filter_options_get_list_choises', 'gamezone_options_get_list_choises', 10, 2);
	function gamezone_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = gamezone_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = gamezone_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = gamezone_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (strpos($id, '_scheme') > 0)
				$list = gamezone_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = gamezone_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = gamezone_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = gamezone_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = gamezone_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = gamezone_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = gamezone_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = gamezone_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = gamezone_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = gamezone_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = gamezone_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = gamezone_array_merge(array(0 => esc_html__('- Select category -', 'gamezone')), gamezone_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = gamezone_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = gamezone_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = gamezone_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>