<?php
add_shortcode('nillkizz-appointment', function ($attrs) {
  global $pluginUrl;
  $url = "{$pluginUrl}public/app/index.html";
  if (isset($attrs['doctor'])) {
    $url .= "#/appointment/doctor_{$attrs['doctor']}";
  }
  return <<<HTML
  <script>
    function resizeIframe(e) {
      const data = JSON.parse(e.data);
      console.log(data)
      if (data.action == 'resize'){
        const obj = document.getElementById('nillkizz-appointment-app');
        obj.style.height = data.height + 'px';
      }
    }
    window.addEventListener('message', resizeIframe);
  </script>
  <style>
    #nillkizz-appointment-app{
      background-color: white;
    }
  </style>
  <iframe id="nillkizz-appointment-app" src="{$url}" style="width: 100%" frameborder="0" scrolling="no" >

HTML;
});
