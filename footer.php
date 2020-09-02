<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.0
 */

?>
			<footer id="site-footer" role="contentinfo" class="footer">
				<div class="container">

					<div class="footer-credits">
						<p class="footer-copyright">&copy;
							<?= date_i18n(
								/* translators: Copyright date format, see https://www.php.net/date */
								_x('Y', 'copyright date format', 'plume')
							);
							?>
							<a href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
						</p>
					</div>

					<a class="to-the-top screen-reader-text" href="#site-header">
						<span class="to-the-top-long">
							<?php
							/* translators: %s: HTML character for up arrow. */
							printf(__('To the top %s', 'plume'), '<span class="arrow" aria-hidden="true">&uarr;</span>');
							?>
						</span><!-- .to-the-top-long -->
						<span class="to-the-top-short">
							<?php
							/* translators: %s: HTML character for up arrow. */
							printf(__('Up %s', 'plume'), '<span class="arrow" aria-hidden="true">&uarr;</span>');
							?>
						</span>
					</a>
				</div>
			</footer>

		</div>
		<?php wp_footer(); ?>

	</body>
</html>
