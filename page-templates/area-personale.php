<?php
/* Template Name: Area personale
 *
 * Area personale template file
 *
 * @package Design_Comuni_Italia
 */
 
/*** Added by STS 2023 ***/
 
global $post, $with_shadow;
$search_url = esc_url( home_url( '/' ));

global $data_element;

get_header();
?>
	<main>
		<?php
		while ( have_posts() ) :
			the_post();
			#$with_shadow = true;
			if ($data_element=='') $data_element = 'data-element="page-name"';
			?>
			<?php get_template_part("template-parts/hero/hero"); ?>
		    <div class="container ">
			<article class="article-wrapper" data-audio>
				<div class="row">
					<div class="col-lg-12">
						<?php the_content(); ?>
					</div>
				</div>
				<?php if(!is_user_logged_in()) { ?>
				<div class="d-flex justify-content-end mb-3">
					<p class="text-lg-end">
						<a href="/wp-login.php" 
							class="btn btn-outline-primary full-mb" 
							aria-label="aria-label" 
							data-element="personal-area-login-button" 
							data-focus-mouse="false">
								Accedi
								<svg class="icon icon-primary icon-xs ml-10">
									<use href="#it-arrow-right"></use>
								</svg>
						</a>
					</p>
				</div>
				<?php } ?>
			</article>
		    </div>
		    
			<?php 
			// SERVIZI ONLINE IN EVIDENZA (DALLA HOME)
			$schede = dci_get_option('schede_evidenziate', 'homepage') ?? null;
			if ($schede && count($schede) > 0) { ?>
					<div class="container my-5">
					    <div class="row row-title">
						<div class="col-12 d-lg-flex justify-content-between">
						    <h2 class="mb-lg-0">In evidenza</h2>
						</div>
					    </div>
					    <div class="row mb-2">
						<div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
						    <?php $count = 1;
						    foreach ($schede as $scheda) {
							if ($scheda) {
							    get_template_part("template-parts/home/scheda-evidenza");
							}
							++$count;
						    } ?>
						</div>
					    </div>
					</div>
			<?php } ?>
			
			<?php get_template_part("template-parts/common/valuta-servizio"); ?>
			<?php get_template_part("template-parts/common/assistenza-contatti"); ?>
		<?php 
			endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();



