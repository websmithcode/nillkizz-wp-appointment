<?php
add_shortcode('nillkizz-appointment', function () {
  $plugin_url = PLUGIN_URL;

  $doctors = get_field('doctors', 'nillkizz-appointment-doctors');
  return <<<HTML
<div id="app"></div>
<script src="{$plugin_url}public/app/js/app.js"></script>
HTML;
});
