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
 * @since Plume 1.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<header class="post-header entry-header">
		<div class="container">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ) ?>
		</div>
	</header>
	<div class="container post-inner">
		<figure class="post-picture">
			<?php
			if (get_field('picture')) : ?>
				<img src="<?= get_field('picture')['sizes']['plume-painting-home'] ?>" alt="<?= get_field('picture')['alt'] ?>">
			<?php elseif (has_post_thumbnail()) :
				echo get_the_post_thumbnail(get_the_ID(), 'plume-painting-home');
			endif ?>
		</figure>

		<?php debug(get_field('picture')['sizes']) ?>

		<?php if (get_field('paint-type')) : ?>
      <span class="hp-paint__type"><?= get_field('paint-type') ?></span>
    <?php endif ?>

    <?php if (get_field('dimensions') && get_field('dimensions')['width'] != '0') : ?>
      <span class="hp-paint__dimensions"><?= get_field('dimensions')['width'] ?>×<?= get_field('dimensions')['height'] ?> cm</span>
    <?php endif ?>

    <?php if (get_field('content')) : ?>
    <div class="post-content">
      <?= get_field('content') ?>
    </div>
    <?php endif ?>
	</div>


	<div class="container">
		<?php
		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__('Page', 'plume') . '"><span class="label">' . __('Pages:', 'plume') . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);
		edit_post_link();

		// Single bottom post meta.
		plume_the_post_meta(get_the_ID(), 'single-bottom');	?>
	</div>

	<?php

	if (is_single()) {
		get_template_part('template-parts/navigation');
	}

	/**
	 *  Output comments wrapper if it's a post, or if comments are open,
	 * or if there's a comment number – and check for password.
	 * */
	if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) : ?>
		<div class="comments-wrapper container">
			<?php comments_template() ?>
		</div>
	<?php endif ?>

</article>
