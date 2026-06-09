<?php 
$tipologie_luogo_names = dci_luoghi_array(); // sono sollo quelli defiiti dal tema
?>

<div class="container py-5">
    <h2 class="title-large mb-4">Esplora per tipologia</h2>
    <div class="row g-4">
        <?php foreach ($tipologie_luogo_names as $tipologia_luogo_name => $tipologie_luogo_names_inner) {
        /*foreach ($tipologie_luogo_names_inner as $tipologia_luogo_name_inner) {
            $args = array('post_type' => 'luogo',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tipi_luogo',
                        'field' => 'name',
                        'terms' => $tipologia_luogo_name_inner,
                    ),
                ),
            );
            #$luoghi = get_posts($args);
            $tipologia = get_term_by('name', $tipologia_luogo_name_inner, 'tipi_luogo');
           $url = get_term_link( $tipologia->term_id, 'tipi_luogo');
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
        <?php }*/ ?>
	
	
	<?php
	$terms = array($tipologia_luogo_name);
	foreach ($tipologie_luogo_names_inner as $tipologia_luogo_name_inner) {
		$tipologia_inner = get_term_by('name', $tipologia_luogo_name_inner, 'tipi_luogo');
		$terms[] = $tipologia_inner->name;
	}
            $args = array('post_type' => 'luogo',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tipi_luogo',
                        'field' => 'name',
                       # 'terms' => $tipologia_luogo_name_inner,
                        'terms' => $terms,
                    ),
                ),
            );
	    $luoghi = get_posts($args);
	    if ( count($luoghi) > 0 ) {
            $tipologia = get_term_by('name', $tipologia_luogo_name, 'tipi_luogo');
           $url = get_term_link( $tipologia->term_id, 'tipi_luogo');
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
			<?php /*
			<em><?php print(implode(', ',$tipologie_luogo_names_inner)); ?></em>
			<br><?php print(count($luoghi)); ?> luoghi
			*/ ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>	
        <?php 
	    } 
	} 
	?>
    </div>
</div>