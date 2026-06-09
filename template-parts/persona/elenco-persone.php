<?php
global $the_query, $load_posts, $load_card_type;

/*
$max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 3;
$load_posts = 3;
*/
$query = /* isset($_GET['search']) ? dci_removeslashes($_GET['search']) : */ null;

$args = array(
	's' => $query,
	   'posts_per_page' => -1, //$max_posts,
	'post_type'      => 'persona_pubblica',
	'orderby'        => 'post_title',
	'order'          => 'ASC'
);
$the_query = new WP_Query( $args );

$persone = $the_query->posts;
	#print('<pre>'.print_r($persone,true).'</pre>');

/*** filtro su incarichi ***/

global $filtra_incarico; # $tipo_incarico;

$selezione_incarichi = array();
$prefix= '_dci_incarico_';
$args = array(
	'post_type' => 'incarico',
	'tax_query' => array(
		array(
			'taxonomy' => 'tipi_incarico',
			'field' => 'slug',
			'terms' => $filtra_incarico, // considera anche le sotto-categorie
		),
	),
);
$the_query = new WP_Query( $args );
$selezione_incarichi = $the_query->posts;

/*** filtro su unita organizzative ***/

global $filtra_uo; # $tipo_uo;

$selezione_uo = array();
$prefix= '_dci_unita_organizzativa_';
$args = array(
	'post_type' => 'unita_organizzativa',
	'tax_query' => array(
		array(
			'taxonomy' => 'tipi_unita_organizzativa',
			'field' => 'slug',
			'terms' => $filtra_uo, // considera anche le sotto-categorie
		),
	),
);
$the_query = new WP_Query( $args );
$selezione_uo = $the_query->posts;

/**********************/

$selezione_persone = array();
$prefix= '_dci_persona_pubblica_';
foreach ( $persone as $persona ) {
	$incarichi = dci_get_meta("incarichi", $prefix, $persona->ID);
	if ( is_array( $incarichi )) {
		foreach ( $incarichi as $incarico ) {
			foreach ( $selezione_incarichi as $selezione_incarico ) {
				if ( $incarico == $selezione_incarico->ID ) $selezione_persone[$persona->ID] = $persona;
			}
		}
	}
	
	$uo = dci_get_meta("organizzazioni", $prefix, $persona->ID);
	if ( is_array( $uo )) {
		foreach ( $uo as $uo_id ) {
			foreach ( $selezione_uo as $sel_uo ) {
				if ( $uo_id == $sel_uo->ID ) $selezione_persone[$persona->ID] = $persona;
			}
		}
	}
	
	$uo_id = dci_get_meta("responsabile_di", $prefix, $persona->ID);
	#foreach ( $uo as $uo_id ) {
		foreach ( $selezione_uo as $sel_uo ) {
			if ( $uo_id == $sel_uo->ID ) $selezione_persone[$persona->ID] = $persona;
		}
	#}
}
$posts = array_values($selezione_persone);

#$posts = array_slice($posts, 0, $max_posts);
/*
// solo per conteggio:
    $args = array(
        's'                 => $query,
        'posts_per_page'    => $max_posts,
        'post_type'         => 'persona_pubblica'
    );

    $the_query = new WP_Query( $args );
     #print('<pre>'.print_r($the_query,true).'</pre>');
   */
?>

        <div class="container pb-5">
            <div class="row g-4 mb-5">
                <?php
                foreach ( $posts as $post ) {
                    global $persona_id; $persona_id = $post->ID;
                    get_template_part('template-parts/persona-pubblica/cards-list');
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
	
<?php wp_reset_query(); ?>