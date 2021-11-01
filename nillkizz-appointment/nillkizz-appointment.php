<?php

/**
 * Plugin Name:       Nillkizz Appointment
 * Author:            Alexander Smith
 * Author URI:        https://t.me/alxndr_smith
 */

$currentDir = trailingslashit(dirname(__FILE__));
define('NILLKIZZ_APPOINTMENT_DIR', $currentDir);
define('NILLKIZZ_APPOINTMENT_VERSION', '1.0');
$pluginName = plugin_basename(NILLKIZZ_APPOINTMENT_DIR);
$pluginUrl = trailingslashit(WP_PLUGIN_URL . '/' . $pluginName);
$assetsUrl = $pluginUrl . 'assets/';



if (!class_exists('NillkizzAppointment')) {
  class NillkizzAppointment
  {
    public $data = array();
    public $show_acf = False;

    public function __construct()
    {
      add_action('init', array(&$this, 'register_taxonomies'));
      $this->init_acf();
      $this->register_api();
      include_once('includes/shortcodes.php');
    }
    function init_acf()
    {
      global $pluginUrl, $currentDir;
      // Define path and URL to the ACF plugin.
      define('MY_ACF_EXT_PATH', $currentDir . 'includes/acf-extended-pro/');
      define('MY_ACF_EXT_URL', $pluginUrl . 'includes/acf-extended-pro/');
      define('MY_ACF_PATH', $currentDir . 'includes/acf-pro/');
      define('MY_ACF_URL', $pluginUrl . 'includes/acf-pro/');
      // Include the ACF plugin.
      include_once(MY_ACF_PATH . 'acf.php');
      include_once(MY_ACF_EXT_PATH . 'acf-extended.php');

      // Customize the url setting to fix incorrect asset URLs.
      add_filter('acf/settings/url', 'my_acf_settings_url');
      function my_acf_settings_url($url)
      {
        return MY_ACF_URL;
      }
      include_once($currentDir . 'init-data/acf/field-groups.php');
      include_once($currentDir . 'init-data/acf/options-pages.php');

      add_filter('acf/settings/show_admin', array(&$this, 'my_acf_settings_show_admin'));
    }

    function my_acf_settings_show_admin($show_admin)
    {
      return $show_admin || $this->show_acf;
    }

    function register_taxonomies()
    {
      global $currentDir;
      include_once($currentDir . 'init-data/taxonomies.php');
    }

    function register_api()
    {
      include_once('includes/json_api.php');
    }

    static public function activate()
    {
      require_once('activate.php');
    }

    function uninstall()
    {
      global $wpdb;
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}nillkizz_appointment_codes");
    }
  }

  global $nillkizz_appointment;
  $nillkizz_appointment = new NillkizzAppointment();
  register_activation_hook(__FILE__, array($nillkizz_appointment, 'activate'));
}
