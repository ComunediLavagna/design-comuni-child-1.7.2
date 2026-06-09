<?php

// Estende il load_more del padre aggiungendo i card type custom (evento, persona)
// e applicando le stesse fix di sicurezza introdotte nel padre v1.12.7

add_action("wp_ajax_load_more", "load_more_child", 9); // priorità 9 = prima del padre (10)
add_action("wp_ajax_nopriv_load_more", "load_more_child", 9);

function load_more_child() {
    global $servizio, $i, $hide_categories;

    $load_card_type  = isset($_POST['load_card_type'])  ? sanitize_key(wp_unslash($_POST['load_card_type']))           : '';
    $load_card_term  = isset($_POST['load_card_term'])  ? sanitize_text_field(wp_unslash($_POST['load_card_term']))     : '';
    $search          = isset($_POST['search'])           ? sanitize_text_field(wp_unslash($_POST['search']))             : '';
    $post_count      = isset($_POST['post_count'])       ? absint($_POST['post_count'])                                  : 0;
    $load_posts      = isset($_POST['load_posts'])       ? absint($_POST['load_posts'])                                  : 10;
    $posts_per_page  = max(1, min(500, $post_count + $load_posts));

    $post_types      = dci_sanitize_load_more_post_types(dci_safe_json_array_from_post('post_types'));
    $url_query_params = dci_safe_json_array_from_post('query_params');

    $args = array(
        's'              => $search,
        'posts_per_page' => $posts_per_page,
        'post_type'      => $post_types,
        'post_status'    => 'publish',
        'orderby'        => 'post_title',
        'order'          => 'ASC',
    );

    if ($load_card_type == "notizia") {
        $args['orderby'] = 'ID';
        $args['order']   = 'DESC';
        if ($load_card_term != '') {
            $args['tax_query'] = array(array(
                'taxonomy' => 'tipi_notizia',
                'field'    => 'name',
                'terms'    => $load_card_term,
            ));
        }
    }

    if ($load_card_type == "evento") {
        $args['orderby']  = 'meta_value_num';
        $args['meta_key'] = '_dci_evento_data_orario_inizio';
        $args['order']    = 'DESC';
    }

    if (isset($url_query_params['post_terms'])) {
        $terms = array_map('absint', (array) $url_query_params['post_terms']);
        $args['tax_query'] = array(array(
            'taxonomy' => 'argomenti',
            'field'    => 'id',
            'terms'    => $terms,
        ));
    }
    if (isset($url_query_params['post_types'])) {
        $args['post_type'] = dci_sanitize_load_more_post_types($url_query_params['post_types']);
    }
    if (isset($url_query_params['s'])) {
        $args['s'] = sanitize_text_field($url_query_params['s']);
    }

    $new_query = new WP_Query($args);

    $out = '';
    if ($new_query->have_posts()) :
        $i = 0;
        while ($new_query->have_posts()) : $new_query->the_post();
            $post = get_post();
            ++$i;

            if ($load_card_type == "servizio") {
                $servizio = $post;
                $out .= load_template_part("template-parts/servizio/card");
            }
            if ($load_card_type == "categoria_servizio") {
                $servizio = $post;
                $hide_categories = true;
                $out .= load_template_part("template-parts/servizio/card");
            }
            if ($load_card_type == "notizia") {
                $out .= load_template_part("template-parts/novita/cards-list");
            }
            if ($load_card_type == "documento") {
                $out .= load_template_part("template-parts/documento/cards-list");
            }
            if ($load_card_type == "global-search") {
                $out .= load_template_part("template-parts/search/item");
            }
            if ($load_card_type == "domanda-frequente") {
                $out .= load_template_part("template-parts/domanda-frequente/item");
            }
            if ($load_card_type == "evento") {
                $out .= load_template_part("template-parts/evento/card-full");
            }
            if ($load_card_type == "luogo") {
                $out .= load_template_part("template-parts/luogo/cards-list");
            }
            if ($load_card_type == "persona_pubblica") {
                $out .= load_template_part("template-parts/persona/cards-list");
            }
        endwhile;
    endif;

    $res = array(
        'response'   => $out,
        'post_count' => count($new_query->posts),
    );
    if ($new_query->found_posts <= count($new_query->posts)) {
        $res['all_results'] = true;
    }

    wp_reset_postdata();
    wp_send_json($res);
}
