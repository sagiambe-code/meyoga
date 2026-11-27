<?php
/**
 * Piè di pagina.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

$legal = mey_get( 'legal_name' );
$vat   = mey_get( 'vat' );
?>
</main>

<footer class="site-footer">
	<div class="wrap footer__in">
		<span class="footer__brand"><?php echo esc_html( get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Mey' ); ?></span>
		<nav class="footer__nav" aria-label="Link secondari">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => 'mey_footer_menu_fallback',
				)
			);
			?>
		</nav>
		<span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( $legal ); ?><?php echo $vat ? ' · P.IVA ' . esc_html( $vat ) : ''; ?></span>
		<p class="footer__credit">Fatto a mano da <a href="https://filobottega.it">Filo – bottega creativa</a></p>
	</div>
</footer>

<button type="button" class="totop" aria-label="Torna su" hidden><?php echo mey_icon( 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>

<?php wp_footer(); ?>
</body>
</html>
