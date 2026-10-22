<?php
/**
 * The default template for displaying painting on Homepage
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.2
 */

?>

<a href="<?php the_permalink() ?>" <?php post_class('hp-paint hp-grid-item') ?> id="post-<?php the_ID(); ?>" aria-label="Voir « <?php the_title_attribute() ?> »">
	<div class="hp-paint__image">
		<?php plume_the_painting_picture('plume-painting-home') ?>
	</div>

	<div class="hp-paint__caption">
		<h2 class="hp-paint__title"><?php the_title() ?></h2>
		<?php if ($date = get_field('date')) : ?>
			<span class="hp-paint__date"><?= esc_html($date) ?></span>
		<?php endif ?>

		<hr>

		<?php if ($paintType = get_field('paint-type')) : ?>
			<span class="hp-paint__type"><?= esc_html($paintType) ?></span>
		<?php endif ?>

		<?php if ($dimensions = plume_get_painting_dimensions()) : ?>
			<span class="hp-paint__dimensions"><?= esc_html($dimensions) ?></span>
		<?php endif ?>

		<?php if ($description = get_field('description')) : ?>
		<div class="hp_paint__short-description">
			<?= wp_kses_post($description) ?>
		</div>
		<?php endif ?>
	</div>
</a>
