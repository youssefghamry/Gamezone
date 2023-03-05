<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2021 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Rightclick_Admin
{

	protected static $instance = null;

	/**
	 * @return Essential_Grid_Rightclick_Admin
	 */
	public static function get_instance()
	{
		if ( is_null( static::$instance ) ) {
			static::$instance = new Essential_Grid_Rightclick_Admin();
		}

		return static::$instance;
	}

	protected function __construct()
	{
		$this->addActions();
		$this->addFilters();
	}

	/**
	 * add actions
	 */
	protected function addActions()
	{
		add_action('essgrid_enqueue_admin_scripts', array($this, 'enqueueAdminScripts'));
	}

	/**
	 * add filters
	 */
	protected function addFilters()
	{
		//global settings
		add_filter('essgrid_global_settings_menu', array($this, 'addGlobalSettingsMenu'), 10, 1);
		add_filter('essgrid_global_settings_content', array($this, 'addGlobalSettingsContent'), 10, 1);
	}

	public function enqueueAdminScripts()
	{
		global $esg_dev_mode;

		if ($esg_dev_mode) {
			// DEV VERSION
			wp_enqueue_script('esg-rightclick-script', plugins_url('assets/js/modules/dev/rightclick.js', ESG_PLUGIN_ADMIN_PATH . '/index.php'), array('jquery'), Essential_Grid::VERSION);
		}
	}

	/**
	 * add global settings menu item
	 * @param $str
	 * @return string
	 */
	public function addGlobalSettingsMenu($str)
	{
		return $str
			. '<li data-toshow="esg-rightclick-global-settings" class="esg-rightclick-settings">'
			. '<i class="material-icons">mouse</i><p>' . esc_html('Right Click', ESG_TEXTDOMAIN) . '</p>'
			. '</li>';
	}

	/**
	 * add global settings content section
	 * @param $str
	 * @return string
	 */
	public function addGlobalSettingsContent($str)
	{
		$rightclick = Essential_Grid_Rightclick::get_instance();
		$options = $rightclick->getOptions();
		
		ob_start();
		include ESG_PLUGIN_ADMIN_PATH . '/views/elements/grid-rightclick.php';
		$content = ob_get_clean(); 

		return $str . $content;
	}
}

Essential_Grid_Rightclick_Admin::get_instance();
