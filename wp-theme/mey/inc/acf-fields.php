<?php
/**
 * Campi ACF registrati nel codice: non vanno creati a mano e non si possono rompere dalla bacheca.
 * Funzionano con la versione gratuita di Advanced Custom Fields.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

/**
 * Costruisce la definizione di un campo.
 */
function mey_field( $name, $label, $type = 'text', $extra = array() ) {
	return array_merge(
		array(
			'key'   => 'field_mey_' . $name,
			'name'  => $name,
			'label' => $label,
			'type'  => $type,
		),
		$extra
	);
}

/**
 * Scheda (tab) della pagina di modifica.
 */
function mey_tab( $id, $label ) {
	return array(
		'key'       => 'field_mey_tab_' . $id,
		'label'     => $label,
		'type'      => 'tab',
		'placement' => 'top',
	);
}

/**
 * Elenco dei campi della Home, con lo stesso ordine delle sezioni del sito.
 */
function mey_home_fields() {
	$img  = array(
		'return_format' => 'id',
		'preview_size'  => 'medium',
		'library'       => 'all',
		'mime_types'    => 'jpg,jpeg,png,webp',
	);
	$long = array(
		'tabs'         => 'visual',
		'toolbar'      => 'basic',
		'media_upload' => 0,
	);
	$area = array(
		'rows'      => 3,
		'new_lines' => '',
	);

	return array(
		mey_tab( 'hero', 'In apertura' ),
		mey_field( 'hero_eyebrow', 'Riga sopra il titolo' ),
		mey_field( 'hero_title', 'Titolo' ),
		mey_field( 'hero_sub', 'Sottotitolo', 'textarea', $area ),
		mey_field( 'door_yoga_image', 'Porta «Yoga»: foto', 'image', $img ),
		mey_field( 'door_yoga_title', 'Porta «Yoga»: titolo', 'text', array( 'wrapper' => array( 'width' => 40 ) ) ),
		mey_field( 'door_yoga_desc', 'Porta «Yoga»: descrizione', 'text', array( 'wrapper' => array( 'width' => 60 ) ) ),
		mey_field( 'door_climb_image', 'Porta «Climb»: foto', 'image', $img ),
		mey_field( 'door_climb_title', 'Porta «Climb»: titolo', 'text', array( 'wrapper' => array( 'width' => 40 ) ) ),
		mey_field( 'door_climb_desc', 'Porta «Climb»: descrizione', 'text', array( 'wrapper' => array( 'width' => 60 ) ) ),
		mey_field( 'google_rating', 'Voto su Google', 'text', array( 'instructions' => 'Per esempio 5,0', 'wrapper' => array( 'width' => 25 ) ) ),
		mey_field( 'google_count', 'Numero di recensioni', 'number', array( 'wrapper' => array( 'width' => 25 ) ) ),
		mey_field( 'google_url', 'Link alla scheda Google', 'url', array( 'wrapper' => array( 'width' => 50 ) ) ),

		mey_tab( 'about', 'Chi sono' ),
		mey_field( 'about_title', 'Titolo' ),
		mey_field( 'about_role', 'Nome e ruolo', 'text', array( 'instructions' => 'La riga sotto il titolo.' ) ),
		mey_field( 'about_photo', 'Ritratto', 'image', $img ),
		mey_field( 'about_lead', 'Frase in evidenza', 'textarea', $area ),
		mey_field( 'about_story', 'La mia storia', 'wysiwyg', $long ),
		mey_field( 'about_creds', 'Credenziali', 'textarea', array( 'rows' => 5, 'new_lines' => '', 'instructions' => 'Una per riga: sul sito compaiono in fila, separate da un puntino.' ) ),

		mey_tab( 'yoga', 'Yoga' ),
		mey_field( 'yoga_intro', 'Frase accanto al titolo «Yoga»', 'textarea', $area ),
		mey_field( 'yoga_quote', 'Citazione', 'textarea', $area ),
		mey_field( 'lessons_title', 'Lezioni: titolo' ),
		mey_field( 'lessons_intro', 'Lezioni: introduzione', 'textarea', $area ),
		mey_field( 'lessons_note', 'Nota sugli orari', 'text', array( 'instructions' => 'Le lezioni si modificano dal menu «Lezioni» a sinistra.' ) ),
		mey_field( 'lessons_note_link', 'Nota sugli orari: testo del link ai contatti' ),
		mey_field( 'retreats_note', 'Nota su ritiri ed eventi', 'text', array( 'instructions' => 'Termina con il link a Instagram.' ) ),

		mey_tab( 'climb', 'Climb' ),
		mey_field( 'climb_intro', 'Frase accanto al titolo «Climb»', 'textarea', $area ),
		mey_field( 'climb_photo', 'Foto in parete', 'image', $img ),
		mey_field( 'climb_title', 'Titolo della storia' ),
		mey_field( 'climb_story', 'La storia in parete', 'wysiwyg', $long ),
		mey_field( 'proposals_title', 'Titolo delle proposte', 'text', array( 'instructions' => 'Le proposte si modificano dal menu «Proposte Climb» a sinistra.' ) ),
		mey_field( 'dolmen_title', 'Palestra: nome' ),
		mey_field( 'dolmen_desc', 'Palestra: descrizione', 'textarea', $area ),
		mey_field( 'dolmen_url', 'Palestra: sito', 'url', array( 'wrapper' => array( 'width' => 50 ) ) ),
		mey_field( 'dolmen_address', 'Palestra: indirizzo', 'text', array( 'wrapper' => array( 'width' => 50 ) ) ),

		mey_tab( 'newsletter', 'Newsletter' ),
		mey_field( 'nl_eyebrow', 'Riga sopra il titolo' ),
		mey_field( 'nl_title', 'Nome della newsletter' ),
		mey_field( 'nl_desc', 'Descrizione', 'textarea', $area ),
		mey_field( 'substack_url', 'Indirizzo Substack', 'url', array( 'instructions' => 'Per esempio https://shaktimey.substack.com' ) ),

		mey_tab( 'contact', 'Contatti' ),
		mey_field( 'contact_title', 'Titolo' ),
		mey_field( 'contact_intro', 'Introduzione', 'textarea', $area ),
		mey_field( 'kokoro_name', 'Sede yoga: nome', 'text', array( 'wrapper' => array( 'width' => 40 ) ) ),
		mey_field( 'kokoro_address', 'Sede yoga: indirizzo', 'text', array( 'wrapper' => array( 'width' => 60 ), 'instructions' => 'Sul sito il nome diventa un link a Google Maps.' ) ),
		mey_field( 'instagram_handle', 'Instagram: nome profilo', 'text', array( 'wrapper' => array( 'width' => 40 ) ) ),
		mey_field( 'instagram_url', 'Instagram: link', 'url', array( 'wrapper' => array( 'width' => 60 ) ) ),
		mey_field( 'email', 'Email pubblica', 'email', array( 'wrapper' => array( 'width' => 50 ) ) ),
		mey_field( 'phone', 'Telefono / WhatsApp', 'text', array( 'wrapper' => array( 'width' => 50 ), 'instructions' => 'Lascia vuoto per non mostrarlo.' ) ),
		mey_field( 'form_email', 'Dove ricevere le richieste del modulo', 'email', array( 'instructions' => "Se vuoto, arrivano all'email dell'amministratore del sito." ) ),
		mey_field( 'form_interests', 'Voci del menu «Lezione di interesse»', 'textarea', array( 'rows' => 7, 'new_lines' => '', 'instructions' => 'Una per riga, nel formato Gruppo|Voce (per esempio Yoga|Yin Yoga).' ) ),

		mey_tab( 'site', 'Sito e footer' ),
		mey_field( 'brand_tagline', 'Dicitura accanto al logo' ),
		mey_field( 'cta_label', 'Testo del bottone in alto' ),
		mey_field( 'legal_name', 'Nome nel copyright', 'text', array( 'wrapper' => array( 'width' => 50 ) ) ),
		mey_field( 'vat', 'Partita IVA', 'text', array( 'wrapper' => array( 'width' => 50 ), 'instructions' => 'Lascia vuoto se non serve.' ) ),
		mey_field( 'seo_description', 'Descrizione per Google', 'textarea', array( 'rows' => 2, 'new_lines' => '', 'instructions' => 'Circa 150 caratteri: è il testo sotto il titolo nei risultati di ricerca.' ) ),
	);
}

