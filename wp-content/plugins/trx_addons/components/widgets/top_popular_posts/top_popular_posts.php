<?php
/**
 * Widget:Top Popular posts
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_top_popular_posts_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_top_popular_posts_load' );
	function trx_addons_widget_top_popular_posts_load() {
		register_widget('trx_addons_widget_top_popular_posts');
	}
}

// Widget Class
class trx_addons_widget_top_popular_posts extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_top_popular_posts', 'description' => esc_html__('The most popular blog posts', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_top_popular_posts', esc_html__('ThemeREX Most Popular Post', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$tabs = array(
			array(
				'title' => isset($instance['category1']) ? get_cat_name((int) $instance['category1']) : '',
				'content' => ''
				),
			array(
				'title' => isset($instance['category2']) ? get_cat_name((int) $instance['category2']) : '',
				'content' => ''
				)
			);

		$number = isset($instance['number']) ? (int) $instance['number'] : '';

		$tabs_count = 0;

		for ($i=0; $i<2; $i++) {
			if (empty($tabs[$i]['title'])) ;
			$tabs_count++;
			$q_args = array(
				'post_type' => 'post',
				'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
				'post_password' => '',
				'posts_per_page' => $number,
				'ignore_sticky_posts' => true,
				'order' => 'DESC',
			);

			$q_args['category__in'] = $instance['category'.(int)($i+1)];


			if ($i==0) {			// Most popular
				$q_args['meta_key'] = 'trx_addons_post_views_count';
				$q_args['orderby'] = 'meta_value_num';
			} else if ($i==1) {		// Most liked
				$q_args['meta_key'] = 'trx_addons_post_views_count';
				$q_args['orderby'] = 'meta_value_num';
			}

			$q = new WP_Query($q_args);

			// Loop posts
			if ($q->have_posts()) {
				$post_number = 0;
				set_query_var('trx_addons_output_widgets_posts', '');
				while ($q->have_posts()) {
					$q->the_post();
					$post_number++;
					trx_addons_get_template_part('templates/tpl.posts-list.php',
						'trx_addons_args_widgets_posts',
						apply_filters('trx_addons_filter_widget_posts_args',
							array(
								'counters' => 'views',
								'show_image' => isset($instance['show_image']) ? (int)$instance['show_image'] : 0,
								'show_date' => isset($instance['show_date']) ? (int)$instance['show_date'] : 0,
								'show_author' => isset($instance['show_author']) ? (int)$instance['show_author'] : 0,
								'show_counters' => isset($instance['show_counters']) ? (int)$instance['show_counters'] : 0,
								'show_categories' => isset($instance['show_categories']) ? (int)$instance['show_categories'] : 0,
								'title_link' => isset($instance['title_link']) ? $instance['title_link'] : '',
								'title_link_url' => isset($instance['title_link_url']) ? $instance['title_link_url'] : ''
							),
							$instance, 'trx_addons_widget_top_popular_posts')
					);
					if ($post_number >= $number) break;
				}
				$tabs[$i]['content'] .= get_query_var('trx_addons_output_widgets_posts');
			}
		}

		wp_reset_postdata();



		if ( $tabs[0]['title'].$tabs[0]['content'].$tabs[1]['title'].$tabs[1]['content']) {

			$args['title_link'] = $instance['title_link'];
			$args['title_link_url'] = $instance['title_link_url'];

			trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'top_popular_posts/tpl.default.php',
										'trx_addons_args_widget_top_popular_posts',
										apply_filters('trx_addons_filter_widget_args',
											array_merge($args, compact('title', 'tabs', 'tabs_count')),
											$instance, 'trx_addons_widget_top_popular_posts')
										);





			if (!is_customize_preview() && $tabs_count > 1) {
				wp_enqueue_script('jquery-ui-tabs', false, array('jquery','jquery-ui-core'), null, true);
				wp_enqueue_script('jquery-effects-fade', false, array('jquery','jquery-effects-core'), null, true);
			}
		}
	}

	// Update the widget settings
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_link'] = strip_tags($new_instance['title_link']);
		$instance['title_link_url'] = strip_tags($new_instance['title_link_url']);
		$instance['category1']	= max(0, (int) $new_instance['category1']);
		$instance['category2']	= max(0, (int) $new_instance['category2']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = (int) $new_instance['show_date'];
		$instance['show_image'] = (int) $new_instance['show_image'];
		$instance['show_author'] = (int) $new_instance['show_author'];

		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_top_popular_posts');
	}

	// Displays the widget settings controls on the widget panel
	function form($instance) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'title_link' => '',
			'title_link_url' => '',
			'category1' => 0,
			'category2' => 0,
			'number' => '4',
			'show_date' => '1', 
			'show_image' => '1', 
			'show_author' => '1',

			), 'trx_addons_widget_top_popular_posts')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_top_popular_posts');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));

		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_top_popular_posts');

		$this->show_field(array('name' => 'category1',
								'title' => __('Tab 1 Parent category:', 'trx_addons'),
								'value' => (int) $instance['category1'],
								'options' => trx_addons_array_merge(array(__('- All categories -', 'trx_addons')), trx_addons_get_list_categories(false)),
								'type' => 'select'));

		$this->show_field(array('name' => 'category2',
								'title' => __('Tab 2 Parent category:', 'trx_addons'),
								'value' => (int) $instance['category2'],
								'options' => trx_addons_array_merge(array(__('- All categories -', 'trx_addons')), trx_addons_get_list_categories(false)),
								'type' => 'select'));

		$this->show_field(array('name' => 'number',
								'title' => __('Number posts to show:', 'trx_addons'),
								'value' => max(1, (int) $instance['number']),
								'type' => 'text'));

		$this->show_field(array('name' => 'show_image',
								'title' => __("Show post's image:", 'trx_addons'),
								'value' => (int) $instance['show_image'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_author',
								'title' => __("Show post's author:", 'trx_addons'),
								'value' => (int) $instance['show_author'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_date',
								'title' => __("Show post's date:", 'trx_addons'),
								'value' => (int) $instance['show_date'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'title_link',
								'title' => __("Button's text", 'trx_addons'),
								'value' => $instance['title_link'],
								'type' => 'text'));

		$this->show_field(array('name' => 'title_link_url',
								'title' => __("Button's URL", 'trx_addons'),
								'value' => $instance['title_link_url'],
								'type' => 'text'));

		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_top_popular_posts');
	}
}


// trx_widget_top_popular_posts
//-------------------------------------------------------------
/*
[trx_widget_top_popular_posts id="unique_id" title="Widget title" title_popular="title for the tab 'most popular'" title_commented="title for the tab 'most commented'" title_liked="title for the tab 'most liked'" number="4"]
*/
if ( !function_exists( 'trx_addons_sc_widget_top_popular_posts' ) ) {
	function trx_addons_sc_widget_top_popular_posts($atts, $content=null){
		$atts = trx_addons_sc_prepare_atts('trx_widget_top_popular_posts', $atts, array(
			// Individual params
			"title" => "",
			"title_link" => "",
			"title_link_url" => "",
			"category1" => 0,
			"category2" => 0,
			"number" => 4,
			"show_date" => 1,
			"show_image" => 1,
			"show_author" => 1,
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if ($atts['show_date']=='') $atts['show_date'] = 0;
		if ($atts['show_image']=='') $atts['show_image'] = 0;
		if ($atts['show_author']=='') $atts['show_author'] = 0;


		if ($atts['title_link']=='') $atts['title_link'] = '';
		if ($atts['title_link_url']=='') $atts['title_link_url'] = '';


		extract($atts);
		$type = 'trx_addons_widget_top_popular_posts';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_top_popular_posts'
								. (trx_addons_exists_visual_composer() ? ' vc_widget_top_popular_posts wpb_content_element' : '')
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_top_popular_posts', 'widget_top_popular_posts') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_top_popular_posts', $atts, $content);
	}
}


// Add [trx_widget_top_popular_posts] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_top_popular_posts_add_in_vc')) {
	function trx_addons_sc_widget_top_popular_posts_add_in_vc() {
		
		add_shortcode("trx_widget_top_popular_posts", "trx_addons_sc_widget_top_popular_posts");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_top_popular_posts", 'trx_addons_sc_widget_top_popular_posts_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Top_Popular_Posts extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_widget_top_popular_posts_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_top_popular_posts_add_in_vc_params')) {
	function trx_addons_sc_widget_top_popular_posts_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_top_popular_posts",
				"name" => esc_html__("Top Popular Posts", 'trx_addons'),
				"description" => wp_kses_data( __("Insert popular posts list with thumbs, post's meta and category", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_top_popular_posts',
				"class" => "trx_widget_top_popular_posts",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "title",
							"heading" => esc_html__("Widget title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the widget", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),

						array(
							"param_name" => "category1",
							"heading" => esc_html__("Category tab1", 'trx_addons'),
							"description" => wp_kses_data( __("Select category to show best post. If empty - select post from any category or from IDs list", 'trx_addons') ),
							'dependency' => array(
								'element' => 'ids',
								'is_empty' => true
							),
							"std" => 0,
							"value" => array_flip(trx_addons_array_merge(array(0 => esc_html__('- Select category -', 'trx_addons')), trx_addons_get_list_categories())),
							"type" => "dropdown"
						),
						array(
							"param_name" => "category2",
							"heading" => esc_html__("Category tab2", 'trx_addons'),
							"description" => wp_kses_data( __("Select category to show best post. If empty - select post from any category or from IDs list", 'trx_addons') ),
							'dependency' => array(
								'element' => 'ids',
								'is_empty' => true
							),
							"std" => 0,
							"value" => array_flip(trx_addons_array_merge(array(0 => esc_html__('- Select category -', 'trx_addons')), trx_addons_get_list_categories())),
							"type" => "dropdown"
						),

						array(
							"param_name" => "number",
							"heading" => esc_html__("Number posts to show", 'trx_addons'),
							"description" => wp_kses_data( __("How many posts display in widget?", 'trx_addons') ),
							"admin_label" => true,
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "show_image",
							"heading" => esc_html__("Show post's image", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display post's featured image?", 'trx_addons') ),
							"group" => esc_html__('Details', 'trx_addons'),
							"std" => "1",
							"value" => array("Show image" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_author",
							"heading" => esc_html__("Show post's author", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display post's author?", 'trx_addons') ),
							"group" => esc_html__('Details', 'trx_addons'),
							"std" => "1",
							"value" => array("Show author" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "show_date",
							"heading" => esc_html__("Show post's date", 'trx_addons'),
							"description" => wp_kses_data( __("Do you want display post's publish date?", 'trx_addons') ),
							"group" => esc_html__('Details', 'trx_addons'),
							"std" => "1",
							"value" => array("Show date" => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "title_link",
							"heading" => esc_html__("Button's text", 'trx_addons'),
							"description" => wp_kses_data( __("Caption for the button", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "title_link_url",
							"heading" => esc_html__("Button's URL", 'trx_addons'),
							"description" => wp_kses_data( __("Link URL for buttons", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						)

					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_top_popular_posts');
	}
}
?>
