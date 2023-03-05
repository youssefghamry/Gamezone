<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2021 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Rightclick
{

	/**
	 * right click option name
	 */
	const ESG_RIGHTCLICK_OPTION = 'tp_eg_rightclick';

	/**
	 * @var array  default option values
	 */
	private $_defaults = array(
		'rightclick-enabled' => 'false',
		'rightclick-show-custom-msg' => 'false',
		'rightclick-custom-msg-text' => '',
		'rightclick-custom-msg-once' => 'false',
		'rightclick-dev-tools' => 'true',
		'rightclick-view-source' => 'true',
	);

	protected static $instance = null;

	/**
	 * @return Essential_Grid_Rightclick
	 */
	public static function get_instance()
	{
		if ( is_null( static::$instance ) ) {
			static::$instance = new Essential_Grid_Rightclick();
		}

		return static::$instance;
	}

	protected function __construct()
	{
		$this->addActions();
	}

	/**
	 * add actions
	 */
	protected function addActions()
	{
		//skip if disabled or admin
		if (!$this->isEnabled() || is_admin()) return;
		
		//skip if it is builder page
		$builders = array(
			'elementor-preview' => '', 
			'siteorigin_panels_live_editor' => '', 
			'preview_id' => '', 
			'fl_builder' => '', 
			'et_fb' => '',
		);
		$is_builder = count(array_intersect_key($_GET, $builders));
		if ($is_builder) return;

		add_action('wp_head', array($this, 'outputJs'));
	}

	/**
	 * get options defaults
	 * @return array
	 */
	public function getDefaults()
	{
		return $this->_defaults;
	}

	/**
	 * get options
	 * @return array
	 */
	public function getOptions()
	{
		$options = get_option(self::ESG_RIGHTCLICK_OPTION, array());
		if (!is_array($options)) return $this->_defaults;
		
		return array_merge($this->_defaults, $options);
	}

	/**
	 * save options
	 * @param array $options
	 * @return bool
	 */
	public function saveOptions($options)
	{
		return update_option(self::ESG_RIGHTCLICK_OPTION, $options);
	}

	/**
	 * is rightclick enabled
	 * @return bool
	 */
	public function isEnabled()
	{
		$options = $this->getOptions();
		return $options['rightclick-enabled'] === 'true';
	}
	
	public function outputJs()
	{
		$options = $this->getOptions();
		$styles = '';
		$onkeydown = '';
		$onrightclick = 'document.ondragstart = document.oncontextmenu = function () { return false; }';
		
		//check for onkeydown handler
		if ($options['rightclick-dev-tools'] === 'true' || $options['rightclick-view-source'] === 'true') {
			$onkeydown = "\r\n" . 'document.onkeydown = function(e) {';
			if ($options['rightclick-view-source'] === 'true') {
				$onkeydown .= 'if (e.ctrlKey && e.keyCode === 85) return false;';
			}
			if ($options['rightclick-dev-tools'] === 'true') {
				$onkeydown .= 'if (e.keyCode === 123) return false; if (event.ctrlKey && event.shiftKey && (e.keyCode === 67 || e.keyCode === 73 || e.keyCode === 74)) return false;';
			}
			$onkeydown .= 'return true; }';
		}
		
		//custom message
		if ($options['rightclick-show-custom-msg'] === 'true' && !empty($options['rightclick-custom-msg-text'])) {
			wp_enqueue_script('tp-tools');
			$styles = '<style>#eg-toolbox-wrapper{position:fixed;top:40px;right:15px;z-index:1900002;border:none;outline:0;box-shadow:none}.eg-toolbox{padding:15px 20px 15px 60px;background:#3f444a;color:#fff;max-width:400px;cursor:pointer;position:relative;font-weight:400;font-size:14px;box-shadow:0 3px 10px 0 rgba(0,0,0,.25);font-family:Roboto}.eg-toolbox>.icon{font-size:20px;font-style:normal;position:absolute;top:50%;left:15px;transform:translateY(-50%);color:#fff;width:30px;height:30px;text-align:center;line-height:30px!important;border-radius:15px}.eg-toolbox .icon.info{background-color:#22c8e5}</style>' . "\r\n";
			$vars = sprintf(
				'var tp_eg_rightclick_count = 0, tp_eg_rightclick_msg_once = %s, tp_eg_rightclick_msg_txt = "%s";',
				$options['rightclick-custom-msg-once'],
				esc_attr($options['rightclick-custom-msg-text'])
			);
			$onrightclick = <<<HEREDOC

{$vars}
document.ondragstart = function () { return false; }
document.oncontextmenu = function () { 
    if (!tp_eg_rightclick_msg_once || (tp_eg_rightclick_msg_once && !tp_eg_rightclick_count)) showInfo({content: tp_eg_rightclick_msg_txt, showdelay: 0, hidedelay: 2});
    tp_eg_rightclick_count += 1;
    return false; 
}
showInfo = function (obj) {
    if (typeof (punchgs) === 'undefined' || typeof (jQuery) === 'undefined') return;
    if (jQuery('#eg-toolbox-wrapper').length == 0) jQuery('body').append('<div id="eg-toolbox-wrapper"></div>');
    jQuery('#eg-toolbox-wrapper').append('<div class="eg-toolbox newadded"><i class="icon info">I</i>' + obj.content + '</div>');
    var nt = jQuery('#eg-toolbox-wrapper').find('.eg-toolbox.newadded'); nt.removeClass('newadded');
    punchgs.TweenLite.fromTo(nt, 0.5, {y: -50, autoAlpha: 0, transformOrigin: '50% 50%', transformPerspective: 900, rotationX: -90}, {autoAlpha: 1, y: 0, rotationX: 0, ease: punchgs.Back.easeOut, delay: obj.showdelay});
    nt.on('click', function () { punchgs.TweenLite.to(nt, 0.3, {x: 200, ease: punchgs.Power3.easeInOut, autoAlpha: 0, onComplete: function () { nt.remove() } }); });
    punchgs.TweenLite.to(nt, 0.3, {x: 200, ease: punchgs.Power3.easeInOut, autoAlpha: 0, delay: obj.hidedelay + obj.showdelay, onComplete: function () { nt.remove() } });
}
HEREDOC;
		}
		
		echo $styles . '<script id="tp_eg_rightclick" type="text/javascript">' . $onrightclick . $onkeydown . '</script>' . "\r\n";
	}
}

Essential_Grid_Rightclick::get_instance();
