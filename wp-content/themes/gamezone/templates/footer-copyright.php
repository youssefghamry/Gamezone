<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap<?php
				if (!gamezone_is_inherit(gamezone_get_theme_option('copyright_scheme')))
					echo ' scheme_' . esc_attr(gamezone_get_theme_option('copyright_scheme'));
 				?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$gamezone_copyright = gamezone_prepare_macros(gamezone_get_theme_option('copyright'));
				if (!empty($gamezone_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $gamezone_copyright, $gamezone_matches)) {
						$gamezone_copyright = str_replace($gamezone_matches[1], date_i18n(str_replace(array('{', '}'), '', $gamezone_matches[1])), $gamezone_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($gamezone_copyright));
				}
			?></div>
		</div>
	</div>
</div>
