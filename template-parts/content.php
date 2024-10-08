<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.2
 */
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<header class="post-header">
		<div class="container">
			<h1 class="post-title"><?php the_title() ?></h1>
			<?php if ($date = get_field('date')) : ?>
				<span class="post-date"><?= esc_html($date) ?></span>
			<?php endif ?>

			<?php if ($paint_type = get_field('paint-type')) : ?>
				<span class="paint__type"><?= esc_html($paint_type) ?></span>
			<?php endif ?>

			<?php if ($dimensions = get_field('dimensions') && get_field('dimensions')['width'] != '0') : ?>
				<span class="paint__dimensions"><?= esc_html($dimensions['width']) ?>×<?= esc_html($dimensions['height']) ?> cm</span>
			<?php endif ?>

			<?php edit_post_link() ?>
		</div>
	</header>

	<div class="container post-inner">
		<figure class="post-picture">
		<?php if ($picture = get_field('picture')) : ?>
			<picture>
				<source srcset="<?= esc_url($picture['sizes']['plume-painting-single']) ?>.webp" type="image/webp">
				<source srcset="<?= esc_url($picture['sizes']['plume-painting-single']) ?>">
				<img src="<?= esc_url($picture['sizes']['plume-painting-single']) ?>" loading="lazy" alt="<?= esc_attr($picture['alt']) ?>">
			</picture>
		<?php else : ?>
			<picture>
				<source srcset="<?= esc_url(get_template_directory_uri() . '/img/thumbnail-default.webp') ?>" type="image/webp">
				<source srcset="<?= esc_url(get_template_directory_uri() . '/img/thumbnail-default.png') ?>">
				<img src="<?= esc_url(get_template_directory_uri() . '/img/thumbnail-default.png') ?>" loading="lazy" alt>
			</picture>
		<?php endif ?>
		</figure>

		<?php if ($content = get_field('content')) : ?>
		<div class="post-content">
			<h2 class="heading-size-4">À propos…</h2>
			<?= wp_kses_post($content) ?>
		</div>
		<?php endif ?>
	</div>

	<div class="container">
		<?php
		wp_link_pages([
			'before'      => '<nav class="post-nav-links bg-light-background" aria-label="Page"><span class="label">Pages</span>',
			'after'       => '</nav>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		]);

		// Single bottom post meta.
		plume_the_post_meta(get_the_ID(), 'single-bottom');

		// Share
		if (get_theme_mod('post_share')) :
			get_template_part('template-parts/share');
		endif;

		// Navigation
		if (is_single()) :
			get_template_part('template-parts/navigation');
		endif;

		/**
		 *  Output comments wrapper if it's a post, or if comments are open,
		 * or if there's a comment number – and check for password.
		 * */
		if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required() && get_theme_mod('post_comments')) : ?>
			<div class="comments-wrapper">
				<?php comments_template() ?>
			</div>
		<?php endif ?>
	</div>

</article>
