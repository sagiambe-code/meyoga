<?php
/**
 * Contatti: recapiti e modulo con invio vero (wp_mail).
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

$notice  = mey_form_notice();
$kokoro  = mey_get( 'kokoro_name' );
$dolmen  = mey_get( 'dolmen_title' );
$email   = mey_get( 'email' );
$phone   = mey_get( 'phone' );
$phone_d = preg_replace( '/[^0-9+]/', '', (string) $phone );
?>
<section id="contatti" class="contact" aria-labelledby="contatti-title">
	<div class="wrap contact__in">
		<div class="contact__side">
			<p class="eyebrow">Contatti</p>
			<h2 id="contatti-title" class="title-l"><?php echo esc_html( mey_get( 'contact_title' ) ); ?></h2>
			<p class="muted"><?php echo esc_html( mey_get( 'contact_intro' ) ); ?></p>
			<dl class="contact__list">
				<div>
					<dt>Dove</dt>
					<dd>
						<a href="<?php echo esc_url( mey_maps_url( $kokoro . ', ' . mey_get( 'kokoro_address' ) ) ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $kokoro . ', ' . mey_get( 'kokoro_address' ) . ': apri in Google Maps' ); ?>"><?php echo esc_html( $kokoro ); ?></a>
						·
						<a href="<?php echo esc_url( mey_maps_url( $dolmen . ', ' . mey_get( 'dolmen_address' ) ) ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $dolmen . ', ' . mey_get( 'dolmen_address' ) . ': apri in Google Maps' ); ?>"><?php echo esc_html( $dolmen ); ?></a>
					</dd>
				</div>
				<div>
					<dt>Instagram</dt>
					<dd><a href="<?php echo esc_url( mey_get( 'instagram_url' ) ); ?>"><?php echo esc_html( mey_get( 'instagram_handle' ) ); ?></a></dd>
				</div>
				<?php if ( is_email( $email ) ) : ?>
					<div>
						<dt>Email</dt>
						<dd><a href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></dd>
					</div>
				<?php endif; ?>
				<?php if ( $phone_d ) : ?>
					<div>
						<dt>Telefono / WhatsApp</dt>
						<dd><a href="<?php echo esc_url( 'tel:' . $phone_d ); ?>"><?php echo esc_html( $phone ); ?></a> · <a href="<?php echo esc_url( 'https://wa.me/' . ltrim( str_replace( '+', '', strlen( $phone_d ) === 10 ? '39' . $phone_d : $phone_d ), '0' ) ); ?>">WhatsApp</a></dd>
					</div>
				<?php endif; ?>
			</dl>
		</div>

		<form class="cform" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
			<?php if ( $notice ) : ?>
				<p class="cform__notice cform__notice--<?php echo esc_attr( $notice[0] ); ?>" role="<?php echo 'ok' === $notice[0] ? 'status' : 'alert'; ?>"><?php echo esc_html( $notice[1] ); ?></p>
			<?php endif; ?>
			<input type="hidden" name="action" value="mey_contatto">
			<input type="hidden" name="mey_t" value="<?php echo esc_attr( time() ); ?>">
			<?php wp_nonce_field( 'mey_contatto', 'mey_nonce' ); ?>
			<div class="cform__hp" aria-hidden="true">
				<label for="f-sito">Lascia vuoto questo campo</label>
				<input id="f-sito" type="text" name="sito_web" tabindex="-1" autocomplete="off">
			</div>

			<div class="cform__field">
				<label for="f-nome">Nome</label>
				<input id="f-nome" type="text" name="nome" autocomplete="name" required>
			</div>
			<div class="cform__field">
				<label for="f-email">Email</label>
				<input id="f-email" type="email" name="email" autocomplete="email" required>
			</div>
			<div class="cform__field">
				<label for="f-tel">Telefono <span class="opt">(facoltativo)</span></label>
				<input id="f-tel" type="tel" name="telefono" autocomplete="tel">
			</div>
			<div class="cform__field">
				<label for="f-corso">Lezione di interesse</label>
				<select id="f-corso" name="interesse">
					<?php foreach ( mey_form_interests() as $group => $options ) : ?>
						<?php if ( '' !== $group ) : ?>
							<optgroup label="<?php echo esc_attr( $group ); ?>">
						<?php endif; ?>
						<?php foreach ( $options as $opt ) : ?>
							<option><?php echo esc_html( $opt ); ?></option>
						<?php endforeach; ?>
						<?php if ( '' !== $group ) : ?>
							</optgroup>
						<?php endif; ?>
					<?php endforeach; ?>
					<option>Non lo so ancora</option>
				</select>
			</div>
			<div class="cform__field cform__field--full">
				<label for="f-msg">Messaggio</label>
				<textarea id="f-msg" name="messaggio" rows="5" required></textarea>
			</div>
			<div class="cform__check">
				<input id="f-privacy" type="checkbox" name="privacy" value="1" required>
				<label for="f-privacy">Ho letto l'<a href="<?php echo esc_url( mey_privacy_url() ); ?>">informativa privacy</a> e acconsento al trattamento dei dati per essere ricontattata/o.</label>
			</div>
			<div class="cform__submit">
				<button type="submit" class="btn btn--dark">Invia la richiesta</button>
			</div>
		</form>
	</div>
</section>
