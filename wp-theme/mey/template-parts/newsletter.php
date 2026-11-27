<?php
/**
 * Newsletter su Substack: il modulo invia l'iscrizione direttamente a Substack
 * (che manda l'email di conferma). Se un giorno Substack cambiasse, resta il link alla pagina.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

$substack = untrailingslashit( mey_get( 'substack_url' ) );
if ( ! $substack ) {
	return;
}
?>
<section id="newsletter" class="newsletter" aria-labelledby="nl-title">
	<div class="wrap newsletter__in">
		<p class="eyebrow"><?php echo esc_html( mey_get( 'nl_eyebrow' ) ); ?></p>
		<h2 id="nl-title" class="newsletter__title"><?php echo esc_html( mey_get( 'nl_title' ) ); ?></h2>
		<p class="newsletter__desc"><?php echo esc_html( mey_get( 'nl_desc' ) ); ?></p>
		<form class="nl-form" action="<?php echo esc_url( $substack . '/api/v1/free?nojs=true' ); ?>" method="post" target="_blank">
			<label for="nl-email" class="sr-only">La tua email</label>
			<input id="nl-email" type="email" name="email" autocomplete="email" placeholder="La tua email" required>
			<button type="submit" class="btn btn--dark">Iscriviti gratis</button>
		</form>
		<p class="newsletter__small">Niente spam, ti cancelli quando vuoi. <a href="<?php echo esc_url( $substack ); ?>">Leggi i numeri su Substack</a> · <a href="<?php echo esc_url( mey_privacy_url() ); ?>">Privacy</a></p>
	</div>
</section>
