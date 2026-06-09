<?php 
$tipologie_evento_names = dci_tipi_evento_array();
?>

<div class="container py-5">
    <h2 class="title-xxlarge mb-4">Esplora per tipologia</h2>
    <div class="row g-4">
        <?php foreach ($tipologie_evento_names as $tipologia_evento_name => $tipologie_evento_names_inner) {
		$terms = array($tipologia_evento_name);
		foreach ($tipologie_evento_names_inner as $tipologia_evento_name_inner => $tipologie_evento_names_inners) {
		    $args = array('post_type' => 'evento',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
			    array(
				'taxonomy' => 'tipi_evento',
				'field' => 'name',
				'terms' => $tipologia_evento_name_inner,
			    ),
			),
		    );
		    $eventi = get_posts($args);
		     if ( count($eventi) > 0 ) {
			$tipologia = get_term_by('name', $tipologia_evento_name_inner, 'tipi_evento');
			$terms[] = $tipologia->name;
			$url = get_term_link( $tipologia->term_id, 'tipi_evento');
		?>
		<div class="col-md-6 col-xl-4">
		    <div class="cmp-card-simple card-wrapper pb-0 rounded border border-light">
			<div class="card shadow-sm rounded">
			    <div class="card-body">
				<a class="text-decoration-none" href="<?php echo $url; ?>" data-element="event-type-link">
				    <h3 class="card-title t-primary"><?php echo $tipologia->name; ?></h3>
				</a>
				<p class="text-secondary mb-0">
				    <?php echo $tipologia->description; ?>
				</p>
			    </div>
			</div>
		    </div>
		</div>
		<?php 
		    }
		}
		?>
	
	<?php
            $args = array('post_type' => 'evento',
		'post_status'    => 'publish',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tipi_evento',
                        'field' => 'name',
                      #  'terms' => $tipologia_evento_name_inner,
                        'terms' => $terms,
                    ),
                ),
            );
            
	    $eventi = get_posts($args);
	     if ( count($eventi) > 0 ) {
		$tipologia = get_term_by('name', $tipologia_evento_name, 'tipi_evento');
		$url = get_term_link( $tipologia->term_id, 'tipi_evento');
	?>
        <div class="col-md-6 col-xl-4">
            <div class="cmp-card-simple card-wrapper pb-0 rounded border border-light">
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <a class="text-decoration-none" href="<?php echo $url; ?>" data-element="event-type-link">
                            <h3 class="card-title t-primary">Tutti i tipi di <?php echo strtolower($tipologia->name); ?></h3>
                        </a>
                        <p class="text-secondary mb-0">
                            <?php echo $tipologia->description; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>	
        </div><div class="row mt-4 g-4">	
        <?php 
	    } 
	} 
	?>
    </div>
</div>