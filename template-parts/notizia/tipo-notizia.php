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
global $obj, $tipo_notizia, $with_border, $uo_id, $custom_class;

#print('<pre>'.print_r($obj,true).'</pre>');
$tipo_notizia = $obj;
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
          <div class="col-12 px-0 py-2">
            <!--div class="it-hero-card it-hero-bottom-overlapping rounded hero-p pb-lg-80 drop-shadow <?php echo ($img? '' : 'mt-0'); ?>"-->
  
                <div class="row justify-content-center pt-5">
                  <div class="col-12 col-lg-10">
                    <?php 
                      $custom_class = 'mt-0';
                      get_template_part("template-parts/common/breadcrumb"); 
                    ?>
                  </div>
                </div>
                <div class="row sport-wrapper justify-content-between mt-lg-2">
                  <div class="col-12 col-lg-5 offset-lg-1">
                    <h1 class="mb-3 mb-lg-4 title-xxlarge text-black">
                      <?php echo $tipo_notizia->name; ?>
                    </h1>
                    <h2 class="visually-hidden" id="news-details">Dettagli del tipo di notizia</h2>
                    <p class="u-main-black text-paragraph-regular-medium mb-60">
                        <?php echo $tipo_notizia->description; ?>
                    </p>
                  </div>
                </div>
  
            <!--/div-->
          </div>
        </div>
      </div>
    </div>
    <?php get_template_part("template-parts/notizia/tutte-notizie"); ?>
    <?php get_template_part("template-parts/common/valuta-servizio"); ?>
    <?php get_template_part("template-parts/common/assistenza-contatti"); ?>
</main>
<?php
get_footer();
