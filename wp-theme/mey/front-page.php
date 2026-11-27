<?php
/**
 * Home a pagina unica: le sezioni sono in template-parts/, nell'ordine del sito.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

get_header();

foreach ( array( 'hero', 'about', 'yoga', 'climb', 'newsletter', 'contact' ) as $section ) {
	get_template_part( 'template-parts/' . $section );
}

get_footer();
