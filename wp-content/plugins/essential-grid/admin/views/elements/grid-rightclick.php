<div id="esg-rightclick-global-settings" class="esg-settings-container">

	<div>
		<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Status', ESG_TEXTDOMAIN) ?></span></esg-llabel></div>
		<div class="eg-cs-tbc">
			<label for="rightclick-enabled"><?php esc_html_e('Enable Protection', ESG_TEXTDOMAIN) ?></label><!--
			--><span class="esg-display-inline-block"><input type="radio" name="rightclick-enabled" value="true" <?php echo checked($options['rightclick-enabled'], 'true', false) ?> /><?php esc_html_e('On', ESG_TEXTDOMAIN) ?></span><div class="space18"></div><!--
			--><span class="esg-display-inline-block"><input type="radio" name="rightclick-enabled" value="false" <?php echo checked($options['rightclick-enabled'], 'false', false) ?> /><?php esc_html_e('Off', ESG_TEXTDOMAIN) ?></span>
			<div class="div0"></div>
			<label></label><span class="esgs-info"><?php echo esc_html_e('Status of right click protection', ESG_TEXTDOMAIN); ?></span>
		</div>
	</div>
	
	<div id="esg-rightclick-settings" class="esg-display-none">
		<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Settings', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
		<div class="eg-cs-tbc">
			<label for="rightclick-show-custom-msg"><?php esc_html_e('Custom Message', ESG_TEXTDOMAIN) ?></label><!--
			--><span class="esg-display-inline-block"><input type="radio" name="rightclick-show-custom-msg" value="true" <?php echo checked($options['rightclick-show-custom-msg'], 'true', false) ?> /><?php esc_html_e('On', ESG_TEXTDOMAIN) ?></span><div class="space18"></div><!--
			--><span class="esg-display-inline-block"><input type="radio" name="rightclick-show-custom-msg" value="false" <?php echo checked($options['rightclick-show-custom-msg'], 'false', false) ?> /><?php esc_html_e('Off', ESG_TEXTDOMAIN) ?></span>
			<div class="div0"></div>
			<label></label><span class="esgs-info"><?php echo esc_html_e('Show custom message popup on right click', ESG_TEXTDOMAIN); ?></span>
			<div class="div13"></div>
			
			<div id="esg-rightclick-custom-msg-text" class="esg-display-none">
				<label for="rightclick-custom-msg-once"><?php esc_html_e('Show Message Only Once', ESG_TEXTDOMAIN) ?></label><!--
				--><span class="esg-display-inline-block"><input type="radio" name="rightclick-custom-msg-once" value="true" <?php echo checked($options['rightclick-custom-msg-once'], 'true', false) ?> /><?php esc_html_e('On', ESG_TEXTDOMAIN) ?></span><div class="space18"></div><!--
				--><span class="esg-display-inline-block"><input type="radio" name="rightclick-custom-msg-once" value="false" <?php echo checked($options['rightclick-custom-msg-once'], 'false', false) ?> /><?php esc_html_e('Off', ESG_TEXTDOMAIN) ?></span>
				<div class="div13"></div>
				
				<label for="rightclick-custom-msg-text"><?php esc_html_e('Custom Message Text', ESG_TEXTDOMAIN) ?></label><!--
					--><input type="text" name="rightclick-custom-msg-text" value="<?php echo esc_attr($options['rightclick-custom-msg-text']) ?>">
				<div class="div13"></div>
			</div>

			<label for="rightclick-dev-tools"><?php esc_html_e('Disable Developer Tools', ESG_TEXTDOMAIN) ?></label><!--
			--><span class="esg-display-inline-block"><input type="radio" name="rightclick-dev-tools" value="true" <?php echo checked($options['rightclick-dev-tools'], 'true', false) ?> /><?php esc_html_e('On', ESG_TEXTDOMAIN) ?></span><div class="space18"></div><!--
			--><span class="esg-display-inline-block"><input type="radio" name="rightclick-dev-tools" value="false" <?php echo checked($options['rightclick-dev-tools'], 'false', false) ?> /><?php esc_html_e('Off', ESG_TEXTDOMAIN) ?></span>
			<div class="div0"></div>
			<label></label><span class="esgs-info"><?php echo esc_html_e('Disable developer tools hotkeys ( CTRL + SHIFT + C, CTRL + SHIFT + J, CTRL + SHIFT + I, F12)', ESG_TEXTDOMAIN); ?></span>
			<div class="div13"></div>

			<label for="rightclick-view-source"><?php esc_html_e('Disable View Source', ESG_TEXTDOMAIN) ?></label><!--
			--><span class="esg-display-inline-block"><input type="radio" name="rightclick-view-source" value="true" <?php echo checked($options['rightclick-view-source'], 'true', false) ?> /><?php esc_html_e('On', ESG_TEXTDOMAIN) ?></span><div class="space18"></div><!--
			--><span class="esg-display-inline-block"><input type="radio" name="rightclick-view-source" value="false" <?php echo checked($options['rightclick-view-source'], 'false', false) ?> /><?php esc_html_e('Off', ESG_TEXTDOMAIN) ?></span>
			<div class="div0"></div>
			<label></label><span class="esgs-info"><?php echo esc_html_e('Disable view source hotkey ( CTRL + U )', ESG_TEXTDOMAIN); ?></span>
			<div class="div13"></div>
		</div>
	</div>
	
</div>
