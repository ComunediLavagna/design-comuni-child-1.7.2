<?php

global $uo_id;
$prefix = '_dci_unita_organizzativa_';

$uo_obj = get_post($uo_id);
$uo_descrizione = dci_get_meta("descrizione_breve", $prefix, $uo_obj->ID);

?>
<div class="card card-teaser shadow mt-3 rounded">
<?php /*
    <svg class="icon" aria-hidden="true">
        <use xlink:href="#it-pin"></use>
    </svg>
*/ ?>
    <div class="card-body">
        <h3 class="card-title h5">
            <a class="text-decoration-none" href="<?php echo get_permalink($uo_obj->ID)?>">
            <?php echo $uo_obj->post_title; ?>
            </a>
        </h3>
        <div class="card-text">
            <?php print_r($uo_descrizione); ?>
        </div>
    </div>
</div>