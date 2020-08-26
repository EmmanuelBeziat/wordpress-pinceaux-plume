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

<main id="site-content" class="main">

	<div class="container error404-content">
		<h1 class="entry-title">Page introuvable</h1>

		<div class="intro-text"><p>La page que vous recherchez n’existe pas. Elle a peut-être été supprimée ou déplacée.</p></div>

		<?php	get_search_form(['label' => 'Page introuvable']);	?>
	</div>

</main>

<?php
get_footer();
