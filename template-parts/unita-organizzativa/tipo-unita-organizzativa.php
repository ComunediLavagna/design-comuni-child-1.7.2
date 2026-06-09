<?php
/**
 * The template for displaying archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#archive
 *
 * @package Design_Comuni_Italia
 *
 * STS 2023
 */
global $obj, $tipo_unita_organizzativa, $with_border, $uo_id, $custom_class;

#print('<pre>'.print_r($obj,true).'</pre>');
$tipo_unita_organizzativa = $obj;
$img = dci_get_term_meta('immagine', "dci_term_", $obj->term_id); // not set

get_header();
?>
<main>
    <div class="it-hero-wrapper it-wrapped-container" id="main-container">
      <?php if ($img) { ?>
      <div class="img-responsive-wrapper">
        <div class="img-responsive">
          <div class="img-wrapper">
            <?php dci_get_img($img); ?>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="container">
        <div class="row">
          <div class="col-12 px-0 px-lg-2">
            <div class="it-hero-card it-hero-bottom-overlapping rounded hero-p pb-lg-80 drop-shadow <?php echo ($img? '' : 'mt-0'); ?>">
  
                <div class="row justify-content-center">
                  <div class="col-12 col-lg-10">
                    <?php 
                      $custom_class = 'mt-0';
                      get_template_part("template-parts/common/breadcrumb"); 
                    ?>
                  </div>
                </div>
                <div class="row sport-wrapper justify-content-between mt-lg-2">
                  <div class="col-12 col-lg-5 offset-lg-1">
                    <h1 class="mb-3 mb-lg-4 title-xxlarge">
                      <?php echo $tipo_unita_organizzativa->name; ?>
                    </h1>
                    <h2 class="visually-hidden" id="news-details">Dettagli del tipo di unit&agrave; organizzativa</h2>
                    <p class="u-main-black text-paragraph-regular-medium mb-60">
                        <?php echo $tipo_unita_organizzativa->description; ?>
                    </p>
                  </div>
                </div>
  
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
    $posts = dci_get_grouped_posts_by_term( 'unita_organizzativa' , 'tipi_unita_organizzativa', $tipo_unita_organizzativa->slug, -1 ); // -1 = all
?>

<section id="lista-documenti">
    <div class="bg-grey-card pt-40 pt-md-100 pb-50">
        <div class="container">
            <!--div class="row row-title">
                <div class="col-12">
                <h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 mt-lg-3 title-large-semi-bold">
                    Documenti pubblici
                </h3>
                </div>
            </div-->
            <div class="row pt-4 mt-lg-2 pb-lg-4">
		<?php foreach ($posts as $post) { 
                    get_template_part("template-parts/unita-organizzativa/cards-list"); // card-full
		} 
                wp_reset_postdata();
		?>
            </div>
            <div class="d-flex justify-content-end mt-5 me-5">
		<p class="text-lg-end">
		<a href="/amministrazione/" class="btn btn-outline-primary full-mb">
                    Tutte le strutture amministrative
                    <svg class="icon icon-primary icon-xs ml-10">
                      <use href="#it-arrow-right"></use>
                    </svg>
                </a>
	     </p>
           </div>
        </div>
    </div>
</section>   
    
    <?php get_template_part("template-parts/common/valuta-servizio"); ?>
    <?php get_template_part("template-parts/common/assistenza-contatti"); ?>
</main>
<?php
get_footer();
