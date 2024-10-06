<div class="post-share">
  <h2 class="heading-size-5">Partager</h2>

  <div class="share-auto" hidden>
    <button type="button" class="button" aria-label="Partager ce tableau"><?php plume_the_theme_svg('share') ?> Partager sur…</button>
  </div>

  <div class="share-manual" hidden>
    <?php
    $socials = [
      'x' => 'X',
      'facebook' => 'Facebook',
      'link' => 'Copier l’URL'
    ];

    foreach ($socials as $name => $label) : ?>
    <button type="button" class="button" data-name="<?= esc_attr($name) ?>" aria-label="Partager sur <?= esc_html($label) ?>">
      <?php plume_the_theme_svg($name, 'social') ?> <?= esc_html($label) ?>
    </button>
    <?php endforeach; ?>
  </div>
</div>
