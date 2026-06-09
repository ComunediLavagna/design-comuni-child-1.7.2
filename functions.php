<?php

// child theme php:

include get_stylesheet_directory() . '/inc/utils.php';

// child theme js:

add_action( 'wp_head', 'include_child_utils_js' );

function include_child_utils_js() {   
        echo '<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/scripts/utils.js"></script>';
}

add_action( 'wp_footer', 'include_child_footer_js' );

function include_child_footer_js() {   
        echo '<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/scripts/footer.js"></script>';
}

// child theme css:

add_action( 'wp_enqueue_scripts', 'dci_child_styles', 11); // lower priority to be executed AFTER main theme ( 10 = default )
#add_action( 'wp_footer', 'dci_child_styles', 11); // lower priority to be executed AFTER main theme ( 10 = default )

function dci_child_styles() {
	
	wp_dequeue_style('dci-font');
	
	// nota:gli elementi indicati come dipendenze non possono essere rimossi (es.: dci-boostrap-italia-min e dci-comuni)
	
	/*wp_enqueue_style( 'dci-child-comuni',
		get_stylesheet_directory_uri() . '/assets/css/comuni.css?t=' . time(),
		array(),
		wp_get_theme() -> get( 'Version' )
	);*/
	wp_enqueue_style( 'dci-child-font',
		get_stylesheet_directory_uri() . '/assets/css/fonts.css',
		array(),
		wp_get_theme() -> get( 'Version' )
	);
	wp_enqueue_style( 'dci-child-style',
		#get_stylesheet_directory_uri() . '/style.css?t=' . time(),
		get_stylesheet_directory_uri() . '/style.css',
		array(),
		wp_get_theme() -> get( 'Version' )
	);
}


// include new manifest file:

add_action( 'wp_head', 'include_manifest_link' );

function include_manifest_link() {   
        echo '<link rel="manifest" href="'.get_stylesheet_directory_uri().'/manifest.json" />';
        echo '<meta name="theme-color" content="#007A52" />';
        echo '<link rel="apple-touch-icon" href="'.get_stylesheet_directory_uri().'/assets/img/apple-touch-icon.png" />';
	echo '<script>if (navigator && navigator.serviceWorker) { navigator.serviceWorker.register(\'/service_worker.js\',{scope: \'./\'}); }</script>';
}

// remove old-fashoned manifest:

remove_action('wp_head', 'wlwmanifest_link');


/******************************/


// custom login page logo:

add_filter('login_headerurl','custom_login_url');

function custom_login_url() {
	return '/';
}

add_filter('login_headertitle','custom_login_title');

function custom_login_title() {
	return 'Vai a ' . get_bloginfo( 'title', 'display' );
}

add_filter('login_headertext','custom_login_text');

function custom_login_text() {
	if (dci_get_option("stemma_comune")) {
		$logo = '<svg width="82" height="82" class="icon" aria-hidden="true">'.
			'<image xlink:href="' . dci_get_option("stemma_comune") .'" width="82" height="82" />'.
			'</svg><p>'.get_bloginfo( 'title', 'display' ).'</p>'.
			'<style>.login h1 a { width: auto; height: auto; text-indent: 0; background-image: none; }</style>';
		return $logo;
	}  else {
		return 'Vai a ' . get_bloginfo( 'title', 'display' );
	}
}


// redirect to custom page after login:

add_filter('login_redirect', 'custom_login_redirect');
function custom_login_redirect() {
	return '/area-personale';
}

add_filter('logout_redirect', 'custom_logout_redirect');
function custom_logout_redirect() {
	return '/';
}


/*******************************/


 // protect super-user from being shown in users list:

add_action('pre_user_query','dci_protect_admin');

function dci_protect_admin($user_search) {

    $admin_ids = '1'; // IDs list to hide - es. '1,2,3'

    $user = wp_get_current_user();
    $admin_array = explode($admin_ids, ',');
    if ( ! in_array( $user->ID, $admin_array ) ) {
        global $wpdb;
        $user_search->query_where = str_replace('WHERE 1=1', "WHERE 1=1 AND {$wpdb->users}.ID NOT IN($admin_ids)",$user_search->query_where);

    }
}

