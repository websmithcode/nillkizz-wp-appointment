<?php
add_shortcode('nillkizz-appointment', function () {
  $plugin_url = PLUGIN_URL;
  return <<<HTML
<div id="app"></div>
<script src="{$plugin_url}public/app/js/app.js"></script>
HTML;
});
