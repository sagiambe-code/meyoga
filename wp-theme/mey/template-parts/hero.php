<?php
/**
 * Apertura con le due porte: Yoga e Climb.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

$count = (int) mey_get( 'google_count' );
?>
<section id="top" class="wrap hero">
	<div class="hero__text">
		<p class="eyebrow"><?php echo esc_html( mey_get( 'hero_eyebrow' ) ); ?></p>
		<h1 class="hero__title"><?php echo esc_html( mey_get( 'hero_title' ) ); ?></h1>
		<p class="hero__sub"><?php echo esc_html( mey_get( 'hero_sub' ) ); ?></p>
		<?php if ( $count > 0 ) : ?>
			<a class="rating" href="<?php echo esc_url( mey_get( 'google_url' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Valutazione %s su 5 su Google, %d recensioni', mey_get( 'google_rating' ), $count ) ); ?>">
				<span class="rating__stars" aria-hidden="true">★★★★★</span>
				<span><strong><?php echo esc_html( mey_get( 'google_rating' ) ); ?></strong> su Google · <span class="rating__count"><?php echo esc_html( $count ); ?> recensioni</span></span>
			</a>
		<?php endif; ?>
	</div>

	<div class="doors">
		<a class="door" href="<?php echo esc_url( mey_anchor( 'yoga' ) ); ?>">
			<?php mey_image( 'door_yoga_image', 'mey-hero-scoglio.jpg', 'Mey in allungamento laterale su uno scoglio, con il mare alle spalle', array( 'style' => 'object-position:center 35%', 'fetchpriority' => 'high' ), 'mey-tall' ); ?>
			<span class="door__panel">
				<span class="door__label">
					<span class="door__name"><?php echo esc_html( mey_get( 'door_yoga_title' ) ); ?></span>
					<span class="door__desc"><?php echo esc_html( mey_get( 'door_yoga_desc' ) ); ?></span>
				</span>
				<?php echo mey_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</span>
		</a>
		<a class="door door--climb" href="<?php echo esc_url( mey_anchor( 'climb' ) ); ?>">
			<?php mey_image( 'door_climb_image', 'mey-parete.jpg', 'Mey arrampica su un masso di roccia chiara, appesa con un braccio e una gamba tesa', array( 'style' => 'object-position:55% 25%' ), 'mey-tall' ); ?>
			<span class="door__panel">
				<span class="door__label">
					<span class="door__name"><?php echo esc_html( mey_get( 'door_climb_title' ) ); ?></span>
					<span class="door__desc"><?php echo esc_html( mey_get( 'door_climb_desc' ) ); ?></span>
				</span>
				<?php echo mey_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</span>
		</a>
	</div>
</section>