/*******************************/


// consent taxonomy pages and breadcrumbs for some missing types:

add_action( 'init', 'dci_register_taxon_changes', 11 );

function dci_register_taxon_changes() {
	
	$args = (array) get_post_type_object( 'luogo' );
	#$args['rewrite']['slug'] = 'luoghi';
	$args['has_archive'] = true;
	register_post_type( 'luogo', $args );
	
	$args = (array) get_post_type_object( 'evento' );
	#$args['rewrite']['slug'] = 'eventi';
	$args['has_archive'] = true;
	register_post_type( 'evento', $args );
	
	$args = (array) get_post_type_object( 'documento_pubblico' );
	#$args['rewrite']['slug'] = 'eventi';
	$args['has_archive'] = true;
	register_post_type( 'documento_pubblico', $args );
	
	$args = (array) get_post_type_object( 'unita_organizzativa' );
	#$args['rewrite']['slug'] = 'eventi';
	$args['has_archive'] = true;
	register_post_type( 'unita_organizzativa', $args );
	
	$args = (array) get_taxonomy( 'tipi_luogo' );
	$args['public'] = true; 
	$args['publicly_queryable'] = true;
	$args['query_var'] = 'tipi_luogo';
	$args['has_archive'] = true;
	register_taxonomy( 'tipi_luogo', array('luogo'), $args );
	
	$args = (array) get_taxonomy( 'tipi_evento' );
	$args['public'] = true; 
	$args['publicly_queryable'] = true;
	$args['query_var'] = 'tipi_evento';
	$args['has_archive'] = true;
	register_taxonomy( 'tipi_evento', array('evento'), $args );
	
	$args = (array) get_taxonomy( 'tipi_documento' );
	$args['public'] = true; 
	$args['publicly_queryable'] = true;
	$args['query_var'] = 'tipi_documento';
	$args['has_archive'] = true;
	register_taxonomy( 'tipi_documento', array('documento_pubblico'), $args );
	
	$args = (array) get_taxonomy( 'tipi_unita_organizzativa' );
	$args['public'] = true; 
	$args['publicly_queryable'] = true;
	$args['query_var'] = 'tipi_unita_organizzativa';
	$args['has_archive'] = true;
	register_taxonomy( 'tipi_unita_organizzativa', array('unita_organizzativa'), $args );
	
	$args = (array) get_taxonomy( 'tipi_notizia' );
	$args['public'] = true; 
	$args['publicly_queryable'] = true;
	$args['query_var'] = 'tipi_notizia';
	$args['has_archive'] = true;
	register_taxonomy( 'tipi_notizia', array('notizia'), $args );
	
	# TODO: UO AREE, UO UFFICI...
}


// aggiunge/modifica alcune opzioni dell'amministrazione

#add_action( 'cmb2_admin_init', 'custom_register_main_options_metabox' );
add_action( 'cmb2_init', 'custom_register_main_options_metabox', 99 );

