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
    <?= get_field('picture') ?>
  </div>
  <div class="hp-paint__caption">
    <h2 class="hp-paint__title"><?= get_the_title() ?></h2>
    <?= get_field('paint-type') ?>, <?= get_field('dimensions') ?>
    <hr>
    <?php get_field('description') ?>
  </div>
  <?php
  // Single bottom post meta.
  // plume_the_post_meta(get_the_ID(), 'single-bottom');
  ?>
</a>
