<?php
/**
 * Evento template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */

global $gallery, $video, $trascrizione, $luogo, $unita_organizzativa, $servizio, $persona_id, $uo_id, $inline, $no_icon, $no_map;

get_header();
?>

<main>
  <?php
  while ( have_posts() ) :
    the_post();
    $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

    $prefix= '_dci_unita_organizzativa_';
    $descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID); // [header]
    
	$competenze = dci_get_wysiwyg_field("competenze", $prefix, $post->ID);
	$tipologie = get_the_terms($post,'tipi_unita_organizzativa');
	$uo_genitori = dci_get_meta("unita_organizzativa_genitore", $prefix, $post->ID);
	$responsabile = dci_get_meta("responsabile", $prefix, $post->ID); // persone pubbliche
	$persone = dci_get_meta("persone_struttura", $prefix, $post->ID); // persone pubbliche
	$servizi = dci_get_meta("elenco_servizi_offerti", $prefix, $post->ID); // servizi
	
	$sede_id = dci_get_meta("sede_principale", $prefix, $post->ID); // INT
	$sedi = dci_get_meta("altre_sedi", $prefix, $post->ID); // luoghi
	$punti_contatto = dci_get_meta("contatti", $prefix, $post->ID); // contatti
	$documenti_collegati = dci_get_meta("allegati", $prefix, $post->ID);
    
    $altri_contatti = dci_get_wysiwyg_field("altri_contatti", $prefix, $post->ID); // Altre informazioni di contatto
    $more_info = dci_get_wysiwyg_field("ulteriori_informazioni", $prefix, $post->ID); // Ulteriori informazioni
    /*
    $gallery = dci_get_meta("gallery", $prefix, $post->ID); // N.U.
    $video = dci_get_meta("video", $prefix, $post->ID); // N.U.
    $trascrizione = dci_get_meta("trascrizione", $prefix, $post->ID);
    */
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
           <h2 class="visually-hidden">Unit&agrave; organizzativa</h2>
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
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#competenze">
                                                    <span class="title-medium">Competenze</span>
                                                    </a>
                                                    </li>
					<?php if (is_array($tipologie) && count($tipologie) ) { ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#tipologia">
                                                    <span class="title-medium">Tipologia di organizzazione</span>
                                                    </a>
                                                    </li>
					<?php } ?>
					<?php if( is_array($uo_genitori) && count($uo_genitori) ) { ?>
					    <li class="nav-item">
						<a class="nav-link" href="#uo_riferimento">
						<span class="title-medium">Unità organizzativa di riferimento</span>
						</a>
					    </li>
					<?php } ?>
					<?php if (is_array($responsabile) && count($responsabile) ) { ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#responsabile">
                                                    <span class="title-medium">Responsabile</span>
                                                    </a>
                                                    </li>
					<?php } ?>
					<?php if (is_array($persone) && count($persone) ) { ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#persone">
                                                    <span class="title-medium">Persone</span>
                                                    </a>
                                                    </li>
					<?php } ?>
					<?php if (is_array($servizi) && count($servizi) ) { ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#servizi">
                                                    <span class="title-medium">Servizi collegati</span>
                                                    </a>
                                                    </li>
					<?php } ?>
					<?php if ( $sede_id || (is_array($sedi) && count($sedi)) ) { ?>
                                                    <li class="nav-item">
                                                    <a class="nav-link" href="#sede">
                                                    <span class="title-medium">Sede</span>
                                                    </a>
                                                    </li>
					<?php } ?>
					<?php if ( ( is_array($punti_contatto) && count($punti_contatto) ) || $altri_contatti  ) { ?>
                                                <li class="nav-item">
                                                <a class="nav-link" href="#contatti">
                                                <span class="title-medium">Contatti</span>
                                                </a>
                                                </li>
                                                <?php } ?>
					<?php if( is_array($documenti_collegati) && count($documenti_collegati) ) { ?>
					    <li class="nav-item">
						<a class="nav-link" href="#documenti_collegati">
						<span class="title-medium">Documenti collegati</span>
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
          <article id="competenze" class="it-page-section mb-5">
              <h3>Competenze</h3>
              <div class="richtext-wrapper font-serif">
                  <?php echo $competenze; ?>
              </div>
          </article>
	<?php if (is_array($tipologie) && count($tipologie) ) { ?>
          <article id="tipologia" class="it-page-section mb-5">
              <h3>Tipologia di organizzazione</h3>
              <div class="richtext-wrapper font-serif">
		    <ul class="d-flex flex-wrap gap-1">
			<?php foreach ($tipologie as $tipologia) { ?>
			<li>
			    <a href="<?php echo get_term_link($tipologia->term_id); ?>">
				<span class=""><?php echo ucfirst($tipologia->name); ?></span>
			    </a>
			</li>
			<?php } ?>
		    </ul>
              </div>
          </article>
	<?php } ?>
	    <?php if( is_array($uo_genitori) && count($uo_genitori) ) { ?>
	    <article id="uo_riferimento" class="it-page-section anchor-offset mb-5">
		<h3>Unità organizzativa di riferimento</h3>
		<div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
		    <?php foreach ($uo_genitori as $uo_genitore) {
			$unita_organizzativa = get_post($uo_genitore);
			$uo_id = $unita_organizzativa->ID;
			$with_border = true;
			get_template_part("template-parts/unita-organizzativa/card");
		    } ?>
		</div>
	    </article>
	    <?php } ?>
	    <?php if( is_array($responsabile) && count($responsabile) ) { ?>
	    <article id="responsabile" class="it-page-section anchor-offset mb-5">
		<h3>Responsabile</h3>
		<div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
		    <?php foreach ($responsabile as $persona_id) {
			get_template_part("template-parts/single/persona-pubblica");
		    } ?>
		</div>
	    </article>
	    <?php } ?>
	    <?php if( is_array($persone) && count($persone) ) { ?>
	    <article id="persone" class="it-page-section anchor-offset mb-5">
		<h3>Persone</h3>
		<p>Tutte le persone che fanno parte di questa unità:</p>
		<div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
		    <?php foreach ($persone as $persona_id) {
			get_template_part("template-parts/single/persona-pubblica");
		    } ?>
		</div>
	    </article>
	    <?php } ?>
	    <?php if( is_array($servizi) && count($servizi) ) { ?>
	    <article id="servizi" class="it-page-section anchor-offset mb-5">
		<h3>Servizi collegati</h3>
		<div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
		    <?php foreach ($servizi as $servizio_id) {
			get_template_part("template-parts/single/servizio");
		    } ?>
		</div>
	    </article>
	    <?php } ?>
	    <?php if( $sede_id || ( is_array($sedi) && count($sedi) ) ) { ?>
	    <article id="sede" class="it-page-section anchor-offset mb-5">
		<?php if( $sede_id ) { ?>
		<h3>Sede principale</h3>
		<div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
		    <?php
			$luogo = get_post($sede_id);
			$no_icon = true; $no_map = true;
			get_template_part("template-parts/single/luogo");
		    ?>
		</div>
	    </article>
	    <?php } ?>
	    <?php if( is_array($sedi) && count($sedi) ) { ?>
		<h3>Altre sedi</h3>
		<div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
		    <?php foreach ($sedi as $luogo_id) {
			$luogo = get_post($luogo_id);
			$no_icon = true; $no_map = true;
			get_template_part("template-parts/single/luogo");
		    } ?>
		</div>
	    <?php } ?>
	    </article>
	    <?php } ?>

          <?php if ( ( is_array($punti_contatto) && count($punti_contatto) ) || $altri_contatti  ) { ?>
          <article id="contatti" class="it-page-section mb-5">
            <h3>Contatti</h3>
            <?php foreach ($punti_contatto as $pc_id) {
                get_template_part('template-parts/single/punto-contatto');
            } ?>
	    <?php if ($altri_contatti) { ?>
              <div class="mt-5">
                      <?php echo $altri_contatti; ?>
              </div>
	    <?php } ?>
	</article>
          <?php } ?>
                    <?php if( is_array($documenti_collegati) && count($documenti_collegati) ) { ?>
                    <article id="documenti_collegati" class="it-page-section anchor-offset mb-5">
                        <h3>Documenti collegati</h3>
                        <h4 class="visually-hidden">Elenco di documenti pubblici</h4>
                        <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
                            <?php foreach ($documenti_collegati as $documento_id) {
                                $documento = get_post($documento_id);
                                $with_border = true;
                                get_template_part("template-parts/documento/card"); // has H5 inside
                            } ?>
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
