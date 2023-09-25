<?php
/**
 * The default template for displaying painting on Homepage
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

?>

<a href="<?php echo get_permalink() ?>" <?php post_class('hp-paint hp-grid-item') ?> id="post-<?php the_ID(); ?>" aria-label="Voir « <?= get_the_title() ?> ">
  <div class="hp-paint__image">
    <?php if (get_field('picture')) : ?>
      <picture>
        <source srcset="<?= get_field('picture')['sizes']['plume-painting-home'] ?>.webp" type="image/webp">
        <source srcset="<?= get_field('picture')['sizes']['plume-painting-home'] ?>">
        <img src="<?= get_field('picture')['sizes']['plume-painting-home'] ?>" loading="lazy" alt="<?= get_field('picture')['alt'] ?>">
      </picture>
    <?php else : ?>
      <picture>
        <source srcset="<?= get_template_directory_uri() . '/img/thumbnail-default.webp' ?>" type="image/webp">
        <source srcset="<?= get_template_directory_uri() . '/img/thumbnail-default.png' ?>">
        <img src="<?= get_template_directory_uri() . '/img/thumbnail-default.png' ?>" loading="lazy" alt>
      </picture>
    <?php endif ?>
  </div>

  <div class="hp-paint__caption">
    <h2 class="hp-paint__title"><?= get_the_title() ?></h2>
    <?php if (get_field('date')) : ?>
      <span class="hp-paint__date"><?= get_field('date') ?></span>
    <?php endif ?>

    <hr>

    <?php if (get_field('paint-type')) : ?>
      <span class="hp-paint__type"><?= get_field('paint-type') ?></span>
    <?php endif ?>

    <?php if (get_field('dimensions') && get_field('dimensions')['width'] != '0') : ?>
      <span class="hp-paint__dimensions"><?= get_field('dimensions')['width'] ?>×<?= get_field('dimensions')['height'] ?> cm</span>
    <?php endif ?>

    <?php if (get_field('description')) : ?>
    <div class="hp_paint__short-description">
      <?= get_field('description') ?>
    </div>
    <?php endif ?>
  </div>
</a>
