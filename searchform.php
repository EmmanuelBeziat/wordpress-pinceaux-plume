<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$plume_unique_id = plume_unique_id('search-form-');

$plume_aria_label = ! empty($args['label']) ? 'aria-label="' . esc_attr($args['label']) . '"' : '';
?>
<form role="search" <?php echo $plume_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?> method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<label class="" for="<?php echo esc_attr($plume_unique_id); ?>">
		<span class="screen-reader-text"><?php _e('Search for:', 'plume'); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations ?></span>
		<input type="search" id="<?php echo esc_attr($plume_unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'plume'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit">
		<?php plume_the_theme_svg('search'); ?>
		<span class="screen-reader-text">Recherche</span>
	</button>
</form>
