<?php
/* Template Name: Pagine amministrative
 *
 * Pagine amministrative template file
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
			
                <div class="container">
                    <article class="article-wrapper">

                        <div class="row variable-gutters">
                            <div class="col-lg-12">
                                <?php
                                the_content();
                                ?>
                            </div><!-- /col-lg-9 -->
                        </div><!-- /row -->

                    </article>
                </div>
			
			<?php get_template_part("template-parts/common/valuta-servizio"); ?>
			<?php get_template_part("template-parts/common/assistenza-contatti"); ?>
		<?php 
			endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();



