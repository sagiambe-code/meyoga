<?php
/**
 * Funzioni di supporto: lettura dei campi, immagini, link.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

/**
 * ID della pagina impostata come Home.
 */
function mey_home_id() {
	return (int) get_option( 'page_on_front' );
}

/**
 * Legge un campo della Home; se è vuoto (o ACF non c'è) usa il testo predefinito.
 *
 * @param string   $key     Nome del campo.
 * @param int|null $post_id Post da cui leggere (predefinito: la Home).
 * @return mixed
 */
function mey_get( $key, $post_id = null ) {
	$value = null;
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $key, $post_id ? $post_id : mey_home_id() );
	}
	if ( null === $value || false === $value || '' === $value || array() === $value ) {
		$defaults = mey_defaults();
		return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	}
	return $value;
}

/**
 * Stampa un'immagine scelta in bacheca, oppure quella di base inclusa nel tema.
 *
 * @param string $key      Campo immagine ACF (restituisce un ID).
 * @param string $fallback Nome del file in assets/img.
 * @param string $alt      Testo alternativo predefinito.
 * @param array  $attrs    Attributi aggiuntivi (class, style, loading…).
 * @param string $size     Dimensione WordPress.
 */
function mey_image( $key, $fallback, $alt, $attrs = array(), $size = 'large' ) {
	$id = function_exists( 'get_field' ) ? get_field( $key, mey_home_id() ) : 0;
	if ( is_array( $id ) && isset( $id['ID'] ) ) {
		$id = $id['ID'];
	}
	if ( $id ) {
		$attrs['alt'] = get_post_meta( $id, '_wp_attachment_image_alt', true ) ? get_post_meta( $id, '_wp_attachment_image_alt', true ) : $alt;
		echo wp_get_attachment_image( (int) $id, $size, false, $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput
		return;
	}
	$html = '<img src="' . esc_url( MEY_URI . '/assets/img/' . $fallback ) . '" alt="' . esc_attr( $alt ) . '"';
	foreach ( $attrs as $name => $val ) {
		$html .= ' ' . esc_attr( $name ) . '="' . esc_attr( $val ) . '"';
	}
	echo $html . '>'; // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Link a Google Maps per un indirizzo.
 */
function mey_maps_url( $query ) {
	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $query );
}

/**
 * URL di un'ancora della home, valido anche dalle pagine interne.
 */
function mey_anchor( $id ) {
	return home_url( '/#' . $id );
}

/**
 * Testo con a capo → righe separate (per le credenziali "una per riga").
 *
 * @return string[]
 */
function mey_lines( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ) ) );
}

/**
 * HTML permesso nei testi lunghi scritti da Mey.
 */
function mey_kses( $html ) {
	return wp_kses(
		$html,
		array(
			'p'      => array(),
			'br'     => array(),
			'strong' => array(),
			'b'      => array(),
			'em'     => array(),
			'i'      => array(),
			'a'      => array(
				'href'   => true,
				'target' => true,
				'rel'    => true,
			),
		)
	);
}

/**
 * Icone SVG del tema (decorative).
 */
function mey_icon( $name ) {
	$icons = array(
		'arrow'    => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M13 6l6 6-6 6"/></svg>',
		'external' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17L17 7"/><path d="M8 7h9v9"/></svg>',
		'menu'     => '<svg class="ic-open" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16"/><path d="M4 12h16"/><path d="M4 17h16"/></svg>',
		'close'    => '<svg class="ic-close" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12"/><path d="M18 6L6 18"/></svg>',
		'up'       => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5"/><path d="M6 11l6-6 6 6"/></svg>',
	);
	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Menu principale predefinito, se in bacheca non ne è stato assegnato uno.
 */
function mey_menu_fallback() {
	$items = array(
		'yoga'     => 'Yoga',
		'climb'    => 'Climb',
		'chi-sono' => 'Chi sono',
		'contatti' => 'Contatti',
	);
	echo '<ul>';
	foreach ( $items as $id => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( mey_anchor( $id ) ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Menu del footer predefinito.
 */
function mey_footer_menu_fallback() {
	echo '<ul>';
	printf( '<li><a href="%s">Instagram</a></li>', esc_url( mey_get( 'instagram_url' ) ) );
	foreach ( array( 'privacy', 'cookie-policy' ) as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			printf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $page ) ), esc_html( 'privacy' === $slug ? 'Privacy' : 'Cookie' ) );
		}
	}
	echo '</ul>';
}

/**
 * URL dell'informativa privacy (pagina di WordPress, se impostata).
 */
function mey_privacy_url() {
	$url = get_privacy_policy_url();
	if ( ! $url ) {
		$page = get_page_by_path( 'privacy' );
		$url  = $page ? get_permalink( $page ) : '#';
	}
	return $url;
}
