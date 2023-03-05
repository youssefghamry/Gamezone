<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

// Page (category, tag, archive, author) title

if ( gamezone_need_page_title() ) {
	gamezone_sc_layouts_showed('title', true);
	gamezone_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								gamezone_show_post_meta(apply_filters('gamezone_filter_post_meta_args', array(
									'components' => gamezone_array_get_keys_by_value(gamezone_get_theme_option('meta_parts')),
									'counters' => gamezone_array_get_keys_by_value(gamezone_get_theme_option('counters')),
									'seo' => gamezone_is_on(gamezone_get_theme_option('seo_snippets'))
									), 'header', 1)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$gamezone_blog_title = gamezone_get_blog_title();
							$gamezone_blog_title_text = $gamezone_blog_title_class = $gamezone_blog_title_link = $gamezone_blog_title_link_text = '';
							if (is_array($gamezone_blog_title)) {
								$gamezone_blog_title_text = $gamezone_blog_title['text'];
								$gamezone_blog_title_class = !empty($gamezone_blog_title['class']) ? ' '.$gamezone_blog_title['class'] : '';
								$gamezone_blog_title_link = !empty($gamezone_blog_title['link']) ? $gamezone_blog_title['link'] : '';
								$gamezone_blog_title_link_text = !empty($gamezone_blog_title['link_text']) ? $gamezone_blog_title['link_text'] : '';
							} else
								$gamezone_blog_title_text = $gamezone_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($gamezone_blog_title_class); ?>"><?php
								$gamezone_top_icon = gamezone_get_category_icon();
								if (!empty($gamezone_top_icon)) {
									$gamezone_attr = gamezone_getimagesize($gamezone_top_icon);
									?><img src="<?php echo esc_url($gamezone_top_icon); ?>" alt="<?php echo esc_attr__('img', 'gamezone'); ?>" <?php if (!empty($gamezone_attr[3])) gamezone_show_layout($gamezone_attr[3]);?>><?php
								}
								echo wp_kses_post($gamezone_blog_title_text);
							?></h1>
							<?php
							if (!empty($gamezone_blog_title_link) && !empty($gamezone_blog_title_link_text)) {
								?><a href="<?php echo esc_url($gamezone_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($gamezone_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'gamezone_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>