<?php
    global $luogo, $luoghi, $no_icon, $no_map;

    if ( ! $luogo instanceof WP_Post ) return;

    $prefix   = '_dci_luogo_';
    $subtitle = dci_get_meta( 'nome_alternativo', $prefix, $luogo->ID );
    $indirizzo = dci_get_meta( 'indirizzo', $prefix, $luogo->ID );
?>

<div class="card card-teaser shadow mt-3 rounded">
    <?php if ( ! $no_icon ) : ?>
    <svg class="icon" aria-hidden="true" focusable="false">
        <use xlink:href="#it-pin"></use>
    </svg>
    <?php endif; ?>
    <div class="card-body mb-2">
        <h3 class="card-title h5">
            <a class="text-decoration-none" href="<?php echo esc_url( get_permalink( $luogo->ID ) ); ?>">
                <?php echo esc_html( $luogo->post_title ); ?>
            </a>
        </h3>
        <?php if ( $subtitle ) : ?>
        <p class="h6"><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>
        <?php if ( $indirizzo ) : ?>
        <div class="card-text">
            <p><?php echo esc_html( $indirizzo ); ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
    if ( ! $no_map ) {
        $luoghi = [ $luogo ];
        get_template_part( "template-parts/luogo/map" );
    }
?>
