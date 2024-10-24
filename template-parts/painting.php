<?php
/**
 * The default template for displaying painting on Homepage
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.2
 */

?>

<a href="<?= get_permalink() ?>" <?php post_class('hp-paint hp-grid-item') ?> id="post-<?php the_ID(); ?>" aria-label="Voir « <?= get_the_title() ?> ">
  <div class="hp-paint__image">
    <?php if ($picture = get_field('picture')) : ?>
      <picture>
        <source srcset="<?= esc_url($picture['sizes']['plume-painting-home']) ?>.webp" type="image/webp">
        <source srcset="<?= esc_url($picture['sizes']['plume-painting-home']) ?>">
        <img src="<?= esc_url($picture['sizes']['plume-painting-home']) ?>" loading="lazy" alt="<?= esc_attr($picture['alt']) ?>">
      </picture>
    <?php else : ?>
      <picture>
        <source srcset="<?= esc_url(get_template_directory_uri() . '/img/thumbnail-default.webp') ?>" type="image/webp">
        <source srcset="<?= esc_url(get_template_directory_uri() . '/img/thumbnail-default.png') ?>">
        <img src="<?= esc_url(get_template_directory_uri() . '/img/thumbnail-default.png') ?>" loading="lazy" alt>
      </picture>
    <?php endif ?>
  </div>

  <div class="hp-paint__caption">
    <h2 class="hp-paint__title"><?= get_the_title() ?></h2>
    <?php if ($date = get_field('date')) : ?>
      <span class="hp-paint__date"><?= esc_html($date) ?></span>
    <?php endif ?>

    <hr>

    <?php if ($paintType = get_field('paint-type')) : ?>
      <span class="hp-paint__type"><?= esc_html($paintType) ?></span>
    <?php endif ?>

    <?php if ($dimensions = get_field('dimensions')) : ?>
      <?php if (is_array($dimensions) && get_field('dimensions')['width'] != '0') : ?>
      <span class="hp-paint__dimensions"><?= esc_html($dimensions['width']) ?>×<?= esc_html($dimensions['height']) ?> cm</span>
      <?php endif ?>
    <?php endif ?>

    <?php if ($description = get_field('description')) : ?>
    <div class="hp_paint__short-description">
      <?= wp_kses_post($description) ?>
    </div>
    <?php endif ?>
  </div>
</a>
