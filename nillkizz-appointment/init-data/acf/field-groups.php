<?php
if (function_exists('acf_add_local_field_group')) :

  acf_add_local_field_group(array(
    'key' => 'group_61747c75c6bdb',
    'title' => 'Doctors',
    'fields' => array(
      array(
        'key' => 'field_61747c792378d',
        'label' => 'Doctors',
        'name' => 'doctors',
        'type' => 'repeater',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'hide_field' => '',
        'hide_label' => 'admin',
        'hide_instructions' => '',
        'hide_required' => '',
        'instruction_placement' => '',
        'acfe_permissions' => '',
        'acfe_repeater_stylised_button' => 1,
        'collapsed' => '',
        'min' => 0,
        'max' => 0,
        'layout' => 'table',
        'button_label' => 'Добавить Доктора',
        'acfe_settings' => '',
        'acfe_field_group_condition' => 0,
        'sub_fields' => array(
          array(
            'key' => 'field_61747c9a2378e',
            'label' => 'Фото',
            'name' => 'photo',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '10',
              'class' => '',
              'id' => '',
            ),
            'uploader' => '',
            'acfe_thumbnail' => 0,
            'return_format' => 'array',
            'preview_size' => 'thumbnail',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
            'acfe_field_group_condition' => 0,
            'library' => 'all',
          ),
          array(
            'key' => 'field_61747cca23790',
            'label' => 'Имя',
            'name' => 'name',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'required_message' => '',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
            'acfe_field_group_condition' => 0,
          ),
          array(
            'key' => 'field_61753cb1bef0d',
            'label' => 'GUID',
            'name' => 'guid',
            'type' => 'acfe_slug',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'required_message' => 'Это поле обязательно для корректной работы с 1С',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
            'acfe_field_group_condition' => 0,
          ),
          array(
            'key' => 'field_61753525a02cd',
            'label' => 'Детали',
            'name' => 'details',
            'type' => 'group',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '7',
              'class' => '',
              'id' => '',
            ),
            'layout' => 'block',
            'acfe_group_modal' => 1,
            'acfe_group_modal_close' => 0,
            'acfe_group_modal_button' => '',
            'acfe_group_modal_size' => 'full',
            'acfe_field_group_condition' => 0,
            'sub_fields' => array(
              array(
                'key' => 'field_6175342307cff',
                'label' => 'Пол',
                'name' => 'gender',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                  'width' => '10',
                  'class' => '',
                  'id' => '',
                ),
                'choices' => array(
                  'male' => 'М',
                  'female' => 'Ж',
                ),
                'allow_null' => 0,
                'default_value' => '',
                'layout' => 'horizontal',
                'return_format' => 'array',
                'acfe_field_group_condition' => 0,
              ),
              array(
                'key' => 'field_61747cd223791',
                'label' => 'Стаж',
                'name' => 'experience',
                'type' => 'number',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                  'width' => '15',
                  'class' => '',
                  'id' => '',
                ),
                'required_message' => '',
                'default_value' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => 0,
                'max' => 70,
                'step' => 1,
                'acfe_field_group_condition' => 0,
              ),
              array(
                'key' => 'field_617533034c5b1',
                'label' => 'Специальность',
                'name' => 'specialty',
                'type' => 'taxonomy',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ),
                'hide_field' => '',
                'hide_label' => '',
                'hide_instructions' => '',
                'hide_required' => '',
                'instruction_placement' => '',
                'acfe_permissions' => '',
                'taxonomy' => 'specialty',
                'field_type' => 'multi_select',
                'min' => '',
                'max' => '',
                'allow_null' => 0,
                'add_term' => 1,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'object',
                'acfe_bidirectional' => array(
                  'acfe_bidirectional_enabled' => '0',
                ),
                'acfe_settings' => '',
                'acfe_validate' => '',
                'acfe_field_group_condition' => 0,
                'multiple' => 0,
              ),
              array(
                'key' => 'field_61747d2a23793',
                'label' => 'Образование',
                'name' => 'education',
                'type' => 'taxonomy',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ),
                'hide_field' => '',
                'hide_label' => '',
                'hide_instructions' => '',
                'hide_required' => '',
                'instruction_placement' => '',
                'acfe_permissions' => '',
                'taxonomy' => 'education',
                'field_type' => 'multi_select',
                'min' => '',
                'max' => '',
                'allow_null' => 1,
                'add_term' => 1,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'object',
                'acfe_bidirectional' => array(
                  'acfe_bidirectional_enabled' => '0',
                ),
                'acfe_settings' => '',
                'acfe_validate' => '',
                'acfe_field_group_condition' => 0,
                'multiple' => 0,
              ),
            ),
          ),
        ),
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'nillkizz-appointment-doctors',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'acfe_autosync' => '',
    'acfe_form' => 1,
    'acfe_display_title' => '',
    'acfe_permissions' => '',
    'acfe_meta' => '',
    'acfe_note' => '',
    'acfe_categories' => array(
      'nillkizz-appointment' => 'Nillkizz Appointment',
    ),
  ));

endif;
