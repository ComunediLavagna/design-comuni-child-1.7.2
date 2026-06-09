<?php

global $luogo_id;
$prefix = '_dci_luogo_';

$luogo_obj = get_post($luogo_id);
$luogo_indirizzo = dci_get_meta("indirizzo", $prefix, $luogo_obj->ID);

?>
<div class="card card-teaser shadow mt-3 rounded">
<?php /*
    <svg class="icon" aria-hidden="true">
        <use xlink:href="#it-pin"></use>
    </svg>
*/ ?>
    <div class="card-body">
        <h3 class="card-title h5">
            <a class="text-decoration-none" href="<?php echo get_permalink($luogo_obj->ID)?>">
            <?php echo $luogo_obj->post_title; ?>
            </a>
        </h3>
        <div class="card-text">
            <?php print_r($luogo_indirizzo); ?>
        </div>
    </div>
</div>