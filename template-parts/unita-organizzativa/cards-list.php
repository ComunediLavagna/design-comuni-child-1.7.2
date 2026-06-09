<?php 
    global $post;
        $description = dci_get_meta('descrizione_breve');
        #$img = dci_get_meta('immagine');
       #$tipo = get_the_terms($post->ID, 'tipi_incarico')[0];
       global $big_title; $big_title = true;
        if ($post->ID) {
?>	
<div class="col-md-6 col-xl-4">
	<?php get_template_part("template-parts/single/unita-organizzativa"); ?>
</div>
<?php } ?>