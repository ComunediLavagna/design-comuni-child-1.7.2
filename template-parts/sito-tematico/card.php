<?php 
	global $sito_tematico_id, $into_argomento, $count;
	
	$post = get_post($sito_tematico_id);
	$st_descrizione = dci_get_meta('descrizione_breve');
	$st_link = dci_get_meta('link');
	$st_colore = dci_get_meta('colore');
	$st_img = dci_get_meta('immagine');
	
	if ($into_argomento) {
		if ($count % 3 == 1) $bg_color = 'blue';
		if ($count % 3 == 2) $bg_color = 'warning';
		if ($count % 3 == 0) $bg_color = 'dark';
	?>
	<a href="<?php echo $st_link ?>" class="card card-teaser card-bg-<?php echo $bg_color; ?> rounded mt-0 p-3"
		aria-label="scopri di più su <?php echo $st_link; ?> - link esterno - apertura nuova scheda" target="_blank">
	    <?php if($st_img) { ?>
		<div class="avatar size-lg me-3">
		    <?php sts_get_img_by_id( attachment_url_to_postid( $st_img ), '', '', '', array(600,400), true ); /* dci_get_img($st_img, ''); */ ?>
		</div>
	    <?php } ?>
	    <div class="card-body">
		<h3 class="h4 text-white sito-tematico">
		    <?php echo the_title(); ?>
		</h3>
		<p class="card-text text-sans-serif text-white">
		    <?php echo $st_descrizione; ?>
		</p>
	    </div>
	</a>	
	<?php
	} else {
		
	?>
	<div class="col-md-6 col-xl-4 mb-4">
	<?php
		if ($st_img) {
	?>
	  <div class="card-wrapper border border-light rounded shadow-sm">
	    <div class="card no-after rounded">

	      <div class="img-responsive-wrapper">
		<div class="img-responsive img-responsive-panoramic">
		  <a class="text-decoration-none" href="<?php echo $st_link; ?>">
		  <figure class="img-wrapper" role="none">
		    <?php sts_get_img_by_id( attachment_url_to_postid( $st_img ), '', '', '', array(600,400), true ); /* dci_get_img($st_img, ''); */ ?>
		  </figure>
		  <span class="visually-hidden">Visita il sito <?php echo the_title(); ?></span>
		  </a>
		</div>
	      </div>

	      <div class="card-body p-4">
		<a class="text-decoration-none" href="<?php echo $st_link; ?>">
		  <h3 class="card-title"><?php echo the_title(); ?></h3>
		</a>
		<p class="card-text text-secondary">
		  <?php echo $st_descrizione; ?>
		</p>
	      </div>

	    </div>
	  </div>
	<?php } else { ?>
	  <div class="card-wrapper border border-light rounded shadow-sm cmp-list-card-img cmp-list-card-img-hr">
	    <div class="card no-after rounded">
	      <div class="row g-2 g-md-0 flex-md-column">
		<div class="col-12 order-1 order-md-2">
		  <div class="card-body p-4 card-img-none rounded-top">
		    <a class="text-decoration-none" href="<?php echo $st_link; ?>">
		      <h3 class="card-title"><?php echo the_title(); ?></h3>
		    </a>
		    <p class="card-text text-secondary">
		      <?php echo $st_descrizione; ?>
		    </p>
		  </div>
		</div>
	      </div>
	    </div>
	  </div>
	<?php } ?>
	</div>
<?php } ?>