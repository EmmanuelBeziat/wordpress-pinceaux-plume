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

<a href="<?php echo get_permalink() ?>" <?php post_class('hp-paint hp-grid-item') ?> id="post-<?php the_ID(); ?>">
  <div class="hp-paint__image">
  <?php
    if (get_field('picture')) : ?>
      <img src="<?= get_field('picture')['sizes']['plume-painting-home'] ?>" alt="<?= get_field('picture')['alt'] ?>">
    <?php elseif (has_post_thumbnail()) :
      echo get_the_post_thumbnail(get_the_ID(), 'plume-painting-home');
    else : ?>
      <img src="<?= get_template_directory_uri() . '/img/thumbnail-default.png' ?>" alt>
    <?php endif ?>
  </div>
  <div class="hp-paint__caption">
    <h2 class="hp-paint__title"><?= get_the_title() ?></h2>

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
