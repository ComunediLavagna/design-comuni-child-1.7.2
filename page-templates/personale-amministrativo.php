<?php
/* Template Name: Personale amministrativo
 *
 * Personale amministrativo template file
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
						Questa pagina elenca Le Unità Organizzative di tipo "struttura organizzativa", le Persone Pubbliche ad esse appartenenti e quelle con Incarico di tipo "amministrativo".
					</div>
				<?php } ?>
				
			</div>
			<?php /* ?>
			<div class="container mt-5">
			<h2>Aree, Uffici e Servizi</h2>
			</div>
			<?php
				global $filtra_uo; $filtra_uo = 'struttura-amministrativa';
				get_template_part("template-parts/unita-organizzativa/elenco-uo");
			?>
			<div class="container mt-5">
			<h2>Persone</h2>
			</div>
			<?php */ ?>
			<?php
				global $filtra_incarico; $filtra_incarico = 'amministrativo';
				global $filtra_uo; $filtra_uo = 'struttura-amministrativa';
				get_template_part("template-parts/persona/elenco-persone");
			?>
			
			<?php get_template_part("template-parts/common/valuta-servizio"); ?>
			<?php get_template_part("template-parts/common/assistenza-contatti"); ?>
		<?php 
			endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();



