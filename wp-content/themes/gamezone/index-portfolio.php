<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

gamezone_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	gamezone_show_layout(get_query_var('blog_archive_start'));

	$gamezone_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$gamezone_sticky_out = gamezone_get_theme_option('sticky_style')=='columns' 
							&& is_array($gamezone_stickies) && count($gamezone_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$gamezone_cat = gamezone_get_theme_option('parent_cat');
	$gamezone_post_type = gamezone_get_theme_option('post_type');
	$gamezone_taxonomy = gamezone_get_post_type_taxonomy($gamezone_post_type);
	$gamezone_show_filters = gamezone_get_theme_option('show_filters');
	$gamezone_tabs = array();
	if (!gamezone_is_off($gamezone_show_filters)) {
		$gamezone_args = array(
			'type'			=> $gamezone_post_type,
			'child_of'		=> $gamezone_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $gamezone_taxonomy,
			'pad_counts'	=> false
		);
		$gamezone_portfolio_list = get_terms($gamezone_args);
		if (is_array($gamezone_portfolio_list) && count($gamezone_portfolio_list) > 0) {
			$gamezone_tabs[$gamezone_cat] = esc_html__('All', 'gamezone');
			foreach ($gamezone_portfolio_list as $gamezone_term) {
				if (isset($gamezone_term->term_id)) $gamezone_tabs[$gamezone_term->term_id] = $gamezone_term->name;
			}
		}
	}
	if (count($gamezone_tabs) > 0) {
		$gamezone_portfolio_filters_ajax = true;
		$gamezone_portfolio_filters_active = $gamezone_cat;
		$gamezone_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters gamezone_tabs gamezone_tabs_ajax">
			<ul class="portfolio_titles gamezone_tabs_titles">
				<?php
				foreach ($gamezone_tabs as $gamezone_id=>$gamezone_title) {
					?><li><a href="<?php echo esc_url(gamezone_get_hash_link(sprintf('#%s_%s_content', $gamezone_portfolio_filters_id, $gamezone_id))); ?>" data-tab="<?php echo esc_attr($gamezone_id); ?>"><?php echo esc_html($gamezone_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$gamezone_ppp = gamezone_get_theme_option('posts_per_page');
			if (gamezone_is_inherit($gamezone_ppp)) $gamezone_ppp = '';
			foreach ($gamezone_tabs as $gamezone_id=>$gamezone_title) {
				$gamezone_portfolio_need_content = $gamezone_id==$gamezone_portfolio_filters_active || !$gamezone_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $gamezone_portfolio_filters_id, $gamezone_id)); ?>"
					class="portfolio_content gamezone_tabs_content"
					data-blog-template="<?php echo esc_attr(gamezone_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(gamezone_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($gamezone_ppp); ?>"
					data-post-type="<?php echo esc_attr($gamezone_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($gamezone_taxonomy); ?>"
					data-cat="<?php echo esc_attr($gamezone_id); ?>"
					data-parent-cat="<?php echo esc_attr($gamezone_cat); ?>"
					data-need-content="<?php echo (false===$gamezone_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($gamezone_portfolio_need_content) 
						gamezone_show_portfolio_posts(array(
							'cat' => $gamezone_id,
							'parent_cat' => $gamezone_cat,
							'taxonomy' => $gamezone_taxonomy,
							'post_type' => $gamezone_post_type,
							'page' => 1,
							'sticky' => $gamezone_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		gamezone_show_portfolio_posts(array(
			'cat' => $gamezone_cat,
			'parent_cat' => $gamezone_cat,
			'taxonomy' => $gamezone_taxonomy,
			'post_type' => $gamezone_post_type,
			'page' => 1,
			'sticky' => $gamezone_sticky_out
			)
		);
	}

	gamezone_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>