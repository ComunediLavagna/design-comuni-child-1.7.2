<?php
global $the_query, $load_posts, $load_card_type;
	
	$load_card_type = 'evento';
	
    $max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 3;
    $load_posts = 3;
    $query = isset($_GET['search']) ? dci_removeslashes($_GET['search']) : null;
    $args = array(
        's'         => $query,
        'post_type' => 'evento',
        'post_status'    => 'publish',
        //'orderby'        => 'ID',
	'orderby' => 'meta_value_num',
	'meta_key' => '_dci_evento_data_orario_inizio',
        'order'          => 'DESC'
    );

    $the_query = new WP_Query( $args );
#if (@$_GET['test']>0) print('<pre>'.print_r($the_query,true).'</pre>');
    
    $posts = $the_query->posts;
#if (@$_GET['test']>0) print('<pre>'.print_r($posts,true).'</pre>');
 /*   
	if ($query=='') { // normalmente mostro solo quelli in corso e futuri
    
	    $posts = array_filter($posts, function($a) {
		return dci_get_data_pubblicazione_ts("data_orario_fine", '_dci_evento_', $a->ID) >= time(); // solo eventi non finiti
	    });
	}
*/
/*
    usort($posts, function($a, $b) {
        return dci_get_data_pubblicazione_ts("data_orario_inizio", '_dci_evento_', $b->ID) - dci_get_data_pubblicazione_ts("data_orario_inizio", '_dci_evento_', $a->ID);
    });
*/    
    $posts = array_slice($posts, 0, $max_posts);

// solo per conteggio:
    $args = array(
        's'                 => $query,
        'posts_per_page'    => $max_posts,
        'post_type'         => 'evento',
        'post_status'    => 'publish',
    );

    $the_query = new WP_Query( $args );
     #print('<pre>'.print_r($the_query,true).'</pre>');
   
?>


<div class="bg-grey-card py-5">
    <form role="search" id="search-form" method="get" class="search-form">
        <button type="submit" class="d-none"></button>
        <div class="container">
            <h2 class="title-xxlarge mb-4">
                Esplora tutti gli eventi
            </h2>
            <div>
                <div class="cmp-input-search">
                    <div class="form-group autocomplete-wrapper mb-0">
                        <div class="input-group">
                            <label for="autocomplete-two" class="visually-hidden">Cerca</label>
                            <input type="search" class="autocomplete form-control" placeholder="Cerca per parola chiave"
                                id="autocomplete-two" name="search" value="<?php echo $query; ?>"
                                data-bs-autocomplete="[]" />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="button-3">
                                    Invio
                                </button>
                            </div>
                            <span class="autocomplete-icon" aria-hidden="true"><svg class="icon icon-sm icon-primary"
                                    role="img" aria-labelledby="autocomplete-label">
                                    <use href="#it-search"></use>
                                </svg>
                            </span>
                        </div>
                        <p id="autocomplete-label" class="u-grey-light text-paragraph-card mt-2 mb-30 mt-lg-3 mb-lg-40">
                            <?php echo $the_query->found_posts; ?> eventi trovati
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-4" id="load-more">
                <?php
                foreach ( $posts as $post ) {
                    //get_template_part('template-parts/evento/cards-list');
                    get_template_part('template-parts/evento/card-full');
                }
                wp_reset_postdata();
                ?>
            </div>
            <?php get_template_part("template-parts/search/more-results"); ?>
        </div>
    </form>
</div>
<?php wp_reset_query(); ?>