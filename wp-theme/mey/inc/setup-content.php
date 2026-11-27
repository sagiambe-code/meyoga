<?php
/**
 * Alla prima attivazione il tema prepara il sito: pagina Home come pagina iniziale,
 * pagine Privacy e Cookie, lezioni e proposte di partenza, foto nella Libreria media,
 * e i testi della bozza già scritti nei campi, così Mey li trova e li modifica.
 * Non sovrascrive nulla di esistente e gira una volta sola.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

/**
 * Carica nella Libreria media un'immagine inclusa nel tema (una volta sola) e ne restituisce l'ID.
 */
function mey_import_image( $file, $alt ) {
	$existing = get_posts(
		array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'meta_key'    => '_mey_source',
			'meta_value'  => $file,
			'fields'      => 'ids',
			'numberposts' => 1,
		)
	);
	if ( $existing ) {
		return (int) $existing[0];
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$source = MEY_DIR . '/assets/img/' . $file;
	if ( ! file_exists( $source ) ) {
		return 0;
	}
	$tmp = wp_tempnam( $file );
	copy( $source, $tmp );
	$id = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmp ), 0 );
	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		return 0;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	update_post_meta( $id, '_mey_source', $file );
	return (int) $id;
}

/**
 * Salva un campo come lo salverebbe ACF (funziona anche se ACF non è ancora attivo).
 */
function mey_seed_field( $post_id, $name, $value ) {
	if ( '' === get_post_meta( $post_id, $name, true ) ) {
		update_post_meta( $post_id, $name, $value );
		update_post_meta( $post_id, '_' . $name, 'field_mey_' . $name );
	}
}

/**
 * Crea una pagina se non esiste già lo stesso slug.
 */
function mey_ensure_page( $slug, $title, $content = '' ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return (int) $page->ID;
	}
	return (int) wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $content,
		)
	);
}

/**
 * Prepara il sito alla prima attivazione del tema.
 */
function mey_setup_content() {
	if ( get_option( 'mey_content_ready' ) ) {
		return;
	}

	// Home come pagina iniziale.
	$home = mey_home_id();
	if ( ! $home || 'page' !== get_option( 'show_on_front' ) ) {
		$home = mey_ensure_page( 'home', 'Home' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home );
	}

	// Pagine di servizio (il testo legale va scritto o generato per Mey).
	$privacy_text = "<!-- wp:paragraph --><p>[Informativa privacy di Mariagrazia [COGNOME]: titolare del trattamento, dati raccolti dal modulo contatti e dalla newsletter, finalità, conservazione, diritti dell'interessato e contatti.]</p><!-- /wp:paragraph -->";
	$cookie_text  = '<!-- wp:paragraph --><p>[Cookie policy: il sito usa solo cookie tecnici; i font sono ospitati sul sito stesso e non vengono caricati servizi di terze parti senza consenso.]</p><!-- /wp:paragraph -->';
	$privacy      = mey_ensure_page( 'privacy', 'Privacy', $privacy_text );
	mey_ensure_page( 'cookie-policy', 'Cookie', $cookie_text );
	if ( ! get_option( 'wp_page_for_privacy_policy' ) ) {
		update_option( 'wp_page_for_privacy_policy', $privacy );
	}

	// Testi e foto della bozza nei campi della Home.
	foreach ( mey_defaults() as $name => $value ) {
		if ( '' !== $value ) {
			mey_seed_field( $home, $name, $value );
		}
	}
	$images = array(
		'door_yoga_image'  => array( 'mey-hero-scoglio.jpg', 'Mey in allungamento laterale su uno scoglio, con il mare alle spalle' ),
		'door_climb_image' => array( 'mey-parete.jpg', 'Mey arrampica su un masso di roccia chiara, appesa con un braccio e una gamba tesa' ),
		'about_photo'      => array( 'mey-ritratto-mudra.jpg', 'Ritratto di Mey a occhi chiusi, braccia intrecciate davanti al viso, sul mare' ),
		'climb_photo'      => array( 'mey-parete.jpg', 'Mey arrampica su un masso di roccia chiara, appesa con un braccio e una gamba tesa' ),
	);
	foreach ( $images as $name => $img ) {
		$id = mey_import_image( $img[0], $img[1] );
		if ( $id ) {
			mey_seed_field( $home, $name, $id );
		}
	}

	// Lezioni di partenza.
	if ( ! get_posts( array( 'post_type' => 'mey_lezione', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) ) ) {
		$lessons = array(
			array( 'Yin Yoga', "Pratica lenta, posture tenute a lungo che lavorano sui tessuti profondi e invitano all'ascolto.", '[DURATA]', 'Adatta a tutti', '[GIORNO E ORA]', '[SEDE]', 'yin-tappetino.jpg', 'Donna seduta su un tappetino di sughero in una postura raccolta', 1 ),
			array( 'Bhakti Prema Vinyasa', 'Il movimento fluido del Vinyasa unito alla devozione: un percorso di crescita, un respiro alla volta.', '[DURATA]', '[LIVELLO]', '[GIORNO E ORA]', '[SEDE]', 'mey-terrazza-saline.jpg', 'Mey in una postura dinamica su una terrazza, con i mulini delle saline e il mare sullo sfondo', 0 ),
			array( 'Lezioni individuali e consulenze 1:1', 'Un percorso costruito su di te, in sala o online, che unisce pratica, consigli ayurvedici e ascolto.', '[DURATA]', 'In sala e online · [STRUMENTO ONLINE]', 'Su appuntamento', '', 'rituale-candele.jpg', 'Persona in meditazione davanti a candele, incenso e pietre su un vassoio di legno', 1 ),
		);
		foreach ( $lessons as $i => $l ) {
			$id = wp_insert_post( array( 'post_type' => 'mey_lezione', 'post_status' => 'publish', 'post_title' => $l[0], 'menu_order' => $i + 1 ) );
			if ( ! $id || is_wp_error( $id ) ) {
				continue;
			}
			mey_seed_field( $id, 'lezione_descrizione', $l[1] );
			mey_seed_field( $id, 'lezione_durata', $l[2] );
			mey_seed_field( $id, 'lezione_livello', $l[3] );
			mey_seed_field( $id, 'lezione_quando', $l[4] );
			mey_seed_field( $id, 'lezione_sede', $l[5] );
			mey_seed_field( $id, 'lezione_provvisoria', $l[8] );
			$img = mey_import_image( $l[6], $l[7] );
			if ( $img ) {
				set_post_thumbnail( $id, $img );
			}
		}
	}

	// Proposte Climb di partenza (da completare con Mey).
	if ( ! get_posts( array( 'post_type' => 'mey_proposta', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) ) ) {
		for ( $i = 1; $i <= 3; $i++ ) {
			$id = wp_insert_post( array( 'post_type' => 'mey_proposta', 'post_status' => 'publish', 'post_title' => '[PROPOSTA ' . $i . ']', 'menu_order' => $i ) );
			if ( $id && ! is_wp_error( $id ) ) {
				mey_seed_field( $id, 'proposta_descrizione', "[Due righe: cos'è, per chi, quando. Per esempio yoga per climber, uscite su roccia, eventi]" );
			}
		}
	}

	update_option( 'mey_content_ready', MEY_VERSION );
}
add_action( 'after_switch_theme', 'mey_setup_content' );
