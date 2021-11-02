<?php
register_taxonomy('education', 'doctor', array(
  'hierarchical'  => false,
  'labels'        => array(
    'name'                        => _x('Educations', 'taxonomy general name'),
    'singular_name'               => _x('Education', 'taxonomy singular name'),
  ),
  // 'show_ui'       => true,
  'query_var'     => true,
  // 'rewrite'       => array( 'slug' => 'the_writer' ), // свой слаг в URL
));
register_taxonomy('specialty', 'doctor', array(
  'hierarchical'  => false,
  'labels'        => array(
    'name'                        => _x('Specialties', 'taxonomy general name'),
    'singular_name'               => _x('Specialty', 'taxonomy singular name'),
  ),
  // 'show_ui'       => true,
  'query_var'     => true,
  // 'rewrite'       => array( 'slug' => 'the_writer' ), // свой слаг в URL
));
