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
  <figure class="paint-item">
    <?php echo get_the_post_thumbnail(get_the_ID(), 'plume-painting-home'); ?>
    <figcaption><?php echo get_the_title() ?></figcaption>
  </figure>
  <?php
  // Single bottom post meta.
  // plume_the_post_meta(get_the_ID(), 'single-bottom');
  ?>
</a>
