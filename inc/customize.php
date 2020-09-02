<?php

add_action('customize_register', function (WP_Customize_Manager $manager) {
  $manager->add_section('plume_header', [
    'title' => 'En-tête'
  ]);

  $manager->add_setting('header_background', [
    'default' => '',
    'capability' => 'edit_theme_options'
    // 'sanitize_callback' => saniti
  ]);

  $manager->add_control(new WP_Customize_Image_Control($manager, 'header_background', [
    'section' => 'plume_header',
    'label' => 'Image de fond'
  ]));
});
