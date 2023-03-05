<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('gamezone_mailchimp_get_css')) {
	add_filter('gamezone_filter_get_css', 'gamezone_mailchimp_get_css', 10, 4);
	function gamezone_mailchimp_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
form.mc4wp-form .mc4wp-form-fields input[type="email"] {
	{$fonts['input_font-family']}
	{$fonts['input_font-size']}
	{$fonts['input_font-weight']}
	{$fonts['input_font-style']}
	{$fonts['input_text-decoration']}
	{$fonts['input_text-transform']}
	{$fonts['input_letter-spacing']}
}
form.mc4wp-form .mc4wp-form-fields input[type="submit"] {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}

CSS;
		
			
			$rad = gamezone_get_border_radius();
			$css['fonts'] .= <<<CSS

form.mc4wp-form .mc4wp-form-fields input[type="email"],
form.mc4wp-form .mc4wp-form-fields input[type="submit"] {
	-webkit-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}

CSS;
		}

		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS
form.mc4wp-form .mc4wp-span-button:before{
	color: {$colors['text_link']};
}
form.mc4wp-form .mc4wp-alert {
	background-color: {$colors['text_link']};
	border-color: {$colors['text_hover']};
	color: {$colors['inverse_text']};
}

form.mc4wp-form h6:before, form.mc4wp-form h6{
	color: {$colors['text_light']};
}
.sidebar.widget_area form.mc4wp-form h6:before,
.sidebar.widget_area form.mc4wp-form h6,
.wpb_widgetised_column form.mc4wp-form h6:before,
.wpb_widgetised_column form.mc4wp-form h6{
	color: {$colors['extra_dark']};
}
.sidebar.widget_area form.mc4wp-form h4, .wpb_widgetised_column form.mc4wp-form h4{
	color: {$colors['inverse_text']};
}
.sidebar.widget_area form.mc4wp-form input[type="email"], .wpb_widgetised_column form.mc4wp-form input[type="email"]{
	border-color: {$colors['extra_dark']};
}

.page_content_wrap .sc_content form.mc4wp-form h6:before, .sidebar.widget_area form.mc4wp-form h6{
	color: {$colors['extra_dark']};
}
.page_content_wrap .sc_content form.mc4wp-form h4{
	color: {$colors['inverse_text']};
}
.page_content_wrap .sc_content form.mc4wp-form input[type="email"]{
	border-color: {$colors['extra_dark']};
}

.sidebar.widget_area form.mc4wp-form input[type="email"]::-webkit-input-placeholder {color:{$colors['extra_dark']}; opacity: 1;}
.sidebar.widget_area form.mc4wp-form input[type="email"]::-moz-placeholder          {color:{$colors['extra_dark']}; opacity: 1;}/* Firefox 19+ */
.sidebar.widget_area form.mc4wp-form input[type="email"]:-moz-placeholder           {color:{$colors['extra_dark']}; opacity: 1;}/* Firefox 18- */
.sidebar.widget_area form.mc4wp-form input[type="email"]:-ms-input-placeholder      {color:{$colors['extra_dark']}; opacity: 1;}/* Firefox 18- */

.wpb_widgetised_column form.mc4wp-form input[type="email"]::-webkit-input-placeholder {color:{$colors['extra_dark']}; opacity: 1;}
.wpb_widgetised_column form.mc4wp-form input[type="email"]::-moz-placeholder          {color:{$colors['extra_dark']}; opacity: 1;}/* Firefox 19+ */
.wpb_widgetised_column form.mc4wp-form input[type="email"]:-moz-placeholder           {color:{$colors['extra_dark']}; opacity: 1;}/* Firefox 18- */
.wpb_widgetised_column form.mc4wp-form input[type="email"]:-ms-input-placeholder      {color:{$colors['extra_dark']}; opacity: 1;}/* Firefox 18- */

.page_content_wrap .sc_content form.mc4wp-form input[type="email"]::-webkit-input-placeholder {color:{$colors['extra_dark']}; opacity: 1;}
.page_content_wrap .sc_content form.mc4wp-form input[type="email"]::-moz-placeholder          {color:{$colors['extra_dark']}; opacity: 1;}/* Firefox 19+ */
.page_content_wrap .sc_content form.mc4wp-form input[type="email"]:-moz-placeholder           {color:{$colors['extra_dark']}; opacity: 1;}/* Firefox 18- */
.page_content_wrap .sc_content form.mc4wp-form input[type="email"]:-ms-input-placeholder      {color:{$colors['extra_dark']}; opacity: 1;}/* Firefox 18- */


.sidebar.widget_area form.mc4wp-form input[type="email"], .wpb_widgetised_column form.mc4wp-form input[type="email"]{
	color: {$colors['inverse_text']}!important;
}

.page_content_wrap .sc_content form.mc4wp-form input[type="email"]{
	color: {$colors['inverse_text']};
}
.mc4wp-alert.mc4wp-error a {
	color: {$colors['inverse_text']};
}
.mc4wp-alert.mc4wp-error a:hover {
	color: {$colors['inverse_dark']};
}
form.mc4wp-form input[type="email"].filled, form.mc4wp-form input[type="email"]{
color: {$colors['inverse_text']};
}

.sc_popup form.mc4wp-form input[type="email"].filled{
	color: {$colors['inverse_dark']};
}

CSS;
		}

		return $css;
	}
}
?>