function custom_register_main_options_metabox() {
	
	$home_options = cmb2_get_metabox('dci_options_home');
	#$home_options = CMB2_Boxes::get('dci_options_home');
	if ($home_options) {
		/*
		# INUTILE, IL LAYOUT NE PREVEDE UNA SOLA
		$home_options->update_field_property(
			'notizia_evidenziata', // $field_id
			'attributes', // $property
			array( 'data-max-items' => 3) // $value
		);
		*/
		$home_options->update_field_property(
			'notizie_in_home', // $field_id
			'options', // $property
			array(
				0 => __(0, 'design_comuni_italia'),
				3 => __(3, 'design_comuni_italia'),
				6 => __(6, 'design_comuni_italia'),
				9 => __(9, 'design_comuni_italia'),
				12 => __(12, 'design_comuni_italia'),
				15 => __(15, 'design_comuni_italia'),
			),
		);
		$home_options->get_field('notizie_in_home',null,true); // activate changes
		/*
		$opts = $home_options -> get_field('schede_evidenziate',null,true) -> args['options'];
		$opts['query_args']['post_type'] =  array('evento','luogo','unita_organizzativa','documento_pubblico','servizio','notizia','dataset','page');
		$home_options->update_field_property(
			'schede_evidenziate', // $field_id
			'options', // $property
			$opts, // $value
		);
		*/
		$home_options->update_field_property(
			'schede_evidenziate', // $field_id
			'attributes', // $property
			array( 'data-max-items' => 15), // $value
		);
		$home_options->get_field('schede_evidenziate',null,true); // activate changes
	}
	
	$amministrazione_options = cmb2_get_metabox('dci_options_amministrazione');
	#$amministrazione_options = CMB2_Boxes::get('dci_options_amministrazione');
	if ($amministrazione_options) {
		$opts = $amministrazione_options -> get_field('notizia_evidenziata',null,true) -> args['options'];
		$opts['query_args']['post_type'][] =  'page';
		$amministrazione_options->update_field_property(
			'notizia_evidenziata', // $field_id
			'options', // $property
			$opts, // $value
		);
		$amministrazione_options->update_field_property(
			'notizia_evidenziata', // $field_id
			'attributes', // $property
			array( 'data-max-items' => 15), // $value
		);
		$amministrazione_options->get_field('notizia_evidenziata',null,true); // activate changes
	}
	
	$documenti_options = cmb2_get_metabox('dci_options_documenti');
	#$documenti_options = CMB2_Boxes::get('dci_options_documenti');
	if ($documenti_options) {
		$opts = $documenti_options -> get_field('contenuti_evidenziati',null,true) -> args['options'];
		$opts['query_args']['post_type'][] =  'page';
		$documenti_options->update_field_property(
			'contenuti_evidenziati', // $field_id
			'options', // $property
			$opts, // $value
		);
		$documenti_options->update_field_property(
			'contenuti_evidenziati', // $field_id
			'attributes', // $property
			array( 'data-max-items' => 15), // $value
		);
		$documenti_options->get_field('contenuti_evidenziati',null,true); // activate changes
	}
	
	$footer_options = cmb2_get_metabox('dci_options_footer');
	if ($footer_options) {
		$prefix = 'dci_'; // nope
		$prefix = '';
		$footer_options->add_field( array(
			'id' => $prefix . 'contatti_CU_FE',
			'name' => 'Codice Univoco Ufficio per la fatturazione elettronica',
			'type' => 'text',
		) );	
		$footer_options->get_field('contatti_CU_FE',null,true); // activate changes
		
		$footer_options->add_field( array(
			'id' => $prefix . 'more_info',
			'name' => 'Altre informazioni',
			#'desc' => __( 'Massimo 140 caratteri' , 'design_comuni_italia' ),
			'type' => 'textarea_small',
			'attributes'    => array(
			    'rows'  => 3,
			    #'maxlength'  => '140',
			),
		) );	
	}
	
	# Box editing custom post types #
	
	# Servizi #
	$box_options = cmb2_get_metabox('_dci_servizio_box_destinatari');
	if ($box_options) {
		$box_options->update_field_property('_dci_servizio_a_chi_e_rivolto','name','A chi è rivolto');
		$box_options->update_field_property('_dci_servizio_a_chi_e_rivolto','attributes',array('required'=>false));
		$box_options->get_field('_dci_servizio_a_chi_e_rivolto',null,true); // activate changes
	}
	#print('<div style="margin-left: 200px;"><h1>$box_options:</h1><pre>'.print_r($box_options,true).'</pre></div>');
	$box_options = cmb2_get_metabox('_dci_servizio_box_come_fare');
	if ($box_options) {
		$box_options->update_field_property('_dci_servizio_come_fare','attributes',array('required' => false));
		$box_options->get_field('_dci_servizio_come_fare',null,true); // activate changes
	}
	$box_options = cmb2_get_metabox('_dci_servizio_box_cosa_serve');
	if ($box_options) {
		$box_options->update_field_property('_dci_servizio_cosa_serve_introduzione','attributes',array('required' => false));
		$box_options->get_field('_dci_servizio_cosa_serve_introduzione',null,true); // activate changes
	}
	$box_options = cmb2_get_metabox('_dci_servizio_box_cosa_ottieni');
	if ($box_options) {
		$box_options->update_field_property('_dci_servizio_output','attributes',array('required' => false));
		$box_options->get_field('_dci_servizio_output',null,true); // activate changes
	}
	$box_options = cmb2_get_metabox('_dci_servizio_box_accedi_servizio');
	if ($box_options) {
		$box_options->update_field_property('_dci_servizio_procedure_collegate','attributes',array('required' => false));
		$box_options->get_field('_dci_servizio_procedure_collegate',null,true); // activate changes
	}
	$box_options = cmb2_get_metabox('_dci_servizio_box_condizioni_servizio');
	if ($box_options) {
		$box_options->update_field_property('_dci_servizio_condizioni_servizio','attributes',array('required' => false));
		$box_options->get_field('_dci_servizio_condizioni_servizio',null,true); // activate changes
	}
	$box_options = cmb2_get_metabox('_dci_servizio_box_contatti');
	if ($box_options) {
		$box_options->update_field_property('_dci_servizio_punti_contatto','attributes',array('required' => false, 'placeholder'=>'Seleziona i Punti di Contatto'));
		$box_options->get_field('_dci_servizio_punti_contatto',null,true); // activate changes
		$box_options->update_field_property('_dci_servizio_unita_responsabile','attributes',array('required' => false, 'placeholder'=>'Seleziona le Unità Organizzative'));
		$box_options->get_field('_dci_servizio_unita_responsabile',null,true); // activate changes
	}
	$box_options = cmb2_get_metabox('_dci_servizio_box_events');
	#die('<pre>'.print_r($box_options,true).'</pre>');
	if ($box_options) {
		$box_options->set_prop('title','Eventi collegati');
		$box_options->update_field_property('_dci_servizio_life_events','name','Eventi della vita delle Persone');
		$box_options->get_field('_dci_servizio_life_events',null,true); // activate changes
		$box_options->update_field_property('_dci_servizio_business_events','name','Eventi della vita delle Imprese');
		$box_options->get_field('_dci_servizio_business_events',null,true); // activate changes
	}
	
	# Unità Organizzative #
	$box_options = cmb2_get_metabox('_dci_unita_organizzativa_box_cosa_fa');
	if ($box_options) {
		$box_options->update_field_property('_dci_unita_organizzativa_competenze','attributes',array('required' => false));
		$box_options->get_field('_dci_unita_organizzativa_competenze',null,true); // activate changes
	}
	$box_options = cmb2_get_metabox('_dci_unita_organizzativa_box_struttura');
	#print('<div style="margin-left: 200px;"><h1>$box_options:</h1><pre>'.print_r($box_options,true).'</pre></div>');
	if ($box_options) {
		$box_options->update_field_property('_dci_unita_organizzativa_tipo_organizzazione','type','taxonomy_multicheck_hierarchical'); // RADIO -> CHECKBOXES
		$box_options->update_field_property('_dci_unita_organizzativa_tipo_organizzazione','attributes',array('required' => false));
		$box_options->get_field('_dci_unita_organizzativa_tipo_organizzazione',null,true); // activate changes
	}
	$box_options = cmb2_get_metabox('_dci_unita_organizzativa_box_persone');
	if ($box_options) {
		$box_options->update_field_property('_dci_unita_organizzativa_persone_struttura','attributes',array('required' => false,'placeholder'=>'Seleziona le Persone Pubbliche'));
		$box_options->get_field('_dci_unita_organizzativa_persone_struttura',null,true); // activate changes
	}
	$box_options = cmb2_get_metabox('_dci_unita_organizzativa_box_contatti');
	if ($box_options) {
		$box_options->update_field_property('_dci_unita_organizzativa_sede_principale','attributes',array('required' => false,'placeholder'=>'Seleziona il Luogo'));
		$box_options->get_field('_dci_unita_organizzativa_sede_principale',null,true); // activate changes
		$box_options->update_field_property('_dci_unita_organizzativa_contatti','attributes',array('required' => false,'placeholder'=>'Seleziona i Punti di Contatto'));
		$box_options->get_field('_dci_unita_organizzativa_contatti',null,true); // activate changes
		
		$box_options->add_field( array(
			'id' => '_dci_unita_organizzativa_altri_contatti',
			'name' => 'Altre informazioni di contatto',
			#'desc' => __( 'Massimo 140 caratteri' , 'design_comuni_italia' ),
			'type' => 'wysiwyg',
			'attributes'    => array(),
			'options' => array(
			    'media_buttons' => false, // show insert/upload button(s)
			    'textarea_rows' => 10, // rows="..."
			    'teeny' => false, // output the minimal editor config used in Press This
			),
		) );	
	}
	
	# Documenti pubblici #
	$box_options = cmb2_get_metabox('_dci_documento_pubblico_box_events');
	#die('<pre>'.print_r($box_options,true).'</pre>');
	if ($box_options) {
		$box_options->set_prop('title','Eventi collegati');
		$box_options->update_field_property('_dci_documento_pubblico_life_events','name','Eventi della vita delle Persone');
		$box_options->get_field('_dci_documento_pubblico_life_events',null,true); // activate changes
		$box_options->update_field_property('_dci_documento_pubblico_business_events','name','Eventi della vita delle Imprese');
		$box_options->get_field('_dci_documento_pubblico_business_events',null,true); // activate changes
	}

	# Documenti privati #
	$box_options = cmb2_get_metabox('_dci_documento_privato_box_events');
	#die('<pre>'.print_r($box_options,true).'</pre>');
	if ($box_options) {
		$box_options->set_prop('title','Eventi collegati');
		$box_options->update_field_property('_dci_documento_privato_life_events','name','Eventi della vita delle Persone');
		$box_options->get_field('_dci_documento_privato_life_events',null,true); // activate changes
		$box_options->update_field_property('_dci_documento_privato_business_events','name','Eventi della vita delle Imprese');
		$box_options->get_field('_dci_documento_privato_business_events',null,true); // activate changes
	}
}


