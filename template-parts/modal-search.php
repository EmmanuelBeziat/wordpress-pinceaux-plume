<?php
/**
 * Displays the search icon and modal
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

?>
<div class="search-modal cover-modal" data-modal-target-string=".search-modal">
	<div class="search-modal-inner modal-inner">
		<?php get_search_form(['label' => 'Recherche…']);	?>

		<button class="toggle search-untoggle close-search-toggle fill-children-current-color" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field">
			<span class="toggle-icon"><?php plume_the_theme_svg('cross'); ?></span>
			<span class="screen-reader-text">Fermer</span>
		</button>

	</div>
</div>
