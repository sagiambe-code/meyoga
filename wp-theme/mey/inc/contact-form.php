<?php
/**
 * Modulo contatti: invio con wp_mail, protezione anti-spam senza CAPTCHA
 * (nonce + campo trappola + tempo minimo di compilazione + limite per indirizzo).
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

/**
 * Voci del menu «Lezione di interesse», raggruppate.
 *
 * @return array<string,string[]>
 */
function mey_form_interests() {
	$groups = array();
	foreach ( mey_lines( mey_get( 'form_interests' ) ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( 2 === count( $parts ) ) {
			$groups[ $parts[0] ][] = $parts[1];
		} else {
			$groups[''][] = $parts[0];
		}
	}
	return $groups;
}

/**
 * Esito dell'ultimo invio, letto dall'indirizzo dopo il rimando.
 */
function mey_form_status() {
	return isset( $_GET['contatto'] ) ? sanitize_key( wp_unslash( $_GET['contatto'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
}

/**
 * Gestisce l'invio del modulo.
 */
function mey_handle_contact() {
	$back = function ( $status ) {
		wp_safe_redirect( add_query_arg( 'contatto', $status, home_url( '/' ) ) . '#contatti' );
		exit;
	};

	if ( ! isset( $_POST['mey_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mey_nonce'] ) ), 'mey_contatto' ) ) {
		$back( 'scaduto' );
	}

	// Trappola per i robot: campo nascosto che una persona non compila.
	if ( ! empty( $_POST['sito_web'] ) ) {
		$back( 'ok' );
	}
	// Compilato in meno di 3 secondi: quasi certamente un robot.
	$started = isset( $_POST['mey_t'] ) ? (int) $_POST['mey_t'] : 0;
	if ( $started && ( time() - $started ) < 3 ) {
		$back( 'ok' );
	}

	$name     = isset( $_POST['nome'] ) ? sanitize_text_field( wp_unslash( $_POST['nome'] ) ) : '';
	$email    = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone    = isset( $_POST['telefono'] ) ? sanitize_text_field( wp_unslash( $_POST['telefono'] ) ) : '';
	$interest = isset( $_POST['interesse'] ) ? sanitize_text_field( wp_unslash( $_POST['interesse'] ) ) : '';
	$message  = isset( $_POST['messaggio'] ) ? sanitize_textarea_field( wp_unslash( $_POST['messaggio'] ) ) : '';
	$consent  = ! empty( $_POST['privacy'] );

	if ( '' === $name || ! is_email( $email ) || '' === $message || ! $consent ) {
		$back( 'incompleto' );
	}

	// Al massimo 3 invii ogni 10 minuti dallo stesso indirizzo.
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key   = 'mey_cf_' . md5( $ip );
	$count = (int) get_transient( $key );
	if ( $count >= 3 ) {
		$back( 'troppi' );
	}
	set_transient( $key, $count + 1, 10 * MINUTE_IN_SECONDS );

	$to = mey_get( 'form_email' );
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	$subject = sprintf( 'Nuova richiesta dal sito: %s', $interest ? $interest : 'informazioni' );
	$body    = implode(
		"\n",
		array(
			'Nome: ' . $name,
			'Email: ' . $email,
			'Telefono: ' . ( $phone ? $phone : '—' ),
			'Lezione di interesse: ' . ( $interest ? $interest : '—' ),
			'',
			'Messaggio:',
			$message,
			'',
			'— Inviato dal modulo contatti di ' . home_url( '/' ),
		)
	);
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'Reply-To: %s <%s>', str_replace( array( "\r", "\n", '<', '>' ), '', $name ), $email ),
	);

	$sent = wp_mail( $to, $subject, $body, $headers );
	$back( $sent ? 'ok' : 'errore' );
}
add_action( 'admin_post_nopriv_mey_contatto', 'mey_handle_contact' );
add_action( 'admin_post_mey_contatto', 'mey_handle_contact' );

/**
 * Messaggio da mostrare sopra il modulo.
 *
 * @return array{0:string,1:string}|null Tipo e testo.
 */
function mey_form_notice() {
	switch ( mey_form_status() ) {
		case 'ok':
			return array( 'ok', 'Grazie, il messaggio è arrivato. Ti rispondo al più presto.' );
		case 'incompleto':
			return array( 'err', 'Mancano alcuni dati: nome, un’email valida, il messaggio e il consenso privacy.' );
		case 'troppi':
			return array( 'err', 'Hai inviato diversi messaggi in poco tempo: riprova tra qualche minuto.' );
		case 'scaduto':
			return array( 'err', 'La pagina era aperta da molto tempo: ricaricala e riprova.' );
		case 'errore':
			return array( 'err', 'Il messaggio non è partito per un problema tecnico. Scrivimi su Instagram o per email.' );
	}
	return null;
}
