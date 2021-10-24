<?php
if (function_exists('acf_add_options_page')) :

  acf_add_options_page(array(
    'page_title' => 'Nillkizz Appointment Plugin',
    'menu_slug' => 'nillkizz-appointment',
    'menu_title' => 'Appointment',
    'capability' => 'edit_posts',
    'position' => '',
    'parent_slug' => '',
    'icon_url' => 'dashicons-groups',
    'redirect' => true,
    'post_id' => 'options',
    'autoload' => false,
    'update_button' => 'Update',
    'updated_message' => 'Options Updated',
    'active' => true,
  ));

  acf_add_options_page(array(
    'page_title' => 'Доктора',
    'menu_slug' => 'nillkizz-appointment-doctors',
    'menu_title' => 'Доктора',
    'capability' => 'edit_posts',
    'position' => '0',
    'parent_slug' => 'nillkizz-appointment',
    'icon_url' => '',
    'redirect' => true,
    'post_id' => 'nillkizz-appointment-doctors',
    'autoload' => false,
    'update_button' => 'Сохранить',
    'updated_message' => 'Список докторов успешно обновлен.',
    'active' => true,
  ));

endif;