/***********************************/

require get_theme_file_path() . '/inc/breadcrumb.php';
require get_theme_file_path() . '/inc/cpt_attuazione_pnrr.php';

// --- Widget Nowtice WidgetID 1038 (Regola SRL, Comune di Lavagna) ---
// Struttura JSON verificata in data 05/06/2026 sulla risposta reale dell'endpoint.
// Risposta JSONP: (...json...); — stripped dal regex sotto.
// Campi reali: Alerts[], Title, ID, LevelDescription, LevelColor,
//              UserSentTimestamp (ms), ExpiryDate (ms), BaseAlertUrl.
// Filtra solo allerte meteo/protezione civile — esclude Viabilità e Informazioni generiche.

function dci_child_nowtice_alert() {
    $cache_key = 'nowtice_alert_lavagna';
    $cached    = get_transient( $cache_key );
    if ( $cached !== false ) {
        return ( $cached === 'none' ) ? null : $cached;
    }

    $response = wp_remote_get(
        'https://publicalerts.nowtice.it/tenant/alertsjson?WidgetID=1038&Count=5',
        [ 'timeout' => 8 ]
    );

    if ( is_wp_error( $response ) ) {
        set_transient( $cache_key, 'none', 30 * MINUTE_IN_SECONDS );
        return null;
    }

    $body = wp_remote_retrieve_body( $response );

    // Strip wrapper JSONP: (...); → {...}
    if ( preg_match( '/^\s*\(\s*([\s\S]+)\s*\)\s*;?\s*$/', $body, $m ) ) {
        $body = $m[1];
    }

    $data = json_decode( $body, true );
    if ( ! isset( $data['Alerts'] ) || empty( $data['Alerts'] ) ) {
        set_transient( $cache_key, 'none', 30 * MINUTE_IN_SECONDS );
        return null;
    }

    $base_url = $data['BaseAlertUrl'] ?? 'https://publicalerts.nowtice.it/Alert/Details/';
    $now      = time();

    // Cerca il primo alert di protezione civile / allerta meteo attivo
    $alert = null;
    foreach ( $data['Alerts'] as $candidate ) {
        // Filtra per categoria: solo "Protezione Civile" (nome confermato da Comune di Lavagna)
        $categories = $candidate['Categories'] ?? [];
        $is_allerta = false;
        foreach ( $categories as $cat ) {
            $desc = mb_strtolower( $cat['Description'] ?? '' );
            if ( str_contains( $desc, 'protezione civile' ) ) {
                $is_allerta = true;
                break;
            }
        }
        // Fallback: controlla il titolo
        if ( ! $is_allerta ) {
            $title_check = mb_strtolower( $candidate['Title'] ?? '' );
            if ( str_contains( $title_check, 'allerta' ) || str_contains( $title_check, 'protezione civile' ) ) {
                $is_allerta = true;
            }
        }
        if ( ! $is_allerta ) continue;

        // Controlla scadenza (ExpiryDate in millisecondi)
        $exp_ts = isset( $candidate['ExpiryDate'] ) ? intval( $candidate['ExpiryDate'] ) / 1000 : null;
        if ( $exp_ts && $now > $exp_ts ) continue;

        $alert = $candidate;
        break;
    }

    if ( ! $alert ) {
        set_transient( $cache_key, 'none', 30 * MINUTE_IN_SECONDS );
        return null;
    }

    // Campi dell'alert
    $title   = $alert['Title'] ?? '';
    $pub_ts  = isset( $alert['UserSentTimestamp'] ) ? intval( $alert['UserSentTimestamp'] ) / 1000 : null;
    $end_ts  = isset( $alert['ExpiryDate'] )        ? intval( $alert['ExpiryDate'] ) / 1000        : null;
    $alert_id = $alert['ID'] ?? '';
    $permalink = $alert_id ? esc_url( $base_url . $alert_id ) : '';

    // Fallback scadenza: 48h dalla pubblicazione
    if ( ! $end_ts && $pub_ts && ( $now - $pub_ts ) > 48 * HOUR_IN_SECONDS ) {
        set_transient( $cache_key, 'none', 30 * MINUTE_IN_SECONDS );
        return null;
    }

    // Colore: usa LevelColor dell'API, mappa su yellow/orange/red
    $level_color = mb_strtolower( $alert['LevelColor'] ?? '' );
    $level_desc  = mb_strtolower( $alert['LevelDescription'] ?? '' );
    $title_lower = mb_strtolower( $title );

    if ( str_contains( $level_color, 'f00' ) || str_contains( $level_color, 'ff0000' ) ||
         str_contains( $level_desc,  'rossa' ) || str_contains( $level_desc, 'elevata' ) ||
         str_contains( $title_lower, 'rossa' ) || str_contains( $title_lower, 'elevata' ) ) {
        $color = 'red';
    } elseif ( str_contains( $level_color, 'f70' ) || str_contains( $level_color, 'ff7' ) || str_contains( $level_color, 'f60' ) ||
               str_contains( $level_desc,  'arancione' ) || str_contains( $level_desc, 'moderata' ) ||
               str_contains( $title_lower, 'arancione' ) || str_contains( $title_lower, 'moderata' ) ) {
        $color = 'orange';
    } else {
        $color = 'yellow';
    }

    // Testo banner
    $clean_title = trim( preg_replace( '/^COMUNE DI LAVAGNA:\s*/i', '', wp_strip_all_tags( $title ) ) );
    $pub_fmt     = $pub_ts ? date_i18n( 'd/m/Y \a\l\l\e H:i', $pub_ts ) : '';
    $end_fmt     = $end_ts ? date_i18n( 'd/m/Y \a\l\l\e H:i', $end_ts ) : '';

    $testo = '<strong><span class="visually-hidden">Allerta meteo: </span>' . esc_html( $clean_title ) . '</strong>';
    if ( $pub_fmt ) {
        $testo .= '<br><small style="font-weight:normal">Pubblicato: ' . esc_html( $pub_fmt ) . '</small>';
    }
    if ( $end_fmt ) {
        $testo .= ' <small style="font-weight:normal">– Scadenza: ' . esc_html( $end_fmt ) . '</small>';
    }

    $result = [
        'testo_message'  => $testo,
        'data_message'   => '',
        'colore_message' => $color,
        'icona_message'  => '1',
        'link_message'   => $permalink,
    ];

    set_transient( $cache_key, $result, 30 * MINUTE_IN_SECONDS );
    return $result;
}

