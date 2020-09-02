<?php
/**
 * The template file for displaying the comments and comment form for the
 * Plume theme.
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if (post_password_required()) {
	return;
}

if ($comments) {	?>

	<div class="comments" id="comments">

		<?php $comments_number = absint(get_comments_number()); ?>

		<div class="comments-header container">
			<h2 class="comment-reply-title">
			<?php
			if (! have_comments()) {
				_e('Leave a comment', 'plume');
			} elseif (1 === $comments_number) {
				/* translators: %s: Post title. */
				printf(_x('One reply on &ldquo;%s&rdquo;', 'comments title', 'plume'), get_the_title());
			} else {
				printf(
					/* translators: 1: Number of comments, 2: Post title. */
					_nx(
						'%1$s reply on &ldquo;%2$s&rdquo;',
						'%1$s replies on &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'plume'
					),
					number_format_i18n($comments_number),
					get_the_title()
				);
			}

			?>
			</h2>

		</div>

		<div class="comments-inner container">

			<?php
			wp_list_comments(
				array(
					'walker'      => new Plume_Walker_Comment(),
					'avatar_size' => 120,
					'style'       => 'div',
				)
			);

			$comment_pagination = paginate_comments_links(
				array(
					'echo'      => false,
					'end_size'  => 0,
					'mid_size'  => 0,
					'next_text' => __('Newer Comments', 'plume') . ' <span aria-hidden="true">&rarr;</span>',
					'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __('Older Comments', 'plume'),
				)
			);

			if ($comment_pagination) {
				$pagination_classes = '';

				// If we're only showing the "Next" link, add a class indicating so.
				if (false === strpos($comment_pagination, 'prev page-numbers')) {
					$pagination_classes = ' only-next';
				}
				?>

				<nav class="comments-pagination pagination<?php echo $pagination_classes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>" aria-label="<?php esc_attr_e('Comments', 'plume'); ?>">
					<?php echo wp_kses_post($comment_pagination); ?>
				</nav>

				<?php
			}
			?>

		</div>

	</div>

	<?php
}

if (comments_open() || pings_open()) {

	if ($comments) {
		echo '<hr class="styled-separator is-style-wide" aria-hidden="true">';
	}

	comment_form([
		'class_form' => 'container',
		'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title heading-size-5">',
		'title_reply_after' => '</h2>',
	]);

}
elseif (is_single()) {
	if ($comments) {
		echo '<hr class="styled-separator is-style-wide" aria-hidden="true">';
	}
	?>
	<div class="comment-respond" id="respond">
		<p class="comments-closed"><?php _e('Comments are closed.', 'plume'); ?></p>
	</div>
	<?php
}
