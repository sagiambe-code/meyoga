<?php
/**
 * Capitolo Climb: la storia in parete, le proposte (menu «Proposte Climb») e la palestra.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

$proposals = mey_items( 'mey_proposta' );
?>
<div id="climb" class="chapter-climb">
	<section class="wrap chapter__head" aria-labelledby="climb-title">
		<h2 id="climb-title" class="title-xl"><?php echo esc_html( mey_get( 'door_climb_title' ) ); ?></h2>
		<p class="chapter__intro"><?php echo esc_html( mey_get( 'climb_intro' ) ); ?></p>
	</section>

	<section class="wrap climb-story" aria-labelledby="climb-storia">
		<div class="climb-story__photo">
			<?php mey_image( 'climb_photo', 'mey-parete.jpg', 'Mey arrampica su un masso di roccia chiara, appesa con un braccio e una gamba tesa', array( 'loading' => 'lazy' ), 'mey-tall' ); ?>
		</div>
		<div class="climb-story__text">
			<h3 id="climb-storia" class="title-l"><?php echo esc_html( mey_get( 'climb_title' ) ); ?></h3>
			<?php echo mey_kses( wpautop( mey_get( 'climb_story' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</section>

	<?php if ( $proposals ) : ?>
		<section class="wrap proposals" aria-labelledby="climb-proposte">
			<h3 id="climb-proposte" class="eyebrow"><?php echo esc_html( mey_get( 'proposals_title' ) ); ?></h3>
			<div class="proposals__grid">
				<?php
				foreach ( $proposals as $p ) :
					$desc = function_exists( 'get_field' ) ? get_field( 'proposta_descrizione', $p->ID ) : get_post_meta( $p->ID, 'proposta_descrizione', true );
					?>
					<article class="proposal">
						<h4 class="proposal__title"><?php echo esc_html( get_the_title( $p ) ); ?></h4>
						<?php if ( $desc ) : ?>
							<p class="proposal__desc"><?php echo esc_html( $desc ); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<section class="dolmen" aria-labelledby="dolmen">
		<div class="wrap dolmen__in">
			<div class="dolmen__text">
				<p class="eyebrow">La palestra</p>
				<h3 id="dolmen" class="dolmen__title"><?php echo esc_html( mey_get( 'dolmen_title' ) ); ?></h3>
				<p class="dolmen__desc"><?php echo esc_html( mey_get( 'dolmen_desc' ) ); ?></p>
			</div>
			<div class="dolmen__cta">
				<a class="btn btn--accent" href="<?php echo esc_url( mey_get( 'dolmen_url' ) ); ?>" target="_blank" rel="noopener">Vai a <?php echo esc_html( mey_get( 'dolmen_title' ) ); ?><?php echo mey_icon( 'external' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				<span class="dolmen__addr"><?php echo esc_html( mey_get( 'dolmen_address' ) ); ?></span>
			</div>
		</div>
	</section>
</div>
