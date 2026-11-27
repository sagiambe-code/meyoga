<?php
/**
 * Pagine semplici (Privacy, Cookie).
 *
 * @package Mey
 */

defined( 'ABSPATH' ) || exit;

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<article class="wrap page-plain">
		<h1><?php the_title(); ?></h1>
		<div class="entry"><?php the_content(); ?></div>
	</article>
	<?php
endwhile;
get_footer();
