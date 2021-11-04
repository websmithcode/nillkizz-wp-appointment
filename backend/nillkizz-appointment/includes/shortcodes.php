<?php
add_shortcode('nillkizz-appointment', function ($attrs) {
  global $pluginUrl;
  $url = "{$pluginUrl}public/app/index.html";
  if (isset($attrs['doctor'])) {
    $url .= "#/appointment/doctor_{$attrs['doctor']}";
  }
  return <<<HTML
  <script>
    function isJsonString(str) {
      try {
          JSON.parse(str);
      } catch (e) {
          return false;
      }
      return true;
    }
    function resizeIframe(e) {
      if (!isJsonString(e.data)) return
      
      const obj = document.getElementById('nillkizz-appointment-app');
      const data = JSON.parse(e.data);
      if (data.action == 'resize'){
        obj.style.height = data.height + 'px';
      }
      else if (data.action == 'scrollToTop'){
        window.scrollTo(0, obj.getBoundingClientRect().y + window.pageYOffset - 150)
      }
    }
    window.addEventListener('message', resizeIframe);
  </script>
  <style>
    #nillkizz-appointment-app{
      background-color: white;
    }
  </style>
  <iframe id="nillkizz-appointment-app" src="{$url}" style="width: 100%" frameborder="0" scrolling="no" ></iframe>

HTML;
});
