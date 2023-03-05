<div class="front_page_section front_page_section_woocommerce<?php
			$gamezone_scheme = gamezone_get_theme_option('front_page_woocommerce_scheme');
			if (!gamezone_is_inherit($gamezone_scheme)) echo ' scheme_'.esc_attr($gamezone_scheme);
			echo ' front_page_section_paddings_'.esc_attr(gamezone_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$gamezone_css = '';
		$gamezone_bg_image = gamezone_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($gamezone_bg_image)) 
			$gamezone_css .= 'background-image: url('.esc_url(gamezone_get_attachment_url($gamezone_bg_image)).');';
		if (!empty($gamezone_css))
			echo ' style="' . esc_attr($gamezone_css) . '"';
?>><?php
	// Add anchor
	$gamezone_anchor_icon = gamezone_get_theme_option('front_page_woocommerce_anchor_icon');	
	$gamezone_anchor_text = gamezone_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($gamezone_anchor_icon) || !empty($gamezone_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($gamezone_anchor_icon) ? ' icon="'.esc_attr($gamezone_anchor_icon).'"' : '')
										. (!empty($gamezone_anchor_text) ? ' title="'.esc_attr($gamezone_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (gamezone_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' gamezone-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$gamezone_css = '';
			$gamezone_bg_mask = gamezone_get_theme_option('front_page_woocommerce_bg_mask');
			$gamezone_bg_color = gamezone_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($gamezone_bg_color) && $gamezone_bg_mask > 0)
				$gamezone_css .= 'background-color: '.esc_attr($gamezone_bg_mask==1
																	? $gamezone_bg_color
																	: gamezone_hex2rgba($gamezone_bg_color, $gamezone_bg_mask)
																).';';
			if (!empty($gamezone_css))
				echo ' style="' . esc_attr($gamezone_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$gamezone_caption = gamezone_get_theme_option('front_page_woocommerce_caption');
			$gamezone_description = gamezone_get_theme_option('front_page_woocommerce_description');
			if (!empty($gamezone_caption) || !empty($gamezone_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($gamezone_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($gamezone_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($gamezone_caption, 'gamezone_kses_content');
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($gamezone_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($gamezone_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($gamezone_description), 'gamezone_kses_content');
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$gamezone_woocommerce_sc = gamezone_get_theme_option('front_page_woocommerce_products');
				if ($gamezone_woocommerce_sc == 'products') {
					$gamezone_woocommerce_sc_ids = gamezone_get_theme_option('front_page_woocommerce_products_per_page');
					$gamezone_woocommerce_sc_per_page = count(explode(',', $gamezone_woocommerce_sc_ids));
				} else {
					$gamezone_woocommerce_sc_per_page = max(1, (int) gamezone_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$gamezone_woocommerce_sc_columns = max(1, min($gamezone_woocommerce_sc_per_page, (int) gamezone_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$gamezone_woocommerce_sc}"
									. ($gamezone_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($gamezone_woocommerce_sc_ids).'"' 
											: '')
									. ($gamezone_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(gamezone_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($gamezone_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(gamezone_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(gamezone_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($gamezone_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($gamezone_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>