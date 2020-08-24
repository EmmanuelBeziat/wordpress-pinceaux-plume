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

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
  <?php echo get_the_post_thumbnail(get_the_ID(), 'plume-painting-home'); ?>

  <?php
  echo get_the_title();
  // Single bottom post meta.
  // plume_the_post_meta(get_the_ID(), 'single-bottom');
  ?>
</article>
