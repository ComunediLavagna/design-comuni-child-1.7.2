<?php
global $the_query, $load_posts, $load_card_type;

global $filtra_doc;

$args = array(
	's' => null,
	   'posts_per_page' => -1, // tutti
	'post_type'      => 'documento_pubblico',
	'tax_query' => array(
		array(
			'taxonomy' => 'tipi_documento',
			'field' => 'slug',
			'terms' => $filtra_doc, // considera anche le sotto-categorie
		),
	),
	'orderby'        => 'post_id',
	'order'          => 'DESC'
);
$the_query = new WP_Query( $args );

$posts = $the_query->posts;

?>

        <div class="">
        <div class="container pt-5 pb-5">
	<h2>Atti e Documenti</h2>
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