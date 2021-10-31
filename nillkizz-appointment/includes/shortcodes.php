<?php
add_shortcode('nillkizz-appointment', function () {
  $plugin_url = PLUGIN_URL;
  return <<<HTML
  <embed src="http://localhost:8082" style="width: 100%; height: calc(100vh - 100px)">
HTML;
});
