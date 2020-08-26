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

	<section class="hp-paints section section-search">
		<?php if (have_posts()) : ?>
		<header class="section-header">
			<h1 class="section-header-title page-title">Résultats de recherche pour : <span class="search-query"><?php echo get_search_query() ?></span></h1>
		</header>

		<div class="hp-grid">
				<?php while (have_posts()) : the_post();
					get_template_part('template-parts/painting', get_post_type());
				endwhile; ?>
		</div>
		<?php else : ?>
		<div class="no-search-results-form container thin">
			<p>Aucun résultat. Vous pouvez effectuer une nouvelle recherche.</p>
		</div>
		<?php endif; ?>

		<div class="no-search-results-form container thin">
			<?php get_search_form(['label' => 'Rechercher encore']); ?>
		</div>
	</section>

</main>

<?php get_footer() ?>