// --- TinyMCE: pulsante Accordion Bootstrap Italia ---

add_filter( 'mce_external_plugins', 'dci_child_mce_plugins' );
function dci_child_mce_plugins( $plugins ) {
    $plugins['accordion_bi'] = get_stylesheet_directory_uri() . '/assets/js/tinymce-accordion.js';
    return $plugins;
}

add_filter( 'mce_buttons', 'dci_child_mce_buttons' );
function dci_child_mce_buttons( $buttons ) {
    $buttons[] = 'accordion_bi';
    return $buttons;
}

// --- Consente attributi data-bs-* nei contenuti salvati ---

add_filter( 'wp_kses_allowed_html', 'dci_child_allow_bootstrap_attrs', 10, 2 );
function dci_child_allow_bootstrap_attrs( $allowed, $context ) {
    if ( $context !== 'post' ) return $allowed;
    $bs_attrs = [
        'data-bs-toggle'  => true,
        'data-bs-target'  => true,
        'data-bs-parent'  => true,
        'data-bs-dismiss' => true,
        'aria-expanded'   => true,
        'aria-controls'   => true,
    ];
    foreach ( [ 'div', 'button', 'a', 'span', 'h2', 'h3', 'h4' ] as $tag ) {
        if ( isset( $allowed[ $tag ] ) ) {
            $allowed[ $tag ] = array_merge( $allowed[ $tag ], $bs_attrs );
        }
    }
    return $allowed;
}

