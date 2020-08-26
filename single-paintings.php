<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

get_header();
?>

<main id="site-content" class="main">
	<?php
	if (have_posts()) :
		while (have_posts()) : the_post();
			echo the_title();
    endwhile;
	endif;
	?>
</main>

<?php get_footer(); ?>
