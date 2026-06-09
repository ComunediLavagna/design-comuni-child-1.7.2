<?php
/**
 * Custom Post Type: Attuazione Misure PNRR
 * Registra il CPT, i metabox CMB2 e le funzioni di trasformazione contenuto.
 */

/**
 * Trasforma il_content() in sezioni DCI:
 * - H2 → <article id="slug"> per la navscroll laterale
 * - H3 → accordion Bootstrap Italia
 *
 * Restituisce array ['nav' => [...], 'content' => '...']
 */
function pnrr_transform_content( $content ) {
    $nav_items = [];

    // Dividi per tag H2
    $parts = preg_split( '/(<h2[^>]*>.*?<\/h2>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE );

    // Caso senza H2: usa le H3 come voci di nav con anchor
    $has_h2 = false;
    foreach ( $parts as $p ) {
        if ( preg_match( '/<h2[^>]*>/i', $p ) ) { $has_h2 = true; break; }
    }
    if ( ! $has_h2 ) {
        preg_match_all( '/<h3[^>]*>(.*?)<\/h3>/is', $content, $h3m );
        foreach ( $h3m[1] as $h3_title ) {
            $title       = strip_tags( $h3_title );
            $nav_items[] = [ 'id' => sanitize_title( $title ), 'title' => $title ];
        }
        return [
            'nav'     => $nav_items,
            'content' => pnrr_h3_to_accordion( $content, true ),
        ];
    }

    $output = '';
    $i = 0;
    while ( $i < count( $parts ) ) {
        if ( preg_match( '/<h2[^>]*>(.*?)<\/h2>/is', $parts[ $i ], $h2 ) ) {
            $title = strip_tags( $h2[1] );
            $id    = sanitize_title( $title );
            $nav_items[] = [ 'id' => $id, 'title' => $title ];
            $body  = isset( $parts[ $i + 1 ] ) ? $parts[ $i + 1 ] : '';
            $output .= '<article id="' . esc_attr( $id ) . '" class="it-page-section anchor-offset mb-5">';
            $output .= '<h2 class="title-medium-2-semi-bold mb-4">' . wp_kses_post( $h2[1] ) . '</h2>';
            $output .= pnrr_h3_to_accordion( $body );
            $output .= '</article>';
            $i += 2;
        } else {
            if ( trim( $parts[ $i ] ) ) {
                $output .= pnrr_h3_to_accordion( $parts[ $i ] );
            }
            $i++;
        }
    }

    return [ 'nav' => $nav_items, 'content' => $output ];
}

/**
 * Converte H3 in accordion Bootstrap Italia.
 * Se l'H3 contiene un codice missione PNRR (M1–M6), popola il body
 * con i progetti CPT invece del contenuto dell'editor.
 */
/**
 * $use_title_ids = true: ogni accordion item riceve id=sanitize_title(titolo)
 * per consentire il collegamento dalla nav laterale quando non ci sono H2.
 */
function pnrr_h3_to_accordion( $content, $use_title_ids = false ) {
    $parts = preg_split( '/(<h3[^>]*>.*?<\/h3>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE );

    if ( count( $parts ) <= 1 ) {
        return '<div class="richtext-wrapper lora">' . wp_kses_post( $content ) . '</div>';
    }

    $acc_id = 'acc-pnrr-' . substr( md5( $content ), 0, 6 );
    $output = '';

    if ( trim( $parts[0] ) ) {
        $output .= '<div class="richtext-wrapper lora mb-3">' . wp_kses_post( $parts[0] ) . '</div>';
    }

    $output .= '<div class="accordion' . ( $use_title_ids ? '' : '' ) . '" id="' . esc_attr( $acc_id ) . '">';
    $idx = 0;
    $i   = 1;

    $stati_label  = [ 'avviato' => 'Avviato', 'in_corso' => 'In corso', 'liquidato' => 'Liquidato', 'concluso' => 'Concluso' ];
    $stati_colori = [ 'avviato' => 'bg-primary', 'in_corso' => 'bg-warning text-dark', 'liquidato' => 'bg-success', 'concluso' => 'bg-secondary' ];

    while ( $i < count( $parts ) ) {
        if ( preg_match( '/<h3[^>]*>(.*?)<\/h3>/is', $parts[ $i ], $h3 ) ) {
            $title     = strip_tags( $h3[1] );
            $title_id  = sanitize_title( $title );
            $item_id   = $use_title_ids ? $title_id : ( $acc_id . '-' . $idx );
            $body      = isset( $parts[ $i + 1 ] ) ? $parts[ $i + 1 ] : '';
            // Con title IDs: tutti chiusi; senza: il primo aperto
            $expanded  = ( ! $use_title_ids && $idx === 0 ) ? 'true' : 'false';
            $show      = ( ! $use_title_ids && $idx === 0 ) ? ' show' : '';
            $collapsed = ( ! $use_title_ids && $idx === 0 ) ? '' : ' collapsed';

            // Rileva codice missione (M1–M6) nel titolo H3
            $mission_body = '';
            if ( preg_match( '/\bM(\d)\b/i', $title, $mx ) ) {
                $mn = intval( $mx[1] );
                $progetti = get_posts( [
                    'post_type'      => 'attuazione_pnrr',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'meta_key'       => '_pnrr_investimento',
                    'orderby'        => 'meta_value',
                    'order'          => 'ASC',
                    'meta_query'     => [ [
                        'key'     => '_pnrr_missione',
                        'value'   => 'M' . $mn,
                        'compare' => 'LIKE',
                    ] ],
                ] );

                if ( empty( $progetti ) ) {
                    $mission_body = '<p class="text-secondary fst-italic">Nessun progetto per questa missione.</p>';
                } else {
                    $mission_body = '<ul class="list-unstyled mb-0">';
                    foreach ( $progetti as $p ) {
                        $cup    = get_post_meta( $p->ID, '_pnrr_cup', true );
                        $imp    = get_post_meta( $p->ID, '_pnrr_importo', true );
                        $inv    = get_post_meta( $p->ID, '_pnrr_investimento', true );
                        $stato  = get_post_meta( $p->ID, '_pnrr_stato_avanzamento', true );
                        $mission_body .= '<li class="border-bottom py-2">';
                        $mission_body .= '<div class="d-flex justify-content-between align-items-start flex-wrap gap-2">';
                        $mission_body .= '<div>';
                        $mission_body .= '<a href="' . esc_url( get_permalink( $p->ID ) ) . '" class="fw-semibold text-decoration-none">' . esc_html( $p->post_title ) . '</a>';
                        if ( $inv ) $mission_body .= '<p class="text-secondary small mb-0">Inv. ' . esc_html( $inv ) . ( $cup ? ' – CUP: ' . esc_html( $cup ) : '' ) . '</p>';
                        $mission_body .= '</div>';
                        $mission_body .= '<div class="d-flex gap-2 flex-shrink-0">';
                        if ( $imp ) $mission_body .= '<span class="badge bg-light text-dark border small">' . esc_html( $imp ) . '</span>';
                        if ( $stato && isset( $stati_label[$stato] ) ) $mission_body .= '<span class="badge ' . esc_attr( $stati_colori[$stato] ) . ' small">' . esc_html( $stati_label[$stato] ) . '</span>';
                        $mission_body .= '</div></div></li>';
                    }
                    $mission_body .= '</ul>';
                }
            }

            $accordion_body = $mission_body ?: '<div class="richtext-wrapper lora">' . wp_kses_post( $body ) . '</div>';

            // Anchor wrapper per nav laterale (solo in modalità title IDs)
            if ( $use_title_ids ) {
                $output .= '<div id="' . esc_attr( $title_id ) . '" class="anchor-offset">';
            }
            $output .= '<div class="accordion-item">';
            $output .= '<h3 class="accordion-header" id="heading-' . esc_attr( $item_id ) . '">';
            $output .= '<button class="accordion-button' . $collapsed . '" type="button"'
                     . ' data-bs-toggle="collapse" data-bs-target="#collapse-' . esc_attr( $item_id ) . '"'
                     . ' aria-expanded="' . $expanded . '" aria-controls="collapse-' . esc_attr( $item_id ) . '">'
                     . esc_html( $title ) . '</button></h3>';
            $output .= '<div id="collapse-' . esc_attr( $item_id ) . '" class="accordion-collapse collapse' . $show . '"'
                     . ' aria-labelledby="heading-' . esc_attr( $item_id ) . '"';
            if ( ! $use_title_ids ) {
                $output .= ' data-bs-parent="#' . esc_attr( $acc_id ) . '"';
            }
            $output .= '>';
            $output .= '<div class="accordion-body">' . $accordion_body . '</div>';
            $output .= '</div></div>';
            if ( $use_title_ids ) {
                $output .= '</div>';
            }

            $idx++;
            $i += 2;
        } else {
            $i++;
        }
    }
    $output .= '</div>';
    return $output;
}

// --- CPT ---
add_action( 'init', 'dci_register_post_type_attuazione_pnrr', 60 );
function dci_register_post_type_attuazione_pnrr() {
    $labels = array(
        'name'          => 'Progetti PNRR',
        'singular_name' => 'Progetto PNRR',
        'add_new'       => 'Aggiungi progetto',
        'add_new_item'  => 'Aggiungi nuovo progetto PNRR',
        'edit_item'     => 'Modifica progetto PNRR',
    );
    $args = array(
        'label'         => 'Progetti PNRR',
        'labels'        => $labels,
        'supports'      => array( 'title', 'editor' ),
        'hierarchical'  => false,
        'public'        => true,
        'menu_icon'     => 'dashicons-money-alt',
        'menu_position' => 6,
        'has_archive'   => false,
        'rewrite'       => array( 'slug' => 'attuazione-misure-pnrr', 'with_front' => false ),
        'show_in_rest'  => true,
    );
    register_post_type( 'attuazione_pnrr', $args );
}

// --- METABOX CMB2 ---
add_action( 'cmb2_init', 'dci_add_attuazione_pnrr_metaboxes' );
function dci_add_attuazione_pnrr_metaboxes() {
    $prefix = '_pnrr_';

    $box = new_cmb2_box( array(
        'id'           => $prefix . 'box_identificazione',
        'title'        => 'Identificazione progetto',
        'object_types' => array( 'attuazione_pnrr' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $box->add_field( array(
        'id'   => $prefix . 'missione',
        'name' => 'Missione PNRR',
        'desc' => 'Es: M1 – Digitalizzazione, innovazione, competitività, cultura e turismo',
        'type' => 'text',
    ) );
    $box->add_field( array(
        'id'   => $prefix . 'componente',
        'name' => 'Componente',
        'desc' => 'Es: M1C1',
        'type' => 'text_small',
    ) );
    $box->add_field( array(
        'id'   => $prefix . 'investimento',
        'name' => 'Investimento',
        'desc' => 'Es: 1.2',
        'type' => 'text_small',
    ) );
    $box->add_field( array(
        'id'   => $prefix . 'cup',
        'name' => 'CUP',
        'type' => 'text_medium',
    ) );
    $box->add_field( array(
        'id'   => $prefix . 'importo',
        'name' => 'Importo finanziato',
        'desc' => 'Es: €101.208',
        'type' => 'text_medium',
    ) );
    $box->add_field( array(
        'id'   => $prefix . 'titolare',
        'name' => 'Titolare',
        'desc' => 'Ente titolare del progetto',
        'type' => 'text',
    ) );
    $box->add_field( array(
        'id'      => $prefix . 'stato_avanzamento',
        'name'    => 'Stato di avanzamento',
        'type'    => 'select',
        'options' => array(
            ''          => '— seleziona —',
            'avviato'   => 'Avviato',
            'in_corso'  => 'In corso',
            'liquidato' => 'Liquidato',
            'concluso'  => 'Concluso',
        ),
    ) );
    $box->add_field( array(
        'id'   => $prefix . 'data_aggiornamento',
        'name' => 'Data ultimo aggiornamento',
        'type' => 'text_date',
        'date_format' => 'd/m/Y',
    ) );

    $box2 = new_cmb2_box( array(
        'id'           => $prefix . 'box_dettagli',
        'title'        => 'Dettagli progetto',
        'object_types' => array( 'attuazione_pnrr' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );
    $box2->add_field( array(
        'id'      => $prefix . 'attivita_finanziate',
        'name'    => 'Attività finanziate',
        'type'    => 'wysiwyg',
        'options' => array( 'media_buttons' => false, 'textarea_rows' => 6, 'teeny' => false ),
    ) );
    $box2->add_field( array(
        'id'   => $prefix . 'atti_amministrativi',
        'name' => 'Atti amministrativi (URL)',
        'desc' => 'Link alla sezione Amministrazione Trasparente',
        'type' => 'text_url',
    ) );
    $box2->add_field( array(
        'id'   => $prefix . 'link_pa_digitale',
        'name' => 'Modalità di accesso (PAdigitale2026)',
        'desc' => 'Link al portale PAdigitale2026',
        'type' => 'text_url',
    ) );
}
