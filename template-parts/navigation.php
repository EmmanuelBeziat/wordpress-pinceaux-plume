<?php
/**
 * Displays the next and previous post navigation in single posts.
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if ($next_post || $prev_post) {
	$pagination_classes = '';

	if (!$next_post) {
		$pagination_classes = ' only-one only-prev';
	}
	elseif (!$prev_post) {
		$pagination_classes = ' only-one only-next';
	}
	?>

	<nav class="pagination-single section-inner<?= esc_attr($pagination_classes); ?>" aria-label="Tableaux">
		<hr class="styled-separator is-style-wide" aria-hidden="true">

		<div class="pagination-single-inner">
			<?php plume_render_post_link($prev_post, 'prev'); ?>
			<?php plume_render_post_link($next_post, 'next'); ?>
		</div>
	</nav>

	<?php
}
