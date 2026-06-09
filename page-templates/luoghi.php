<?php
/* Template Name: Luoghi
 *
 * Luoghi template file
 *
 * @package Design_Comuni_Italia
 */
global $post, $with_shadow;
$search_url = esc_url( home_url( '/' ));

get_header();
?>
	<main>
		<?php
		while ( have_posts() ) :
			the_post();
			if (@$data_element=='') $data_element = 'data-element="page-name"';
			$with_shadow = true;
			?>
			<?php get_template_part("template-parts/hero/hero"); ?>
			<?php get_template_part("template-parts/luogo/tutti-luoghi"); ?>
			<?php get_template_part("template-parts/luogo/tipologie"); ?>
			
			<?php get_template_part("template-parts/common/valuta-servizio"); ?>
			<?php get_template_part("template-parts/common/assistenza-contatti"); ?>
		<?php 
			endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();



