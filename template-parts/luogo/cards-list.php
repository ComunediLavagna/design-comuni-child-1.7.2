<?php 
    global $post;

        $description = dci_get_meta('descrizione_breve');
        $img = dci_get_meta('immagine');
       $tipo = get_the_terms($post->ID, 'tipi_luogo')[0];
        if ($img) {
?>
<div class="col-md-6 col-xl-4">
  <div class="card-wrapper border border-light rounded shadow-sm">
    <div class="card no-after rounded">

      <div class="img-responsive-wrapper">
        <div class="img-responsive img-responsive-panoramic">
          <figure class="img-wrapper">
            <?php dci_get_img($img, ''); ?>
          </figure>
        </div>
      </div>

      <div class="card-body">
        <div class="category-top">
          <a class="category text-decoration-none" href="<?php /*echo get_term_link($tipo->term_id);*/ ?>">
            <?php echo strtoupper($tipo->name); ?>
        </a>
        </div>
        <a class="text-decoration-none" href="<?php echo get_permalink(); ?>">
          <h3 class="card-title"><?php echo the_title(); ?></h3>
        </a>
        <p class="card-text text-secondary">
          <?php echo $description; ?>
        </p>
      </div>

    </div>
  </div>
</div>
<?php } else { ?>
<div class="col-md-6 col-xl-4">
  <div class="card-wrapper border border-light rounded shadow-sm cmp-list-card-img cmp-list-card-img-hr">
    <div class="card no-after rounded">
      <div class="row g-2 g-md-0 flex-md-column">
        <div class="col-12 order-1 order-md-2">
          <div class="card-body card-img-none rounded-top">
            <div class="category-top">
              <span class="category text-decoration-none">
                <?php echo strtoupper($tipo->name); ?>
              </span>
            </div>
            <a class="text-decoration-none" href="<?php echo get_permalink(); ?>">
              <h3 class="card-title"><?php echo the_title(); ?></h3>
            </a>
            <p class="card-text text-secondary">
              <?php echo $description; ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>