/**
 * Registra i gruppi di campi.
 */
function mey_register_acf() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'            => 'group_mey_home',
			'title'          => 'Contenuti della home',
			'fields'         => mey_home_fields(),
			'location'       => array( array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ) ),
			'position'       => 'acf_after_title',
			'style'          => 'seamless',
			'hide_on_screen' => array( 'the_content', 'excerpt', 'discussion', 'comments', 'revisions', 'author', 'format', 'featured_image', 'categories', 'tags', 'send-trackbacks' ),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_mey_lezione',
			'title'    => 'Dettagli della lezione',
			'fields'   => array(
				mey_field( 'lezione_descrizione', 'Descrizione', 'textarea', array( 'rows' => 3, 'new_lines' => '' ) ),
				mey_field( 'lezione_durata', 'Durata', 'text', array( 'wrapper' => array( 'width' => 50 ), 'instructions' => 'Per esempio 75 minuti' ) ),
				mey_field( 'lezione_livello', 'Livello', 'text', array( 'wrapper' => array( 'width' => 50 ), 'instructions' => 'Per esempio Adatta a tutti' ) ),
				mey_field( 'lezione_quando', 'Giorno e ora', 'text', array( 'wrapper' => array( 'width' => 50 ), 'instructions' => 'Per esempio Martedì e giovedì, 19:00' ) ),
				mey_field( 'lezione_sede', 'Dove', 'text', array( 'wrapper' => array( 'width' => 50 ), 'instructions' => 'Per esempio Kokoro Studio, oppure Online' ) ),
				mey_field( 'lezione_provvisoria', 'Foto provvisoria', 'true_false', array( 'ui' => 1, 'instructions' => 'Mostra l’etichetta «Foto provvisoria» sulla foto. Toglila quando metti una tua foto.' ) ),
			),
			'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'mey_lezione' ) ) ),
			'position' => 'acf_after_title',
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_mey_proposta',
			'title'    => 'Dettagli della proposta',
			'fields'   => array(
				mey_field( 'proposta_descrizione', 'Descrizione', 'textarea', array( 'rows' => 3, 'new_lines' => '' ) ),
			),
			'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'mey_proposta' ) ) ),
			'position' => 'acf_after_title',
		)
	);
}
add_action( 'acf/init', 'mey_register_acf' );

/**
 * Nomi dei campi della Home che contengono immagini.
 */
function mey_image_fields() {
	return array( 'door_yoga_image', 'door_climb_image', 'about_photo', 'climb_photo' );
}
