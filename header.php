<?php
/**
 * Header file for the Plume WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

?><!doctype html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<header id="site-header" class="header header-footer-group" role="banner">
			<div class="header-inner container">

				<div class="header-titles">
					<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php echo get_bloginfo('name') ?></a></h1>
				</div>

				<div class="header-navigation-wrapper">
					<?php if (has_nav_menu('primary')) : ?>

					<button class="toggle nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" data-set-focus=".menu-modal .search-field">
						<span class="toggle-inner">
							<span class="toggle-icon">
								<?php plume_the_theme_svg('ellipsis'); ?>
							</span>
							<span class="toggle-text">Menu</span>
						</span>
					</button>

					<?php endif; ?>

					<button class="toggle search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field">
						<span class="toggle-inner">
							<span class="toggle-icon">
								<?php plume_the_theme_svg('search'); ?>
							</span>
							<span class="toggle-text">Recherche</span>
						</span>
					</button>

				</div>
			</div>

			<?php get_template_part('template-parts/modal-search'); ?>

		</header>

		<?php
		// Output the menu modal.
		get_template_part('template-parts/modal-menu');
