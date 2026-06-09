<?php
/**
 * Evento template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Design_Comuni_Italia
 */
global $prefix, $gallery, $video, $trascrizione, $persona_id, $inline;

$tpc_list = array(
	'indirizzo',
	'telefono',
	'url',
	'email',
	'pec',
	'linkedin',
	'skype',
	'telegram',
	'twitter',
	'whatsapp'
);

get_header();
?>

<main>
  <?php
  while ( have_posts() ) :
    the_post();
    $user_can_view_post = dci_members_can_user_view_post(get_current_user_id(), $post->ID);

    $prefix = '_dci_punto_contatto_';
    #$descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $post->ID); // [N.U.]
    
	$persona_id = dci_get_meta("persona", $prefix, $post->ID); // persone pubbliche
	$voci = dci_get_meta("voci", $prefix, $post->ID); // array
	$voci2 = array();
	foreach($tpc_list as $tpc) {
		foreach($voci as $vid=>$voce) {
			if($voce[$prefix.'tipo_punto_contatto']==$tpc) { 
				$voci2[] = $voce; 
				unset($voci[$vid]); 
			}
		};
	};
	foreach($voci as $vid=>$voce) { // extra types, if present
		$voci2[] = $voce; 
	};
	$voci = $voci2;
    /*
    $gallery = dci_get_meta("gallery", $prefix, $post->ID); // N.U.
    $video = dci_get_meta("video", $prefix, $post->ID); // N.U.
    $trascrizione = dci_get_meta("trascrizione", $prefix, $post->ID);
    */
    #$more_info = dci_get_wysiwyg_field("ulteriori_informazioni", $prefix, $post->ID); // Ulteriori informazioni [N.U.]
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
           <h2 class="visually-hidden">Punto di contatto</h2>
         <p class="h5" data-audio>
            <?php echo @$descrizione_breve; ?>
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
					<?php if (is_array($voci) && count($voci) ) { ?>
						<?php foreach ($voci as $voce) { ?>
						<li class="nav-item">
							<a class="nav-link" href="#contatto_<?php print($voce[$prefix.'tipo_punto_contatto']); ?>">
								<span class="title-medium"><?php print(ucfirst($voce[$prefix.'tipo_punto_contatto'])); ?></span>
							</a>
						</li>
						<?php } ?>
					<?php } ?>
                                               <?php if ( @$more_info ) {  ?>
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
	<?php if (is_array($voci) && count($voci) ) { ?>
		<?php foreach ($voci as $voce) { ?>
		<article id="contatto_<?php print($voce[$prefix.'tipo_punto_contatto']); ?>" class="it-page-section mb-5">
			<h3><?php print(ucfirst($voce[$prefix.'tipo_punto_contatto'])); ?></h3>
			<div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal">
				<div class="card card-teaser shadow mt-3 rounded">
					<div class="card-body">
						<div class="card-text">
							<?php if ($voce[$prefix.'tipo_punto_contatto']=='url') { ?>
								<a 
								target="_blank" 
								aria-label="scopri di più su <?php print($voce[$prefix.'valore']); ?> - link esterno - apertura nuova scheda" 
								title="vai sul sito <?php print($voce[$prefix.'valore']); ?>" 
								href="<?php print($voce[$prefix.'valore']); ?>">
								    <?php print($voce[$prefix.'valore']); ?>
								</a>
							<?php } elseif ($voce[$prefix.'tipo_punto_contatto']=='email') { ?>
								<a  
								target="_blank" 
								aria-label="invia un'email a <?php  print($voce[$prefix.'valore']); ?>"
								title="invia un'email a <?php  print($voce[$prefix.'valore']); ?>" 
								href="mailto:<?php print($voce[$prefix.'valore']); ?>">
								    <?php print($voce[$prefix.'valore']); ?>
								</a>
							<?php } else { 
								print($voce[$prefix.'valore']); 
								} ?>
						</div>				
					</div>				
				</div>				
			</div>				
		</article>
		<?php } ?>
	<?php } ?>
          <?php if (@$more_info) { ?>
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
