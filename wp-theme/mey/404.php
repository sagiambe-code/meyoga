<?php
/**
 * Pagina non trovata.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="wrap page-plain">
	<p class="eyebrow">Errore 404</p>
	<h1>Questa pagina non c'è.</h1>
	<p class="muted">Forse il link è cambiato. Dalla home trovi tutto: lezioni, arrampicata e contatti.</p>
	<p style="margin-top:32px"><a class="btn btn--dark" href="<?php echo esc_url( home_url( '/' ) ); ?>">Torna alla home</a></p>
</div>
<?php
get_footer();
