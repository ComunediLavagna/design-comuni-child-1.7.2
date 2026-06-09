<?php
/**
 * Evento template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */

global $gallery, $video, $trascrizione, $luogo, $pc_id, $uo_id, $inline;

get_header();
?>

<main>
  <?php
  while ( have_posts() ) :
    the_post();
    $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

    $prefix= '_dci_luogo_';
    $nome_alternativo = dci_get_meta("nome_alternativo", $prefix, $post->ID); // [header]
    $descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID); // [header]
    $descrizione = dci_get_wysiwyg_field("descrizione_estesa", $prefix, $post->ID); // Cos'è
    
    $gallery = dci_get_meta("gallery", $prefix, $post->ID); // N.U.
    $video = dci_get_meta("video", $prefix, $post->ID); // N.U.
    $trascrizione = dci_get_meta("trascrizione", $prefix, $post->ID);

    $indirizzo = dci_get_meta("indirizzo", $prefix, $post->ID);
    $luoghi_collegati = dci_get_meta("luoghi_collegati", $prefix, $post->ID);
    $servizi = dci_get_wysiwyg_field("servizi", $prefix, $post->ID);
    $modalita_accesso = dci_get_wysiwyg_field("modalita_accesso", $prefix, $post->ID);
    $orario_pubblico = dci_get_wysiwyg_field("orario_pubblico", $prefix, $post->ID);
    $punti_contatto = dci_get_meta("punti_contatto", $prefix, $post->ID); // Contatti
    $uo_responsabili = dci_get_meta("struttura_responsabile", $prefix, $post->ID); // Unità Organizzative
    $uo_presenti = dci_get_meta("sede_di", $prefix, $post->ID); // Unità Organizzative
    
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
          <h2 class="visually-hidden">Luogo</h2>
          <?php if ($nome_alternativo) { ?>
          <h3 class="h4 py-2" data-audio><?php echo $nome_alternativo; ?></h3>
          <?php } ?>
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
        <aside class="col-lg-4" aria-label="Indice della pagina">
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
                                            <svg class="icon icon-sm icon-primary align-top" aria-hidden="true" focusable="false">
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
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#descrizione">
                                                    <span class="title-medium">Descrizione</span>
                                                    </a>
                                                    </li>
						    
                                               <?php if ( $servizi ) {  ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#servizi">
                                                    <span class="title-medium">Servizi presenti</span>
                                                    </a>
                                                    </li>
                                                <?php } ?>
						    
                                               <?php if ( $modalita_accesso ) {  ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#accesso">
                                                    <span class="title-medium">Modalità di accesso</span>
                                                    </a>
                                                    </li>
                                                <?php } ?>
						    
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#luogo">
                                                    <span class="title-medium">Indirizzo</span>
                                                    </a>
                                                    </li>
						    
                                               <?php if ( $orario_pubblico ) {  ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#orario">
                                                    <span class="title-medium">Orario per il pubblico</span>
                                                    </a>
                                                    </li>
                                                <?php } ?>
					
					<?php if( is_array($luoghi_collegati) && count($luoghi_collegati) ) { ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#luoghi_collegati">
                                                    <span class="title-medium">Luoghi collegati</span>
                                                    </a>
                                                    </li>
					<?php } ?>
					
                                                <?php if( is_array($punti_contatto) && count($punti_contatto) ) { ?>
                                                <li class="nav-item">
                                                <a class="nav-link" href="#contatti">
                                                <span class="title-medium">Contatti</span>
                                                </a>
                                                </li>
                                                <?php } ?>
						    
                                                 <?php if( is_array($uo_responsabili) && count($uo_responsabili) ) { ?>
                                                <li class="nav-item">
                                                <a class="nav-link" href="#struttura_responsabile">
                                                <span class="title-medium">Struttura responsabile</span>
                                                </a>
                                                </li>
                                                <?php } ?>
						    
                                                <?php if( is_array($uo_presenti) && count($uo_presenti) ) { ?>
                                                <li class="nav-item">
                                                <a class="nav-link" href="#sede_di">
                                                <span class="title-medium">Sede di</span>
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

        <section class="col-lg-8 it-page-sections-container border-light" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
          <article id="descrizione" class="it-page-section mb-5" data-audio>
              <h3 class="mb-3">Descrizione</h3>
              <div class="richtext-wrapper font-serif">
                  <?php echo $descrizione; ?>
              </div>

              <?php if (is_array($gallery) && count($gallery)) {
                  get_template_part("template-parts/single/gallery");
              } ?>
              <?php if ($video) {
                  get_template_part("template-parts/single/video");
              } ?>

          </article>

          <?php if( is_array($luoghi_collegati) && count($luoghi_collegati) ) { ?>
	 <article id="luoghi_collegati" class="it-page-section anchor-offset mb-5">
            <h3 class="mb-3">Luoghi collegati</h3>
		<div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
		    <?php foreach ($luoghi_collegati as $luogo_id) {
			$luogo = get_post($luogo_id);
			$no_icon = true; $no_map = true;
			get_template_part("template-parts/single/luogo");
		    } ?>
		</div>
	  </article>
          <?php } ?>
	  
          <?php if($servizi) {?>
          <article id="servizi" class="it-page-section mb-5">
            <h3 class="mb-3">Servizi presenti</h3>
            <?php echo $servizi; ?>
          </article>
          <?php  } ?>

          <?php if($modalita_accesso) {?>
          <article id="accesso" class="it-page-section mb-5">
            <h3 class="mb-3">Modalità di accesso</h3>
            <?php echo $modalita_accesso; ?>
          </article>
          <?php  } ?>

          <article id="luogo" class="it-page-section mb-5">
            <h3 class="mb-3">Indirizzo</h3>
	     <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
            <?php
                $luogo = get_post($post->ID);
		get_template_part("template-parts/single/luogo");
            ?>
	    </div>
          </article>

          <?php if($orario_pubblico) { ?>
          <article id="orario" class="it-page-section mb-5">
            <h3 class="mb-3">Orario per il pubblico</h3>
            <?php echo $orario_pubblico; ?>
          </article>
          <?php  } ?>

          <?php if( is_array($punti_contatto) && count($punti_contatto) ) { ?>
          <article id="contatti" class="it-page-section mb-5">
            <h3 class="mb-3">Contatti</h3>
	    <div class="row">
            <?php foreach ($punti_contatto as $pc_id) { ?>
		<div class="col-lg-<?php print( count($punti_contatto)>1 ? '6' : '12' ); ?>">
			<?php get_template_part('template-parts/single/punto-contatto'); ?>
		</div>
            <?php } ?>
	    </div>
	</article>
          <?php } ?>

          <?php if( is_array($uo_responsabili) && count($uo_responsabili) ) { ?>
          <article id="struttura_responsabile" class="it-page-section mb-5">
            <h3 class="mb-3">Struttura responsabile</h3>
	    <div class="row">
            <?php foreach ($uo_responsabili as $uo_id) { ?>
		<div class="col-lg-<?php print( count($uo_responsabili)>1 ? '6' : '12' ); ?>">
		<?php get_template_part('template-parts/unita-organizzativa/card'); ?>
		</div>
	  <?php } ?>
	  </div>
	</article>  
            <?php } ?>

          <?php if( is_array($uo_presenti) && count($uo_presenti) ) { ?>
          <article id="sede_di" class="it-page-section mb-5">
            <h3 class="mb-3">Sede di</h3>
	    <div class="row">
            <?php foreach ($uo_presenti as $uo_id) { ?>
		<div class="col-lg-<?php print( count($uo_presenti)>1 ? '6' : '12' ); ?>">
		<?php get_template_part('template-parts/unita-organizzativa/card'); ?>
		</div>
	  <?php } ?>
	  </div>
	</article>  
          <?php } ?>
	
          <?php if ($more_info) { ?>
          <article id="ulteriori-informazioni" class="it-page-section mb-5">
            <h3 class="mb-3">Ulteriori informazioni</h3>
              <div class="mt-5">
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
