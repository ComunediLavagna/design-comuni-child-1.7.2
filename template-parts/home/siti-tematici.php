<?php
global $has_argomenti_evidenza, $into_argomento, $sito_tematico_id, $count;

$siti_tematici = dci_get_option('siti_tematici','homepage');
if(is_array($siti_tematici) && count($siti_tematici)) {
?>
<div class="container">
    <h2 class="mb-0 <?php print($has_argomenti_evidenza?'mt-4':'text-white'); ?>">Siti tematici</h2>
  <div class="row pt-4 pt-lg-30">
      <?php
      $count = 1;
      foreach ($siti_tematici as $sito_tematico_id) {
        get_template_part("template-parts/sito-tematico/card");
        ++$count;
      } ?>
  </div>
</div>
<?php } ?>


