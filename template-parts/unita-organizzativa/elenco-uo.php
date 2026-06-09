<?php
global $the_query, $load_posts, $load_card_type;

global $filtra_uo;

$args = array(
	's' => null,
	   'posts_per_page' => -1, // tutti
	'post_type'      => 'unita_organizzativa',
	'tax_query' => array(
		array(
			'taxonomy' => 'tipi_unita_organizzativa',
			'field' => 'slug',
			'terms' => $filtra_uo, // considera anche le sotto-categorie
		),
	),
	'orderby'        => 'post_title',
	'order'          => 'ASC'
);
$the_query = new WP_Query( $args );

$posts = $the_query->posts;

?>

        <div class="bg-grey-card mt-5">
        <div class="container pb-5">
	  <h2 class="visually-hidden">Elenco delle unità organizzative</h2>
            <div class="row g-4 mb-5">
                <?php
                foreach ( $posts as $post ) {
		   $load_card_type = 'unita_organizzativa';
                    get_template_part('template-parts/unita-organizzativa/cards-list');
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
        </div>
	
<?php wp_reset_query(); ?>