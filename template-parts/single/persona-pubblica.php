<?php
global $big_title;

global $persona_id;
$prefix = '_dci_persona_pubblica_';

$persona_obj = get_post($persona_id);
$descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $persona_obj->ID);

$incarichi = '';
$arr = array();
$incarichi_ids = dci_get_meta("incarichi", $prefix, $persona_obj->ID);
if (is_array($incarichi_ids) && count($incarichi_ids) ) { 
	foreach ($incarichi_ids as $incarico_id) {
		$arr[] = get_the_title($incarico_id);
	}
}
if (count($arr)>0) $incarichi = '<p class="'.( $big_title ? 'h5' : 'h6' ).'">'.implode(' - ',$arr).'</p>';

$competenze = dci_get_wysiwyg_field("competenze", $prefix, $persona_obj->ID);
$deleghe = dci_get_wysiwyg_field("deleghe", $prefix, $persona_obj->ID);

?>
<div class="card card-wrapper card-teaser shadow mt-3 rounded">
<?php /*
    <svg class="icon" aria-hidden="true">
        <use xlink:href="#it-pin"></use>
    </svg>
*/ ?>
    <div class="card-body mb-2">
        <h3 class="card-title <?php print( $big_title ? 'h4' : 'h5' ); ?>">
            <a class="text-decoration-none" href="<?php echo get_permalink($persona_obj->ID)?>">
            <?php echo $persona_obj->post_title; ?>
            </a>
        </h3>
  	<?php if ( $incarichi ) { print($incarichi); } ?>
  	<?php if ( $competenze ) { print($competenze);  } ?>
  	<?php if ( $deleghe ) { print($deleghe); } ?>
      <div class="card-text">
            <?php print_r($descrizione_breve); ?>
        </div>
    </div>
</div>