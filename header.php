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
<html class="no-js" <?php language_attributes() ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		<meta name="description" content="<?php bloginfo('description') ?>">

		<link rel="profile" href="https://gmpg.org/xfn/11">
		<link rel="icon" type="image/png" href="<?= get_template_directory_uri() ?>/assets/img/favicons/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/svg+xml" href="<?= get_template_directory_uri() ?>/assets/img/favicons/favicon.svg">
		<link rel="shortcut icon" href="<?= get_template_directory_uri() ?>/assets/img/favicons/favicon.ico">
		<link rel="apple-touch-icon" sizes="180x180" href="<?= get_template_directory_uri() ?>/assets/img/favicons/apple-touch-icon.png">
		<meta name="apple-mobile-web-app-title" content="Pinceaux de Plume">
		<link rel="manifest" href="<?= get_template_directory_uri() ?>/assets/img/favicons/site.webmanifest">

		<?php wp_head(); ?>
		<style>
			<?php if (get_theme_mod('header_background')) : ?> .header { background-image: url(<?= get_theme_mod('header_background') ?>) } <?php endif ?>
		</style>
	</head>

	<body <?php body_class(); ?>>
		<div class="site">
			<header id="site-header" class="header" role="banner">
				<div class="header-inner">

					<div class="header-titles">
						<h1 class="site-title"><a href="<?= esc_url(home_url('/')); ?>" rel="home"><?= get_bloginfo('name') ?></a></h1>
					</div>

					<div class="header-desc">
						<p><?= get_bloginfo('description') ?></p>
					</div>

					<div class="header-navigation-wrapper">

					</div>

					<?php if (get_theme_mod('header_search')) : ?>
					<div class="header-search">
						<?php get_search_form(['label' => 'Recherche…']);	?>
					</div>
					<?php endif ?>

					<div class="header-credits">
						<p class="header-copyright no-margin">Chantal B. &copy;
							<?= date_i18n(
								/* translators: Copyright date format, see https://www.php.net/date */
								_x('Y', 'copyright date format', 'plume')
							);
							?> <?= bloginfo('name') ?>
						</p>
					</div>
				</div>

				<?php // get_template_part('template-parts/modal-search') ?>
				<?php // get_template_part('template-parts/modal-menu') ?>
			</header>
