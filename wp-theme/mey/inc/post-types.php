<?php
/**
 * Tipi di contenuto: Lezioni e Proposte Climb.
 * Mey li gestisce dalla bacheca come se fossero articoli; l'ordine si cambia con "Ordine" negli attributi.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra i due tipi di contenuto.
 */
function mey_register_post_types() {
	register_post_type(
		'mey_lezione',
		array(
			'labels'             => array(
				'name'               => 'Lezioni',
				'singular_name'      => 'Lezione',
				'add_new'            => 'Aggiungi lezione',
				'add_new_item'       => 'Aggiungi una nuova lezione',
				'edit_item'          => 'Modifica lezione',
				'new_item'           => 'Nuova lezione',
				'all_items'          => 'Tutte le lezioni',
				'search_items'       => 'Cerca lezioni',
				'not_found'          => 'Nessuna lezione',
				'not_found_in_trash' => 'Nessuna lezione nel cestino',
				'featured_image'     => 'Foto della lezione',
				'set_featured_image' => 'Scegli la foto',
				'menu_name'          => 'Lezioni',
			),
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => false,
			'menu_position'      => 21,
			'menu_icon'          => 'dashicons-heart',
			'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
			'hierarchical'       => false,
			'has_archive'        => false,
			'rewrite'            => false,
		)
	);

	register_post_type(
		'mey_proposta',
		array(
			'labels'        => array(
				'name'               => 'Proposte Climb',
				'singular_name'      => 'Proposta Climb',
				'add_new'            => 'Aggiungi proposta',
				'add_new_item'       => 'Aggiungi una nuova proposta',
				'edit_item'          => 'Modifica proposta',
				'all_items'          => 'Tutte le proposte',
				'not_found'          => 'Nessuna proposta',
				'not_found_in_trash' => 'Nessuna proposta nel cestino',
				'menu_name'          => 'Proposte Climb',
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'show_in_rest'  => false,
			'menu_position' => 22,
			'menu_icon'     => 'dashicons-location-alt',
			'supports'      => array( 'title', 'page-attributes' ),
			'has_archive'   => false,
			'rewrite'       => false,
		)
	);
}
add_action( 'init', 'mey_register_post_types' );

/**
 * Elenco lezioni o proposte, nell'ordine scelto da Mey.
 *
 * @return WP_Post[]
 */
function mey_items( $post_type ) {
	return get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => 12,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'ASC',
			),
			'no_found_rows'  => true,
		)
	);
}

/**
 * Colonna "Ordine" nell'elenco della bacheca, per capire subito la sequenza.
 */
function mey_order_column( $columns ) {
	$columns['menu_order'] = 'Ordine';
	return $columns;
}
add_filter( 'manage_mey_lezione_posts_columns', 'mey_order_column' );
add_filter( 'manage_mey_proposta_posts_columns', 'mey_order_column' );

function mey_order_column_value( $column, $post_id ) {
	if ( 'menu_order' === $column ) {
		echo (int) get_post_field( 'menu_order', $post_id );
	}
}
add_action( 'manage_mey_lezione_posts_custom_column', 'mey_order_column_value', 10, 2 );
add_action( 'manage_mey_proposta_posts_custom_column', 'mey_order_column_value', 10, 2 );
