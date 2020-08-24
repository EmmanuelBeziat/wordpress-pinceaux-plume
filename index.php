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

<main id="site-content" role="main">

	<?php
	$archive_title    = '';
	$archive_subtitle = '';

	if (is_search()) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . __('Search:', 'plume') . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ($wp_query->found_posts) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results. */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'plume'
				),
				number_format_i18n($wp_query->found_posts)
			);
		}
		else {
			$archive_subtitle = __('We could not find any results for your search. You can give it another try through the search form below.', 'plume');
		}
	}
	elseif (is_archive() && !have_posts()) {
		$archive_title = __('Nothing Found', 'plume');
	}
	elseif (!is_home()) {
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}

	if ($archive_title || $archive_subtitle) : ?>
	<header class="archive-header has-text-align-center header-footer-group">
		<div class="archive-header-inner container medium">

			<?php if ($archive_title) : ?>
				<h1 class="archive-title"><?php echo wp_kses_post($archive_title); ?></h1>
			<?php endif ?>

			<?php if ($archive_subtitle) : ?>
				<div class="archive-subtitle container thin max-percentage intro-text"><?php echo wp_kses_post(wpautop($archive_subtitle)); ?></div>
			<?php endif ?>

		</div>
	</header>
	<?php endif;

	$loop = new WP_Query([
		'post_type' => 'paintings',
		'posts_per_page' => -1
	]); ?>

	<section class="hp-paints section">
		<div class="container">
			<div class="hp-grid">
				<?php if ($loop->have_posts()) :
					while ($loop->have_posts()) : $loop->the_post();
						get_template_part('template-parts/painting', $loop->get_post_type());
					endwhile;
					wp_reset_query(); ?>
			</div>
		</div>
	</section>

	<?php elseif (is_search()) : ?>
	<div class="no-search-results-form container thin">
		<?php get_search_form(['label' => 'Rechercher encore']); ?>
	</div>
	<?php endif; ?>

	<?php get_template_part('template-parts/pagination'); ?>

</main>

<?php get_footer() ?>
