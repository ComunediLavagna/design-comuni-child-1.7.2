<?php

global $pc_id;
$prefix = '_dci_punto_contatto_';

$contatto = get_post( $pc_id );
if ( ! $contatto instanceof WP_Post ) return;

$full_contatto = dci_get_full_punto_contatto( $pc_id );
if ( ! is_array( $full_contatto ) ) $full_contatto = [];
$voci = dci_get_meta( 'voci', $prefix, $pc_id );

$other_contacts = array(
    'linkedin',
   # 'pec',
    'skype',
    'telegram',
    'twitter',
    'whatsapp'
);

?>
<div class="card card-teaser shadow mt-3 rounded">
    <svg class="icon" aria-hidden="true" focusable="false">
        <use xlink:href="#it-telephone"></use>
    </svg>
    <div class="card-body pb-2">
        <h3 class="card-title h5">
            <a class="text-decoration-none" href="<?php echo esc_url( get_permalink($contatto->ID) ); ?>" data-element="service-area">
            <?php echo esc_html( $contatto->post_title ); ?>
            </a>
        </h3>
        <div class="card-text">
            <?php if ( isset($full_contatto['indirizzo']) && is_array($full_contatto['indirizzo']) && count ($full_contatto['indirizzo']) ) {
                foreach ($full_contatto['indirizzo'] as $value) {
                    echo '<p class="mb-3">' . esc_html( $value ) . '</p>';
                }
            } ?>
            <?php if ( isset($full_contatto['telefono']) && is_array($full_contatto['telefono']) && count ($full_contatto['telefono']) ) {
                foreach ($full_contatto['telefono'] as $value) {
                    echo '<p><a href="tel:' . esc_attr( preg_replace('/\s+/', '', $value) ) . '">T ' . esc_html( $value ) . '</a></p>';
                }
            } ?>
            <?php if ( isset($full_contatto['url']) && is_array($full_contatto['url']) && count ($full_contatto['url']) ) {
                foreach ($full_contatto['url'] as $value) { ?>
                    <p>
                        <a href="<?php echo esc_url( $value ); ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr( $value ); ?> (si apre in una nuova finestra)">
                            <?php echo esc_html( $value ); ?>
                            <span class="visually-hidden">(si apre in una nuova finestra)</span>
                        </a>
                    </p>
               <?php }
            } ?>
            <?php if ( isset($full_contatto['email']) && is_array($full_contatto['email']) && count ($full_contatto['email']) ) {
                foreach ($full_contatto['email'] as $value) { ?>
                    <p>
                        <a href="mailto:<?php echo esc_attr( $value ); ?>"
                           aria-label="<?php echo esc_attr( sprintf( "Invia un'email a %s", $value ) ); ?>">
                            <?php echo esc_html( $value ); ?>
                        </a>
                    </p>
               <?php }
            } ?>
        </div>
        <div class="card-text">
            <?php if ( isset($full_contatto['pec']) && is_array($full_contatto['pec']) && count ($full_contatto['pec']) ) {
                foreach ($full_contatto['pec'] as $value) {
                    echo '<p>PEC: <a href="mailto:' . esc_attr( $value ) . '" aria-label="' . esc_attr( sprintf( "Invia una PEC a %s", $value ) ) . '">' . esc_html( $value ) . '</a></p>';
                }
            } ?>
            <?php foreach ($other_contacts as $type) {
                if ( isset($full_contatto[$type]) && is_array($full_contatto[$type]) && count ($full_contatto[$type]) ) {
                    foreach ($full_contatto[$type] as $value) {
                        echo '<p>' . esc_html( ucfirst($type) ) . ': ' . esc_html( $value ) . '</p>';
                    }
                }
            } ?>
        </div>
    </div>
</div>
