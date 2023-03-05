<div class="front_page_section front_page_section_googlemap<?php
			$gamezone_scheme = gamezone_get_theme_option('front_page_googlemap_scheme');
			if (!gamezone_is_inherit($gamezone_scheme)) echo ' scheme_'.esc_attr($gamezone_scheme);
			echo ' front_page_section_paddings_'.esc_attr(gamezone_get_theme_option('front_page_googlemap_paddings'));
		?>"<?php
		$gamezone_css = '';
		$gamezone_bg_image = gamezone_get_theme_option('front_page_googlemap_bg_image');
		if (!empty($gamezone_bg_image)) 
			$gamezone_css .= 'background-image: url('.esc_url(gamezone_get_attachment_url($gamezone_bg_image)).');';
		if (!empty($gamezone_css))
			echo ' style="' . esc_attr($gamezone_css) . '"';
?>><?php
	// Add anchor
	$gamezone_anchor_icon = gamezone_get_theme_option('front_page_googlemap_anchor_icon');	
	$gamezone_anchor_text = gamezone_get_theme_option('front_page_googlemap_anchor_text');	
	if ((!empty($gamezone_anchor_icon) || !empty($gamezone_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_googlemap"'
										. (!empty($gamezone_anchor_icon) ? ' icon="'.esc_attr($gamezone_anchor_icon).'"' : '')
										. (!empty($gamezone_anchor_text) ? ' title="'.esc_attr($gamezone_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_googlemap_inner<?php
			if (gamezone_get_theme_option('front_page_googlemap_fullheight'))
				echo ' gamezone-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$gamezone_css = '';
			$gamezone_bg_mask = gamezone_get_theme_option('front_page_googlemap_bg_mask');
			$gamezone_bg_color = gamezone_get_theme_option('front_page_googlemap_bg_color');
			if (!empty($gamezone_bg_color) && $gamezone_bg_mask > 0)
				$gamezone_css .= 'background-color: '.esc_attr($gamezone_bg_mask==1
																	? $gamezone_bg_color
																	: gamezone_hex2rgba($gamezone_bg_color, $gamezone_bg_mask)
																).';';
			if (!empty($gamezone_css))
				echo ' style="' . esc_attr($gamezone_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap<?php
			$gamezone_layout = gamezone_get_theme_option('front_page_googlemap_layout');
			if ($gamezone_layout != 'fullwidth')
				echo ' content_wrap';
		?>">
			<?php
			// Content wrap with title and description
			$gamezone_caption = gamezone_get_theme_option('front_page_googlemap_caption');
			$gamezone_description = gamezone_get_theme_option('front_page_googlemap_description');
			if (!empty($gamezone_caption) || !empty($gamezone_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($gamezone_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
					// Caption
					if (!empty($gamezone_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo !empty($gamezone_caption) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses($gamezone_caption, 'gamezone_kses_content');
						?></h2><?php
					}
				
					// Description (text)
					if (!empty($gamezone_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo !empty($gamezone_description) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses(wpautop($gamezone_description), 'gamezone_kses_content');
						?></div><?php
					}
				if ($gamezone_layout == 'fullwidth') {
					?></div><?php
				}
			}

			// Content (text)
			$gamezone_content = gamezone_get_theme_option('front_page_googlemap_content');
			if (!empty($gamezone_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($gamezone_layout == 'columns') {
					?><div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} else if ($gamezone_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
	
				?><div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo !empty($gamezone_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses($gamezone_content, 'gamezone_kses_content');
				?></div><?php
	
				if ($gamezone_layout == 'columns') {
					?></div><div class="column-2_3"><?php
				} else if ($gamezone_layout == 'fullwidth') {
					?></div><?php
				}
			}
			
			// Widgets output
			?><div class="front_page_section_output front_page_section_googlemap_output"><?php 
				if (is_active_sidebar('front_page_googlemap_widgets')) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!gamezone_exists_trx_addons())
						gamezone_customizer_need_trx_addons_message();
					else
						gamezone_customizer_need_widgets_message('front_page_googlemap_caption', 'ThemeREX Addons - Google map');
				}
			?></div><?php

			if ($gamezone_layout == 'columns' && (!empty($gamezone_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>