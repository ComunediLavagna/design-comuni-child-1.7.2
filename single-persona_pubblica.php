<?php
/**
 * Evento template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */
global $prefix, $gallery, $video, $trascrizione, $persona_id, $inline;

get_header();
?>

<main>
  <?php
  while ( have_posts() ) :
    the_post();
    $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

    $prefix = '_dci_persona_pubblica_';
    $nome = dci_get_meta("nome", $prefix, $post->ID); // [N.U.]
    $cognome = dci_get_meta("cognome", $prefix, $post->ID); // [N.U.]
    $descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID); // subtitle
    
    $punti_contatto = dci_get_meta("punti_contatto", $prefix, $post->ID);
    
    $incarichi = dci_get_meta("incarichi", $prefix, $post->ID);
    $organizzazioni = dci_get_meta("organizzazioni", $prefix, $post->ID); // Unità Organizzative
    $responsabile = dci_get_meta("responsabile_di", $prefix, $post->ID); // Unità Organizzativa
 
    $competenze = dci_get_wysiwyg_field("competenze", $prefix, $post->ID);
    $deleghe = dci_get_wysiwyg_field("deleghe", $prefix, $post->ID);
    $biografia = dci_get_wysiwyg_field("biografia", $prefix, $post->ID);
    $situazione_patrimoniale = dci_get_wysiwyg_field("situazione_patrimoniale", $prefix, $post->ID);

    $gallery = dci_get_meta("gallery", $prefix, $post->ID); // N.U.
   /*
    $video = dci_get_meta("video", $prefix, $post->ID); // N.U.
    $trascrizione = dci_get_meta("trascrizione", $prefix, $post->ID);
    */
	$curriculum_id = dci_get_meta("curriculum_vitae_id", $prefix, $post->ID);
	$dichiarazione_redditi = dci_get_meta("dichiarazione_redditi", $prefix, $post->ID);
	$spese_elettorali = dci_get_meta("spese_elettorali", $prefix, $post->ID);
	$variazione_situazione_patrimoniale = dci_get_meta("variazione_situazione_patrimoniale", $prefix, $post->ID);
    
    
    
    $more_info = dci_get_wysiwyg_field("ulteriori_informazioni", $prefix, $post->ID); // Ulteriori informazioni
    ?>
   <div class="container px-4 my-4" id="main-container">
      <div class="row">
        <div class="col px-lg-4">
            <?php get_template_part("template-parts/common/breadcrumb"); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 px-lg-4 py-lg-2">
          <h1 data-audio><?php the_title(); ?></h1>
           <h2 class="visually-hidden">Persona pubblica</h2>
         <p class="h5" data-audio>
            <?php echo $descrizione_breve; ?>
          </p>
        </div>
        <div class="col-lg-3 offset-lg-1">
          <?php
              $inline = true;
              get_template_part('template-parts/single/actions');
          ?>
        </div>
      </div>
    </div>

    <?php get_template_part('template-parts/single/image-large'); ?>
  
    <div class="container">
      <div class="row border-top row-column-border row-column-menu-left border-light">
        <aside class="col-lg-4">
            <div class="cmp-navscroll sticky-top" aria-labelledby="accordion-title-one">
                <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="Indice della pagina" data-bs-navscroll>
                    <div class="navbar-custom" id="navbarNavProgress">
                        <div class="menu-wrapper">
                            <div class="link-list-wrapper">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <span class="accordion-header" id="accordion-title-one">
                                        <button
                                            class="accordion-button pb-10 px-3 text-uppercase"
                                            type="button"
                                            aria-controls="collapse-one"
                                            aria-expanded="true"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-one"
                                        >Indice della pagina
                                            <svg class="icon icon-sm icon-primary align-top">
                                                <use xlink:href="#it-expand"></use>
                                            </svg>
                                        </button>
                                        </span>
                                        <div class="progress">
                                            <div class="progress-bar it-navscroll-progressbar" role="progressbar" aria-label="Indice della pagina" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div id="collapse-one" class="accordion-collapse collapse show" role="region" aria-labelledby="accordion-title-one">
                                            <div class="accordion-body">
                                                <ul class="link-list" data-element="page-index">
					<?php if (is_array($incarichi) && count($incarichi) ) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#incarico">
								<span class="title-medium">Incarico</span>
							</a>
						</li>
						<!--li class="nav-item">
							<a class="nav-link" href="#tipo_incarico">
								<span class="title-medium">Tipo di incarico</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#compensi_incarico">
								<span class="title-medium">Compensi</span>
							</a>
						</li-->
					<?php } ?>
					<?php if (is_array($organizzazioni) && count($organizzazioni) ) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#organizzazione">
								<span class="title-medium">Organizzazione</span>
							</a>
						</li>
                                                <?php } ?>
 					<?php if ($responsabile) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#responsabile">
								<span class="title-medium">Responsabile di</span>
							</a>
						</li>
                                                <?php } ?>
 					<?php if ($competenze) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#competenze">
								<span class="title-medium">Competenze</span>
							</a>
						</li>
                                                <?php } ?>
 					<?php if ($deleghe) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#deleghe">
								<span class="title-medium">Deleghe</span>
							</a>
						</li>
                                                <?php } ?>
 					<?php if ($biografia) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#biografia">
								<span class="title-medium">Biografia</span>
							</a>
						</li>
                                                <?php } ?>
						
					<?php if( $curriculum_id ) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#curriculum">
								<span class="title-medium">Curriculum vitae</span>
							</a>
						</li>
					<?php } ?>
						
 					<?php if ($situazione_patrimoniale) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#situazione_patrimoniale">
								<span class="title-medium">Situazione patrimoniale</span>
							</a>
						</li>
                                                <?php } ?>
						
					<?php if (is_array($dichiarazione_redditi) && count($dichiarazione_redditi) ) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#dichiarazione_redditi">
								<span class="title-medium">Dichiarazione dei redditi</span>
							</a>
						</li>
                                                <?php } ?>
						
					<?php if (is_array($spese_elettorali) && count($spese_elettorali) ) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#spese_elettorali">
								<span class="title-medium">Spese elettorali</span>
							</a>
						</li>
                                                <?php } ?>
						
					<?php if (is_array($variazione_situazione_patrimoniale) && count($variazione_situazione_patrimoniale) ) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#variazione_situazione_patrimoniale">
								<span class="title-medium">Variazione situazione patrimoniale</span>
							</a>
						</li>
                                                <?php } ?>
						
 					<?php if (is_array($punti_contatto) && count($punti_contatto) ) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#contatti">
								<span class="title-medium">Contatti</span>
							</a>
						</li>
                                                <?php } ?>
						
                                             <?php if ( $more_info ) {  ?>
						<li class="nav-item">
							<a class="nav-link" href="#ulteriori-informazioni">
								<span class="title-medium">Ulteriori informazioni</span>
							</a>
						</li>
                                                <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <section class="col-lg-8 it-page-sections-container border-light">
	<?php if (is_array($incarichi) && count($incarichi) ) { ?>
		<?php foreach ($incarichi as $incarico_id) {
			$incarico = get_post($incarico_id); 
			$tipo_incarico = wp_get_post_terms( $incarico_id, array( 'tipi_incarico' ) ); 
			$compensi = dci_get_wysiwyg_field("compensi", '_dci_incarico_', $incarico_id);
			$data_insediamento = dci_get_meta("data_insediamento", '_dci_incarico_', $incarico_id);
		?>
		<article id="incarico_" class="it-page-section mb-5">
			<h3>Incarico</h3>
			<div class="rounded shadow mt-3 p-3 pb-4">
				<p class="h4 t-primary pb-3">
				<a class="text-decoration-none" href="<?php echo get_permalink($incarico_id); ?>">
				<?php print(get_the_title($incarico_id)); ?>
				</a>
				</p>
			<?php if (is_array($tipo_incarico) && count($tipo_incarico) ) { ?>
				<h4 class="h5 fw-bold">Tipo di incarico</h4>
				<p><?php foreach($tipo_incarico as $tipo) { print($tipo->name .'<br>'); } ?></p>
			<?php } ?>
			<?php if( $compensi ) { ?>
				<h4 class="h5 fw-bold">Compensi</h4>
				<?php print( $compensi ); ?>
			<?php } ?>
			<?php if( $data_insediamento ) { ?>
				<h4 class="h5 fw-bold">Data di insediamento</h4>
				<?php print( wp_date( get_option( 'date_format' ), $data_insediamento ) ); ?>
			</div>
			<?php } ?>
		</article>
		<?php } ?>
	<?php } ?>
	
          <?php if ( is_array($organizzazioni) && count($organizzazioni) ) { ?>
          <article id="organizzazione" class="it-page-section mb-5">
            <h3 class="mb-3">Organizzazione</h3>
	    <div class="row">
            <?php foreach ($organizzazioni as $uo_id) { ?>
		<div class="col-lg-<?php print( count($organizzazioni)>1 ? '6' : '12' ); ?> mb-3">
		<?php get_template_part('template-parts/unita-organizzativa/card'); ?>
		</div>
	  <?php } ?>
	  </div>
	</article>  
            <?php } ?>
	
          <?php if( $responsabile ) { ?>
          <article id="responsabile" class="it-page-section mb-5">
            <h3 class="mb-3">Responsabile di</h3>
	    <div class="row">
		<div class="col-lg-12 mb-3">
		<?php $uo_id = intval($responsabile); ?>
		<?php get_template_part('template-parts/unita-organizzativa/card'); ?>
		</div>
	  </div>
	</article>  
            <?php } ?>
	
          <?php if ($competenze) { ?>
          <article id="competenze" class="it-page-section mb-5">
            <h3 class="mb-3">Competenze</h3>
              <div class="my-3">
                      <?php echo $competenze; ?>
              </div>
          </article>
          <?php } ?>
	  
          <?php if ($deleghe) { ?>
          <article id="deleghe" class="it-page-section mb-5">
            <h3 class="mb-3">Deleghe</h3>
              <div class="my-3">
                      <?php echo $deleghe; ?>
              </div>
          </article>
          <?php } ?>
	  
          <?php if ($biografia) { ?>
          <article id="biografia" class="it-page-section mb-5">
            <h3 class="mb-3">Biografia</h3>
              <div class="my-3">
                      <?php echo $biografia; ?>
              </div>
              <?php if (is_array($gallery) && count($gallery)) {
                global $notitle; $notitle = true; 
		  get_template_part("template-parts/single/gallery");
              } ?>
          </article>
          <?php } ?>
	  
	  
	    <?php if( $curriculum_id ) { ?>
	    <article id="curriculum" class="it-page-section anchor-offset mb-5">
		<h3>Curriculum vitae</h3>
		<div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
		<?php
			$documento = get_post($curriculum_id);
			get_template_part('template-parts/documento/card');
		?>
		</div>
	    </article>
	    <?php } ?>
	  
	  
          <?php if ($situazione_patrimoniale) { ?>
          <article id="situazione_patrimoniale" class="it-page-section mb-5">
            <h3 class="mb-3">Situazione patrimoniale</h3>
              <div class="my-3">
                      <?php echo $situazione_patrimoniale; ?>
              </div>
          </article>
          <?php } ?>
	  
          <?php if ( is_array($dichiarazione_redditi) && count($dichiarazione_redditi) ) { ?>
          <article id="dichiarazione_redditi" class="it-page-section mb-5">
            <h3 class="mb-3">Dichiarazione dei redditi</h3>
	    <div class="row">
            <?php foreach ($dichiarazione_redditi as $documento_id=>$documento_url) { ?>
		<div class="col-lg-<?php print( count($dichiarazione_redditi)>1 ? '6' : '12' ); ?>">
		<?php
			$documento = get_post($documento_id);
			get_template_part('template-parts/documento/card');
		?>
		</div>
	  <?php } ?>
	  </div>
	</article>  
            <?php } ?>
	  
          <?php if ( is_array($spese_elettorali) && count($spese_elettorali) ) { ?>
          <article id="spese_elettorali" class="it-page-section mb-5">
            <h3 class="mb-3">Spese elettorali</h3>
            <p class="mb-3">Le spese sostenute e le obbligazioni assunte per la propaganda elettorale.</p>
	    <div class="row">
            <?php foreach ($spese_elettorali as $documento_id=>$documento_url) { ?>
		<div class="col-lg-<?php print( count($spese_elettorali)>1 ? '6' : '12' ); ?>">
		<?php
			$documento = get_post($documento_id);
			get_template_part('template-parts/documento/card');
		?>
		</div>
	  <?php } ?>
	  </div>
	</article>  
            <?php } ?>
	  
          <?php if ( is_array($variazione_situazione_patrimoniale) && count($variazione_situazione_patrimoniale) ) { ?>
          <article id="variazione_situazione_patrimoniale" class="it-page-section mb-5">
            <h3 class="mb-3">Variazioni situazione patrimoniale</h3>
	    <div class="row">
            <?php foreach ($variazione_situazione_patrimoniale as $documento_id=>$documento_url) { ?>
		<div class="col-lg-<?php print( count($variazione_situazione_patrimoniale)>1 ? '6' : '12' ); ?>">
		<?php
			$documento = get_post($documento_id);
			get_template_part('template-parts/documento/card');
		?>
		</div>
	  <?php } ?>
	  </div>
	</article>  
            <?php } ?>
	  
          <?php if ( is_array($punti_contatto) && count($punti_contatto) ) { ?>
          <article id="contatti" class="it-page-section mb-5">
            <h3 class="mb-3">Contatti</h3>
	    <div class="row">
            <?php foreach ($punti_contatto as $pc_id) { ?>
		<div class="col-lg-<?php print( count($punti_contatto)>1 ? '6' : '12' ); ?> mb-3">
		<?php get_template_part('template-parts/single/punto-contatto'); ?>
		</div>
	  <?php } ?>
	  </div>
	</article>  
            <?php } ?>
	
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
          <?php if ($more_info) { ?>
          <article id="ulteriori-informazioni" class="it-page-section mb-5">
            <h3 class="mb-3">Ulteriori informazioni</h3>
              <div class="my-3">
                      <?php echo $more_info; ?>
              </div>
          </article>
          <?php } ?>
	  
          <?php get_template_part('template-parts/single/page_bottom'); ?>
          </section>
      </div>
    </div>
    
<?php get_template_part("template-parts/common/valuta-servizio"); ?>
<?php get_template_part("template-parts/common/assistenza-contatti"); ?>

  <?php
  endwhile; // End of the loop.
  ?>
</main>

<?php
get_footer();
