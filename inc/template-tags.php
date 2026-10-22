<?php
/**
 * Custom template tags for this theme.
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

/**
 * Table of Contents:
 * Comments
 * Post Meta
 * Paintings
 * Classes
 */

/**
 * Comments
 */

/**
 * Checks if the specified comment is written by the author of the post commented on.
 *
 * @param object $comment Comment data.
 * @return bool
 */
function plume_is_comment_by_post_author ($comment = null) {
	if (is_object($comment) && $comment->user_id > 0) {
		$user = get_userdata($comment->user_id);
		$post = get_post($comment->comment_post_ID);

		if (!empty($user) && !empty($post)) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * Filters comment reply link to not JS scroll.
 *
 * Filter the comment reply link to add a class indicating it should not use JS slow-scroll, as it
 * makes it scroll to the wrong position on the page.
 *
 * @param string $link Link to the top of the page.
 * @return string Link to the top of the page.
 */
function plume_filter_comment_reply_link ($link) {
	$link = str_replace('class=\'', 'class=\'do-not-scroll ', $link);
	return $link;
}

add_filter('comment_reply_link', 'plume_filter_comment_reply_link');

/**
 * Post Meta
 */

/**
 * Filters the edit post link to add an icon and use the post meta structure.
 *
 * @param string $link Anchor tag for the edit link.
 * @param int $post_id Post ID.
 * @param string $text Anchor text.
 */
function plume_edit_post_link ($link, $post_id, $text) {
	if (is_admin()) {
		return $link;
	}

	$edit_url = get_edit_post_link($post_id);

	if (!$edit_url) {
		return;
	}

	$text = sprintf(
		wp_kses(__('Modifier « %s »', 'plume'), ['span' => ['class' => []]]), get_the_title($post_id)
	);

	return '<div class="post-meta-wrapper post-meta-edit-link-wrapper"><a class="button" href="' . esc_url($edit_url) . '"><span class="meta-icon">' . plume_get_theme_svg('edit') . '</span><span class="meta-text">' . $text . '</span></a></div>';
}

add_filter('edit_post_link', 'plume_edit_post_link', 10, 3);

/**
 * Paintings
 */

/**
 * Outputs the painting picture of the current post, or the default thumbnail.
 *
 * @param string $size Image size name.
 */
function plume_the_painting_picture ($size) {
	$picture = get_field('picture');

	if ($picture) {
		$src = $picture['sizes'][$size];
		$alt = $picture['alt'];
	}
	else {
		$src = get_template_directory_uri() . '/assets/img/thumbnail-default.webp';
		$alt = '';
	}
	?>
	<img src="<?= esc_url($src) ?>" loading="lazy" alt="<?= esc_attr($alt) ?>">
	<?php
}

/**
 * Gets the formatted dimensions of the current painting.
 *
 * @return string Dimensions (e.g. "30×40 cm"), or an empty string if not set.
 */
function plume_get_painting_dimensions () {
	$dimensions = get_field('dimensions');

	if (!is_array($dimensions) || empty($dimensions['width']) || empty($dimensions['height'])) {
		return '';
	}

	return $dimensions['width'] . '×' . $dimensions['height'] . ' cm';
}

/**
 * Classes
 */

/**
 * Adds 'no-js' class.
 *
 * If we're missing JavaScript support, the HTML element will have a 'no-js' class.
 */
function plume_no_js_class () {
	?>
	<script>document.documentElement.className = document.documentElement.className.replace('no-js', 'js');</script>
	<?php
}

add_action('wp_head', 'plume_no_js_class');
