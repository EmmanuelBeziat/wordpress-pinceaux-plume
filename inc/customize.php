<?php

add_action('customize_register', function (WP_Customize_Manager $manager) {
  $manager->add_section('plume_apparence', [
    'title' => 'Personnalisation de l’apparence'
  ]);

  $manager->add_setting('header_background', [
    'default' => '',
    'transport' => 'postMessage'
    // 'sanitize_callback' => saniti
  ])
  $manager->add_control(new WP_Customize_Image_Control($manager, 'header_background', [
    'section' => 'plume_apparence',
    'label' => 'Image de fond'
  ]));
});

add_action('customize_preview_init', function () {
  wp_enqueue_script('customize', get_template_directory_uri() . '/assets/js/customize.js', ['jquery', 'customize-preview'], '1.0', true);
});
