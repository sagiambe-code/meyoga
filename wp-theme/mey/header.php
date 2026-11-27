<?php
/**
 * Testata del sito.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#contenuto">Vai al contenuto</a>

<header class="site-header">
	<div class="wrap hdr-in">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<span class="brand__name"><?php echo esc_html( get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Mey' ); ?></span>
			<span class="brand__tag"><?php echo esc_html( mey_get( 'brand_tagline' ) ); ?></span>
		</a>

		<nav id="menu" class="hdr-nav" aria-label="Navigazione principale">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'principale',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => 'mey_menu_fallback',
				)
			);
			?>
		</nav>

		<div class="hdr-actions">
			<?php
			$cta       = mey_get( 'cta_label' );
			$cta_parts = explode( ' ', $cta, 2 );
			?>
			<a class="hdr-cta" href="<?php echo esc_url( mey_anchor( 'contatti' ) ); ?>"><?php echo esc_html( $cta_parts[0] ); ?><?php if ( isset( $cta_parts[1] ) ) : ?><span class="hdr-cta__long">&nbsp;<?php echo esc_html( $cta_parts[1] ); ?></span><?php endif; ?></a>
			<button type="button" class="hdr-burger" aria-controls="menu" aria-expanded="false" aria-label="Apri il menu" data-label-open="Apri il menu" data-label-close="Chiudi il menu"><?php echo mey_icon( 'menu' ) . mey_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
		</div>
	</div>
</header>

<main id="contenuto">
