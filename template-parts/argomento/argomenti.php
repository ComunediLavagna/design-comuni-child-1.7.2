<?php
    $argomenti = dci_get_terms_options('argomenti');
    $arr_ids = array_keys((array)$argomenti);
?>

<div class="container py-5" id="argomento">
    <h2 class="title-xxlarge mb-4">Esplora per argomento:</h2>
    <div class="row g-4">       
        <?php foreach ($arr_ids as $arg_id) { 
            $argomento = get_term_by('term_id', $arg_id, 'argomenti');    
	    
	        $posts_novita = dci_get_grouped_posts_by_term( 'novita-evento' , 'argomenti', $argomento->slug, 3 );
	        $posts_servizi = dci_get_grouped_posts_by_term( 'servizi' , 'argomenti', $argomento->slug, 3 );
	        $posts_amministrazione = dci_get_grouped_posts_by_term( 'amministrazione' , 'argomenti', $argomento->slug, 3 );
	        $posts_documenti = dci_get_grouped_posts_by_term( 'documenti-e-dati' , 'argomenti', $argomento->slug, 3 );
		
		if ( ( count($posts_novita) + count($posts_servizi) + count($posts_amministrazione) + count($posts_documenti) ) > 0 ) {
        ?>
        <div class="col-md-6 col-xl-4">
            <div class="cmp-card-simple card-wrapper pb-0 rounded border border-light">
              <div class="card shadow-sm rounded">
                <div class="card-body">
                    <a class="text-decoration-none" href="<?php echo get_term_link($argomento->term_id); ?>" data-element="topic-element"><h3 class="card-title t-primary title-xlarge"><?php echo $argomento->name; ?></h3></a>
                    <p class="titillium text-paragraph mb-0 description">
                        <?php echo $argomento->description; ?>
                    </p>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>
