<?php

/**
 * Plugin Name:       Nillkizz Appointment
 * Author:            Alexander Smith
 * Author URI:        https://t.me/alxndr_smith
 */

if (!class_exists('NillkizzAppointment')) {
  class NillkizzAppointment
  {
  }
}


global $plugin_url;
$plugin_url = plugin_dir_url(__FILE__);

include_once('includes/shortcodes.php');