# load more posts in ajax calls

require get_theme_file_path() . '/inc/load_more_child.php';


/*** INVIA MAIL QUANDO SALVA APPUNTAMENTO ***/

require get_theme_file_path() . '/inc/send_appuntamento.php';
require get_theme_file_path() . '/inc/save_appuntamento.php';


/**********************************/

/*

 ### creazione capabilities utente editor ###

add_action( 'init', 'createEditorCapabilities' );

function createEditorCapabilities() {

	$editors = get_role( 'editor' );

	if ( ! ( $editors->has_cap( 'ratings' ) ) ) { // ne testo una per verifica (non sto a ricrearle ogni volta se l'ho gia' fatto)
	
	    $custom_types = dci_get_tipologie_capabilities(); //nomi plurali dei custom post type
	    $custom_types [] = 'ratings'; //aggiungo capability post type sistema di valutazione
	    $custom_types [] = 'richieste_assistenza'; //aggiungo capability post type richiesta assistenza

	    $caps = array("edit_","edit_others_","publish_","read_private_","delete_","delete_private_","delete_published_","delete_others_","edit_private_","edit_published_");
	    foreach ($custom_types as $custom_type){
		foreach ($caps as $cap){
		    $editors->add_cap( $cap.$custom_type);
		}
	    }
	    $custom_tax = dci_get_tassonomie_names(); //array contenente i nomi delle tassonomie custom
	    $custom_tax [] = 'stars'; //aggiungo tassonomia sistema di valutazione
	    $custom_tax [] = 'page_urls'; //aggiungo tassonomia sistema di valutazione

	    $caps_terms = array("manage_","edit_","delete_","assign_");
	    foreach ($custom_tax as $ctax){
		foreach ($caps_terms as $cap){
		    $editors->add_cap( $cap.$ctax);
		}
	    }
	}
}

*/

/**********************************/


