<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.14
 */
$gamezone_header_video = gamezone_get_header_video();
$gamezone_embed_video = '';
if (!empty($gamezone_header_video) && !gamezone_is_from_uploads($gamezone_header_video)) {
	if (gamezone_is_youtube_url($gamezone_header_video) && preg_match('/[=\/]([^=\/]*)$/', $gamezone_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$gamezone_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($gamezone_header_video) . '[/embed]' ));
			$gamezone_embed_video = gamezone_make_video_autoplay($gamezone_embed_video);
		} else {
			$gamezone_header_video = str_replace('/watch?v=', '/embed/', $gamezone_header_video);
			$gamezone_header_video = gamezone_add_to_url($gamezone_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$gamezone_embed_video = '<iframe src="' . esc_url($gamezone_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php gamezone_show_layout($gamezone_embed_video); ?></div><?php
	}
}
?>