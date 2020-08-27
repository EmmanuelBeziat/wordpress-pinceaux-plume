<?php

function plume_theme_options () {
?>

<div class="wrap">
  <h1>Personnalisation du thème</h1>

  <form action="options.php" method="post">
  <?php
    settings_fields('plume-theme-options-grp');
    do_settings_sections('plume-theme-options');
    submit_button();
  ?>
  </form>
</div>

<?php
}

function theme_section_description (){
  echo '<p>Section options</p>';
}

function options_callback () {
  $options = get_option('header_background');
  echo '<input name="first_field_option" id="first_field_option" type="checkbox" value="1" class="code" ' . checked(1, $options, false) . '> Check for enabling custom help text.';
}

function test_theme_settings () {
  add_settings_section('first_section', 'New Theme Options Section', 'theme_section_description', 'plume-theme-options');

  add_settings_field('header_background', 'Logo', 'test_logo_display', 'plume-theme-options', 'first_section');
  register_setting('plume-theme-options-grp', 'header_background');
}

function header_background_display () {
  ?>
  <input type="file" name="header_background">
  <?php
  echo get_option('header_background');
}
