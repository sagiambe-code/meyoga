<?php
/**
 * Chi sono: la storia di Mey, comune ai due capitoli.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

$creds = mey_lines( mey_get( 'about_creds' ) );
?>
<section id="chi-sono" class="about">
	<div class="wrap about__in">
		<div class="about__side">
			<p class="eyebrow">Chi sono</p>
			<h2 class="title-l"><?php echo esc_html( mey_get( 'about_title' ) ); ?></h2>
			<p class="about__role"><?php echo esc_html( mey_get( 'about_role' ) ); ?></p>
			<div class="about__photo">
				<?php mey_image( 'about_photo', 'mey-ritratto-mudra.jpg', 'Ritratto di Mey a occhi chiusi, braccia intrecciate davanti al viso, sul mare', array( 'loading' => 'lazy' ), 'mey-tall' ); ?>
			</div>
		</div>
		<div class="about__body">
			<p class="about__lead"><?php echo esc_html( mey_get( 'about_lead' ) ); ?></p>
			<div class="about__story"><?php echo mey_kses( wpautop( mey_get( 'about_story' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
			<?php if ( $creds ) : ?>
				<p class="about__creds"><?php echo esc_html( implode( ' · ', $creds ) ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
