<?php

// Settings
$capability = 'edit_theme_options';

add_action('customize_register', function (WP_Customize_Manager $manager) {
  // Sections
  $manager->add_section('plume_header', [
    'title' => 'En-tête'
  ]);

  $manager->add_section('plume_post', [
    'title' => 'Page peinture'
  ]);

  // Settings
  $manager->add_setting('header_background', [
    'default' => '',
    'capability' => $capability
    // 'sanitize_callback' => saniti
  ]);

  $manager->add_setting('header_search', [
    'default' => '',
    'capability' => $capability
  ]);

  $manager->add_setting('post_share', [
    'default' => '',
    'capability' => $capability
  ]);

  // Control
  $manager->add_control(new WP_Customize_Image_Control($manager, 'header_background', [
    'section' => 'plume_header',
    'label' => 'Image de fond'
  ]));

  $manager->add_control('header_search', [
    'label' => 'Afficher le champ de recherche',
    'type' => 'checkbox',
    'section' => 'plume_header'
  ]);

  $manager->add_control('post_share', [
    'label' => 'Afficher la section de partage',
    'type' => 'checkbox',
    'section' => 'plume_post'
  ]);
});
