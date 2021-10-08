<?php
add_shortcode('nillkizz-appointment', function () {
  global $plugin_url;
  return <<<HTML
<div id="app"></div>
<script src="{$plugin_url}public/app/js/app.js"></script>
HTML;
});
