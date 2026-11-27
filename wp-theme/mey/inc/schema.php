<?php
/**
 * Dati strutturati per Google (JSON-LD) nella home, presi dagli stessi campi della bacheca.
 * Nessuna recensione "auto-dichiarata": Google le ignora e le scoraggia.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

/**
 * Stampa il JSON-LD.
 */
function mey_schema() {
	if ( ! is_front_page() ) {
		return;
	}

	$home      = home_url( '/' );
	$same_as   = array_values( array_filter( array( mey_get( 'instagram_url' ), mey_get( 'substack_url' ), mey_get( 'google_url' ) ) ) );
	$legal     = trim( str_replace( '[COGNOME]', '', mey_get( 'legal_name' ) ) );
	$person_id = $home . '#mey';

	$person = array(
		'@type'         => 'Person',
		'@id'           => $person_id,
		'name'          => $legal ? $legal : 'Mey',
		'alternateName' => 'Mey',
		'jobTitle'      => 'Insegnante di yoga',
		'url'           => $home,
		'sameAs'        => $same_as,
		'knowsAbout'    => array( 'Yoga', 'Yin Yoga', 'Hatha Yoga', 'Vinyasa', 'Ayurveda', 'Jyotish', 'Arrampicata' ),
		'affiliation'   => array(
			'@type' => 'SportsActivityLocation',
			'name'  => mey_get( 'dolmen_title' ),
			'url'   => mey_get( 'dolmen_url' ),
			'address' => mey_get( 'dolmen_address' ),
		),
	);

	$business = array(
		'@type'    => 'LocalBusiness',
		'@id'      => $home . '#yoga',
		'name'     => 'Yoga e Meditazione con Mey',
		'url'      => $home,
		'founder'  => array( '@id' => $person_id ),
		'sameAs'   => $same_as,
		'location' => array(
			'@type'   => 'Place',
			'name'    => mey_get( 'kokoro_name' ),
			'address' => mey_get( 'kokoro_address' ),
		),
	);
	if ( mey_get( 'phone' ) ) {
		$business['telephone'] = mey_get( 'phone' );
	}
	if ( is_email( mey_get( 'email' ) ) ) {
		$business['email'] = mey_get( 'email' );
	}

	$data = array(
		'@context' => 'https://schema.org',
		'@graph'   => array( $person, $business ),
	);

	echo "<script type=\"application/ld+json\">\n" . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) . "\n</script>\n";
}
add_action( 'wp_head', 'mey_schema', 20 );
