<?php
/**
 * Capitolo Yoga: apertura con la citazione e le lezioni (dal menu «Lezioni» della bacheca).
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

$lessons = mey_items( 'mey_lezione' );
?>
<section id="yoga" class="chapter-yoga" aria-labelledby="yoga-title">
	<div class="wrap chapter__head">
		<h2 id="yoga-title" class="title-xl"><?php echo esc_html( mey_get( 'door_yoga_title' ) ); ?></h2>
		<p class="chapter__intro"><?php echo esc_html( mey_get( 'yoga_intro' ) ); ?></p>
		<?php if ( mey_get( 'yoga_quote' ) ) : ?>
			<blockquote class="chapter__quote">«<?php echo esc_html( mey_get( 'yoga_quote' ) ); ?>»<footer>— Mey</footer></blockquote>
		<?php endif; ?>
	</div>
</section>

<section id="lezioni" class="lessons" aria-labelledby="lezioni-title">
	<div class="wrap lessons__in">
		<div class="lessons__head">
			<div>
				<p class="eyebrow">Lezioni</p>
				<h2 id="lezioni-title" class="title-l"><?php echo esc_html( mey_get( 'lessons_title' ) ); ?></h2>
			</div>
			<p class="lessons__intro"><?php echo esc_html( mey_get( 'lessons_intro' ) ); ?></p>
		</div>

		<?php if ( $lessons ) : ?>
			<div class="cards">
				<?php
				foreach ( $lessons as $lesson ) :
					$f    = function ( $name ) use ( $lesson ) {
						return function_exists( 'get_field' ) ? get_field( $name, $lesson->ID ) : get_post_meta( $lesson->ID, $name, true );
					};
					$meta = array_filter( array( $f( 'lezione_durata' ), $f( 'lezione_livello' ) ) );
					$when = array_filter( array( $f( 'lezione_quando' ), $f( 'lezione_sede' ) ) );
					?>
					<article class="lesson">
						<div class="lesson__photo">
							<?php
							if ( has_post_thumbnail( $lesson ) ) {
								echo get_the_post_thumbnail( $lesson, 'mey-card', array( 'loading' => 'lazy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput
							}
							if ( $f( 'lezione_provvisoria' ) ) {
								echo '<span class="tag-temp">Foto provvisoria</span>';
							}
							?>
						</div>
						<div class="lesson__body">
							<h3 class="lesson__title"><?php echo esc_html( get_the_title( $lesson ) ); ?></h3>
							<?php if ( $f( 'lezione_descrizione' ) ) : ?>
								<p class="lesson__desc"><?php echo esc_html( $f( 'lezione_descrizione' ) ); ?></p>
							<?php endif; ?>
							<?php if ( $meta ) : ?>
								<p class="lesson__meta"><?php echo esc_html( implode( ' · ', $meta ) ); ?></p>
							<?php endif; ?>
							<?php if ( $when ) : ?>
								<p class="lesson__when"><?php echo esc_html( implode( ' · ', $when ) ); ?></p>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="lessons__notes">
			<p><?php echo esc_html( mey_get( 'lessons_note' ) ); ?> <a class="tap" href="<?php echo esc_url( mey_anchor( 'contatti' ) ); ?>"><?php echo esc_html( mey_get( 'lessons_note_link' ) ); ?></a>.</p>
			<?php if ( mey_get( 'retreats_note' ) ) : ?>
				<p><?php echo esc_html( mey_get( 'retreats_note' ) ); ?> <a class="tap" href="<?php echo esc_url( mey_get( 'instagram_url' ) ); ?>">Instagram</a>.</p>
			<?php endif; ?>
		</div>
	</div>
</section>
