<?php
/**
 * The template for displaying the 404 template in the Plume theme.
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

get_header();
?>

<main id="site-content" role="main">

	<div class="container thin error404-content">

		<h1 class="entry-title"><?php _e('Page Not Found', 'plume'); ?></h1>

		<div class="intro-text"><p><?php _e('The page you were looking for could not be found. It might have been removed, renamed, or did not exist in the first place.', 'plume'); ?></p></div>

		<?php
		get_search_form(
			array(
				'label' => __('404 not found', 'plume'),
			)
		);
		?>

	</div>

</main>

<?php
get_footer();
