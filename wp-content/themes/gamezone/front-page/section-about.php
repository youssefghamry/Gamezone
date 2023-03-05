<div class="front_page_section front_page_section_about<?php
			$gamezone_scheme = gamezone_get_theme_option('front_page_about_scheme');
			if (!gamezone_is_inherit($gamezone_scheme)) echo ' scheme_'.esc_attr($gamezone_scheme);
			echo ' front_page_section_paddings_'.esc_attr(gamezone_get_theme_option('front_page_about_paddings'));
		?>"<?php
		$gamezone_css = '';
		$gamezone_bg_image = gamezone_get_theme_option('front_page_about_bg_image');
		if (!empty($gamezone_bg_image)) 
			$gamezone_css .= 'background-image: url('.esc_url(gamezone_get_attachment_url($gamezone_bg_image)).');';
		if (!empty($gamezone_css))
			echo ' style="' . esc_attr($gamezone_css) . '"';
?>><?php
	// Add anchor
	$gamezone_anchor_icon = gamezone_get_theme_option('front_page_about_anchor_icon');	
	$gamezone_anchor_text = gamezone_get_theme_option('front_page_about_anchor_text');	
	if ((!empty($gamezone_anchor_icon) || !empty($gamezone_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_about"'
										. (!empty($gamezone_anchor_icon) ? ' icon="'.esc_attr($gamezone_anchor_icon).'"' : '')
										. (!empty($gamezone_anchor_text) ? ' title="'.esc_attr($gamezone_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_about_inner<?php
			if (gamezone_get_theme_option('front_page_about_fullheight'))
				echo ' gamezone-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$gamezone_css = '';
			$gamezone_bg_mask = gamezone_get_theme_option('front_page_about_bg_mask');
			$gamezone_bg_color = gamezone_get_theme_option('front_page_about_bg_color');
			if (!empty($gamezone_bg_color) && $gamezone_bg_mask > 0)
				$gamezone_css .= 'background-color: '.esc_attr($gamezone_bg_mask==1
																	? $gamezone_bg_color
																	: gamezone_hex2rgba($gamezone_bg_color, $gamezone_bg_mask)
																).';';
			if (!empty($gamezone_css))
				echo ' style="' . esc_attr($gamezone_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$gamezone_caption = gamezone_get_theme_option('front_page_about_caption');
			if (!empty($gamezone_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo !empty($gamezone_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($gamezone_caption, 'gamezone_kses_content'); ?></h2><?php
			}
		
			// Description (text)
			$gamezone_description = gamezone_get_theme_option('front_page_about_description');
			if (!empty($gamezone_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo !empty($gamezone_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($gamezone_description), 'gamezone_kses_content'); ?></div><?php
			}
			
			// Content
			$gamezone_content = gamezone_get_theme_option('front_page_about_content');
			if (!empty($gamezone_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo !empty($gamezone_content) ? 'filled' : 'empty'; ?>"><?php
					$gamezone_page_content_mask = '%%CONTENT%%';
					if (strpos($gamezone_content, $gamezone_page_content_mask) !== false) {
						$gamezone_content = preg_replace(
									'/(\<p\>\s*)?'.$gamezone_page_content_mask.'(\s*\<\/p\>)/i',
									sprintf('<div class="front_page_section_about_source">%s</div>',
												apply_filters('the_content', get_the_content())),
									$gamezone_content
									);
					}
					gamezone_show_layout($gamezone_content);
				?></div><?php
			}
			?>
		</div>
	</div>
</div>