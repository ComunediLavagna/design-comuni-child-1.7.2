<?php
/* Template Name: Mappa del sito
 *
 * Mappa del sito template file
 *
 * @package Design_Comuni_Italia
 */
global $post, $with_shadow;
$search_url = esc_url( home_url( '/' ));

get_header();
?>
	<main>
		<?php 
			if (@$data_element=='') $data_element = 'data-element="page-name"';
			$with_shadow = false;
			get_template_part("template-parts/hero/hero");
		?>

		<div class="container mb-4">
			<article class="article-wrapper">
				<h2 class="visually-hidden">Elenco dei contenuti</h2>
				<div class="row variable-gutters">
					<div class="col-lg-12 mb-4">
						<?php the_content(); ?>
					</div>
					
					<h3 class="my-4">Tutte le pagine del sito</h3>
					<div class="col-lg-4 col-md-6 col-sm-12">

						<div class="mb-5">
							<h4>Pagine principali</h4>
							<ul class="py-3">
							<?php wp_list_pages( array( 'exclude' => '', 'title_li' => '', 'orderby' => 'name' ) ); ?>
							</ul>
						</div>
						
						<?php /*
						<div class="mb-5">
							<h4>Articoli</h4>
							<?php 
							$cats = get_categories('exclude=');
							foreach ($cats as $cat) {
								echo '<h4>' . $cat->cat_name . '</h4>';
								echo '<ul class="py-3">';
								query_posts('posts_per_page=-1&cat=' . $cat->cat_ID);
								while(have_posts()) {
									the_post();
									$category = get_the_category();
									if ($category[0]->cat_ID == $cat->cat_ID) {
										echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>'; 
									}
								}
								echo '</ul>';
							}	
							?>
						</div>
						
						<div class="mb-5">
							<h4>Autori</h4>
							<ul class="py-3">
							<?php wp_list_authors( array( 'exclude_admin' => false ) ); ?>
							</ul>
						</div>
						*/ ?>
						
					</div>
					
					<div class="col-lg-4 col-md-6 col-sm-12">

						<div class="mb-5">
							<h4 class="pb-2">Pagine interne</h4>
							<?php
							foreach( get_post_types( array( 'public' => true, '_builtin' => false ) ) as $post_type ) {
								$hidden_post_types = array(
									'post',
									'page',
									'revision',
									'attachment',
									'nav_menu_item',
									'domanda_frequente',
									'documento_privato',
									'rating', // valutazioni
									'richiesta_assistenza', // tickets
									'appuntamento',
									'messaggio',
									'pagamento',
									'pratica',
								);
								if ( in_array( $post_type, $hidden_post_types ) ) {
									continue;
								}
								$pt = get_post_type_object( $post_type );
								echo '<h4 class="h5">' . $pt->labels->name . '</h4>';
								echo '<ul class="pb-3">';
								query_posts('post_type=' . $post_type . '&posts_per_page=-1');
								while( have_posts() ) {
									the_post();
									echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
								}
								echo '</ul>';
							}
							?>
						</div>
						
					</div>
					
					<div class="col-lg-4 col-md-6 col-sm-12">
						
						<div class="mb-5">
							<h4>Tutti gli argomenti</h4>
							<ul class="py-3">
							<?php wp_list_categories( array( 'taxonomy' => 'argomenti', 'exclude' => '', 'title_li' => '', 'orderby' => 'name' ) ); ?>
							</ul>
						</div>
						
					</div>
					
				</div><!-- /row -->

			</article>
		</div>
		
		<?php get_template_part("template-parts/common/valuta-servizio"); ?>
		<?php get_template_part("template-parts/common/assistenza-contatti"); ?>

	</main>

<?php
get_footer();



