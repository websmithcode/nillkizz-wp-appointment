<?php
add_shortcode('nillkizz-appointment', function () {
  global $pluginUrl;
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
  <iframe id="nillkizz-appointment-app" src="{$pluginUrl}public/app/index.html" style="width: 100%" frameborder="0" scrolling="no" >

HTML;
});
