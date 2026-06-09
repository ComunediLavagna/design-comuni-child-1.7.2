<?php
/* Template Name: Altro personale
 *
 * Altro personale template file
 *
 * @package Design_Comuni_Italia
 */
global $post, $with_shadow;
$search_url = esc_url( home_url( '/' ));

global $filtra_incarico; $filtra_incarico = 'altro';
global $filtra_uo; $filtra_uo = 'altra-struttura';

get_header();
?>
	<main>
		<?php
		while ( have_posts() ) :
			the_post();
			if (@$data_element=='') $data_element = 'data-element="page-name"';
			$with_shadow = false;
			?>
			<?php get_template_part("template-parts/hero/hero"); ?>
                
			<div class="container">
				<article class="article-wrapper">

					<div class="row variable-gutters">
						<div class="col-lg-12">
							<?php the_content(); ?>
						</div><!-- /col-lg-9 -->
					</div><!-- /row -->

				</article>
				
				<?php if(is_user_logged_in()) { ?>
					<div class="card card-teaser shadow rounded">
						Questa pagina elenca le Persone Pubbliche con Incarico di tipo "altro" e quelle appartenenti ad Unità Organizzative di tipo "altra struttura"
					</div>
				<?php } ?>
				
			</div>
			
			<?php get_template_part("template-parts/persona/elenco-persone"); ?>
			
			<?php get_template_part("template-parts/common/valuta-servizio"); ?>
			<?php get_template_part("template-parts/common/assistenza-contatti"); ?>
		<?php 
			endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();



