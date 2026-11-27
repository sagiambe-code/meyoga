<?php
/**
 * Modello di riserva: il sito è una pagina unica, quindi rimanda alla home
 * per qualsiasi archivio che WordPress dovesse generare.
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="wrap page-plain">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article>
				<h1><?php the_title(); ?></h1>
				<div class="entry"><?php the_content(); ?></div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<h1>Niente da mostrare qui</h1>
		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Torna alla home</a></p>
	<?php endif; ?>
</div>
<?php
get_footer();
