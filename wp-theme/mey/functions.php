<?php
/**
 * Tema Mey — funzioni principali.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

define( 'MEY_VERSION', '1.0.0' );
define( 'MEY_DIR', get_template_directory() );
define( 'MEY_URI', get_template_directory_uri() );

require MEY_DIR . '/inc/defaults.php';
require MEY_DIR . '/inc/helpers.php';
require MEY_DIR . '/inc/post-types.php';
require MEY_DIR . '/inc/acf-fields.php';
require MEY_DIR . '/inc/contact-form.php';
require MEY_DIR . '/inc/schema.php';
require MEY_DIR . '/inc/setup-content.php';

/**
 * Impostazioni di base del tema.
 */
function mey_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'principale' => 'Menu principale (header)',
			'footer'     => 'Menu del footer',
		)
	);

	add_image_size( 'mey-card', 800, 600, true );
	add_image_size( 'mey-tall', 900, 1200, false );
}
add_action( 'after_setup_theme', 'mey_setup' );

/**
 * CSS e JavaScript del tema (font inclusi nel tema, nessuna chiamata esterna).
 */
function mey_assets() {
	wp_enqueue_style( 'mey', get_stylesheet_uri(), array(), MEY_VERSION );
	wp_enqueue_script( 'mey', MEY_URI . '/assets/js/mey.js', array(), MEY_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'mey_assets' );

/**
 * Precarica i due font principali per evitare il "salto" del testo.
 */
function mey_preload_fonts() {
	foreach ( array( 'marcellus-latin-400-normal', 'figtree-latin-400-normal' ) as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( MEY_URI . '/assets/fonts/' . $font . '.woff2' )
		);
	}
}
add_action( 'wp_head', 'mey_preload_fonts', 1 );

/**
 * Meta description per la home (modificabile dalla bacheca).
 */
function mey_meta_description() {
	if ( ! is_front_page() ) {
		return;
	}
	$desc = mey_get( 'seo_description' );
	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	}
}
add_action( 'wp_head', 'mey_meta_description', 2 );

/**
 * Niente emoji script e altre aggiunte inutili in testa alla pagina.
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );

/**
 * La Home si modifica solo con i campi: niente editor a blocchi, niente area di testo vuota.
 */
function mey_home_no_block_editor( $use, $post ) {
	if ( $post && (int) $post->ID === mey_home_id() ) {
		return false;
	}
	return $use;
}
add_filter( 'use_block_editor_for_post', 'mey_home_no_block_editor', 10, 2 );

function mey_home_no_editor() {
	$post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0; // phpcs:ignore WordPress.Security.NonceVerification
	if ( $post_id && $post_id === mey_home_id() ) {
		remove_post_type_support( 'page', 'editor' );
		remove_post_type_support( 'page', 'thumbnail' );
		add_action(
			'edit_form_after_title',
			function () {
				echo '<p style="margin:16px 0 0;font-size:14px">Qui modifichi i testi e le foto della home, scheda per scheda. Le lezioni e le proposte Climb hanno il loro menu a sinistra.</p>';
			}
		);
	}
}
add_action( 'load-post.php', 'mey_home_no_editor' );

/**
 * Niente blog e niente commenti: tolgo le voci dal menu della bacheca per non confondere.
 */
function mey_simplify_admin_menu() {
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'mey_simplify_admin_menu' );
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );

/**
 * Avviso in bacheca se manca ACF: il sito funziona comunque con i testi predefiniti.
 */
function mey_acf_notice() {
	if ( function_exists( 'acf_add_local_field_group' ) || ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p><strong>Tema Mey:</strong> per modificare i testi dalla bacheca installa e attiva il plugin gratuito <em>Advanced Custom Fields</em> (Plugin › Aggiungi nuovo). Finché manca, il sito mostra i testi predefiniti.</p></div>';
}
add_action( 'admin_notices', 'mey_acf_notice' );
