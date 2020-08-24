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

<a href="<?php echo get_permalink(the_ID()) ?>" <?php post_class('hp-paint hp-grid-item') ?> id="post-<?php the_ID(); ?>">
  <div class="hp-paint__image">
    <?php echo get_the_post_thumbnail(get_the_ID(), 'plume-painting-home'); ?>
  </div>
  <div class="hp-paint__caption">
    <h2 class="hp-paint__title"><?php echo get_the_title() ?></h2>
  </div>
  <?php
  // Single bottom post meta.
  // plume_the_post_meta(get_the_ID(), 'single-bottom');
  ?>
</a>
