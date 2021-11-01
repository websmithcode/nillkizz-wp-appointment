<?php
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table = $wpdb->prefix . 'nillkizz_appointment_codes';

$sql = "CREATE TABLE $table (
        id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        callId VARCHAR(255) NOT NULL DEFAULT '0',
        pin VARCHAR(4) NOT NULL DEFAULT '0',
        created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (id)
        ) COLLATE $charset_collate;";

if ($wpdb->get_var("show tables like '" . $table . "'") != $table) {
  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  dbDelta($sql);
}
