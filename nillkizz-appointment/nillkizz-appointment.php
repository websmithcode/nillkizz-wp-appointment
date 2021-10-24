<?php

/**
 * Plugin Name:       Nillkizz Appointment
 * Author:            Alexander Smith
 * Author URI:        https://t.me/alxndr_smith
 */


define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));



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
      // Define path and URL to the ACF plugin.
      define('MY_ACF_EXT_PATH', PLUGIN_DIR . 'includes/acf-extended-pro/');
      define('MY_ACF_EXT_URL', PLUGIN_URL . 'includes/acf-extended-pro/');
      define('MY_ACF_PATH', PLUGIN_DIR . 'includes/acf-pro/');
      define('MY_ACF_URL', PLUGIN_URL . 'includes/acf-pro/');
      // Include the ACF plugin.
      include_once(MY_ACF_PATH . 'acf.php');
      include_once(MY_ACF_EXT_PATH . 'acf-extended.php');

      // Customize the url setting to fix incorrect asset URLs.
      add_filter('acf/settings/url', 'my_acf_settings_url');
      function my_acf_settings_url($url)
      {
        return MY_ACF_URL;
      }
      include_once(PLUGIN_DIR . 'init-data/acf/field-groups.php');
      include_once(PLUGIN_DIR . 'init-data/acf/options-pages.php');

      add_filter('acf/settings/show_admin', array(&$this, 'my_acf_settings_show_admin'));
    }

    function my_acf_settings_show_admin($show_admin)
    {
      return $show_admin || $this->show_acf;
    }

    function register_taxonomies()
    {
      include_once(PLUGIN_DIR . 'init-data/taxonomies.php');
    }

    function register_api()
    {
      add_action('rest_api_init', function () {

        register_rest_route('nillkizz-appointment/v1', '/get-doctors', array(
          'methods'             => 'GET',            // метод запроса: GET, POST ...
          'callback'            => 'json_api',  // функция обработки запроса. Должна вернуть ответ на запрос
          // 'permission_callback' => 'function_name',  // функция проверки доступа к маршруту. Должна вернуть true/false
        ));
      });
      function json_api($request)
      {
        switch ($action) {
          default:
            $doctors = get_field('doctors', 'nillkizz-appointment-doctors');
            $response = rest_ensure_response($doctors);
        }
        return $response;
      }
    }
  }

  global $nillkizz_appointment;
  $nillkizz_appointment = new NillkizzAppointment();
}
