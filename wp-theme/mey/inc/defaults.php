<?php
/**
 * Testi predefiniti della home: sono quelli della bozza approvata.
 * Quando Mey compila un campo in bacheca, il suo testo sostituisce quello qui sotto.
 * Le parti tra [ ] sono informazioni ancora da ricevere.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

/**
 * Restituisce tutti i valori predefiniti.
 *
 * @return array<string,string>
 */
function mey_defaults() {
	return array(
		// SEO.
		'seo_description'   => 'Mey, insegnante di yoga e climber a Trapani: Yin, Hatha, Bhakti Prema Vinyasa, consulenze 1:1 e arrampicata, con Ayurveda e astrologia vedica.',

		// Header.
		'brand_tagline'     => 'Yoga · Ayurveda · Arrampicata',
		'cta_label'         => 'Prenota una lezione',

		// Hero.
		'hero_eyebrow'      => 'Mey · Yoga teacher & climber',
		'hero_title'        => 'Abitare il proprio corpo.',
		'hero_sub'          => 'Sul tappetino e in parete, due modi di ascoltarsi e di scoprire che un limite può diventare forza.',
		'door_yoga_title'   => 'Yoga',
		'door_yoga_desc'    => "Lezioni, ritiri e i ritmi dell'Ayurveda",
		'door_climb_title'  => 'Climb',
		'door_climb_desc'   => "L'arrampicata, un limite diventato forza",

		// Recensioni Google.
		'google_rating'     => '5,0',
		'google_count'      => '29',
		'google_url'        => 'https://share.google/Gc3roNONUlj2T2XfU',

		// Chi sono.
		'about_title'       => 'Amore a primo respiro.',
		'about_role'        => 'Mariagrazia [COGNOME], insegnante di yoga e climber',
		'about_lead'        => 'Ho iniziato a praticare per prendermi cura di me, non per insegnare.',
		'about_story'       => "<p>Era un periodo in cui la vita aveva ripreso a correre più forte di me, e lavoravo con i bambini all'asilo. Il tappetino è diventato il luogo in cui ascoltarmi, e quella pratica, condivisa con gli altri, si è rivelata così potente da spingermi a lasciare la scuola per dedicarmi interamente allo yoga.</p>\n<p>Poi è arrivato l'incontro con la mia maestra, Ameriga, che mi ha cambiato la vita e mi ha portata sulla roccia: in parete, come sul tappetino, ho capito che i limiti sono spesso solo proiezioni della mente.</p>\n<p>Oggi, accanto alla pratica, studio l'Ayurveda e il Jyotish, l'astrologia vedica, per accordare lo yoga ai ritmi di ciascuno.</p>",
		'about_creds'       => "Insegnante RYT 250 di Hatha yoga, certificata Yoga Alliance e CSEN\nIn formazione Advanced 300 ore con Ameriga Giannone\nSpecializzazione in Ayur-yoga\nCofondatrice di Dolmen Climb",

		// Capitolo Yoga.
		'yoga_intro'        => "Pratica, ascolto e i ritmi dell'Ayurveda, in sala, online e nei ritiri.",
		'yoga_quote'        => "Prendersi cura di sé, portando ascolto e presenza, è l'atto d'amore più grande che si possa fare.",
		'lessons_title'     => 'Tre modi di praticare.',
		'lessons_intro'     => 'Lezioni di gruppo e individuali, in sala e online. Non serve esperienza: basta il desiderio di rallentare.',
		'lessons_note'      => 'Gli orari cambiano con le stagioni:',
		'lessons_note_link' => 'scrivimi per i posti liberi',
		'retreats_note'     => 'Organizzo anche ritiri ed eventi: le date escono su',

		// Capitolo Climb.
		'climb_intro'       => "L'arrampicata come pratica di ascolto: in parete, come sul tappetino.",
		'climb_title'       => 'Un limite diventato forza.',
		'climb_story'       => "<p>L'arrampicata me l'ha fatta scoprire la mia maestra, ed è arrivata come una sfida: poi, appiglio dopo appiglio, è diventata anche lei una maestra. Da questa passione, insieme ai miei soci, è nata Dolmen Climb, la palestra di arrampicata indoor di Trapani.</p>",
		'proposals_title'   => 'Cosa propongo',
		'dolmen_title'      => 'Dolmen Climb',
		'dolmen_desc'       => 'La palestra di arrampicata indoor che ho fondato a Trapani insieme ai miei soci. Orari, prove e abbonamenti sono sul sito della palestra.',
		'dolmen_url'        => 'https://www.dolmenclimb.com/',
		'dolmen_address'    => 'Via dei Mulini 17, Trapani',

		// Newsletter.
		'nl_eyebrow'        => 'La newsletter di Mey · su Substack',
		'nl_title'          => 'Ritmi Ancestrali',
		'nl_desc'           => 'Pratiche da fare a casa, consigli ayurvedici e i ritmi delle stagioni, direttamente nella tua casella di posta. [Frequenza: es. una volta al mese]',
		'substack_url'      => 'https://shaktimey.substack.com',

		// Contatti.
		'contact_title'     => 'Prenota la tua prima lezione.',
		'contact_intro'     => 'Scrivimi cosa cerchi e quando sei disponibile: ti rispondo con il corso più adatto e i prossimi posti liberi.',
		'kokoro_name'       => 'Kokoro Studio',
		'kokoro_address'    => 'Via Alessandro Manzoni 134/b, Casa Santa (TP)',
		'instagram_handle'  => '@shaktimey_yogaeclimb',
		'instagram_url'     => 'https://www.instagram.com/shaktimey_yogaeclimb/',
		'email'             => '',
		'phone'             => '',
		'form_interests'    => "Yoga|Yin Yoga\nYoga|Hatha Yoga\nYoga|Bhakti Prema Vinyasa\nYoga|Lezione individuale o consulenza 1:1\nYoga|Lezione online\nYoga|Ritiro\nClimb|Arrampicata e yoga per climber",

		// Footer.
		'legal_name'        => 'Mariagrazia [COGNOME]',
		'vat'               => '',
	);
}
