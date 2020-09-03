<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */
?>

<?php get_header() ?>

<main id="site-content" class="main">

	<?php
	$loop = new WP_Query([
		'post_type' => 'paintings',
		'posts_per_page' => -1
	]); ?>

	<section class="hp-paints section">
		<?php if ($loop->have_posts()) : ?>
		<div class="hp-grid">
				<?php while ($loop->have_posts()) : $loop->the_post();
					get_template_part('template-parts/painting', $loop->get_post_type());
				endwhile;
				wp_reset_query(); ?>
		</div>

		<?php elseif (is_search()) : ?>
		<div class="no-search-results-form container thin">
			<?php get_search_form(['label' => 'Rechercher encore']); ?>
		</div>
		<?php endif; ?>
	</section>

</main>

<?php get_footer() ?>
