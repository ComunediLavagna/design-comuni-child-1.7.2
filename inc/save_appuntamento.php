<?php

/**
 * crea contenuto di tipo Appuntamento. il DIE in fondo impedisce che venga lanciata la corrispondente funzione nel tema parent.
 */
function dci_save_appuntamento_child(){

    $params = json_decode(json_encode($_POST), true);

    date_default_timezone_set('Europe/Rome');
    $data = date('Y-m-d\TH:i:s');

    if(array_key_exists("name", $params) && array_key_exists("email", $params) &&  array_key_exists("surname", $params) && array_key_exists("moreDetails", $params) && array_key_exists("service", $params)  && array_key_exists("office", $params) ) {

        $appuntamento_title = $params['surname'].' '.$params['name'].'';

        $postId = wp_insert_post(array(
            'post_type' => 'appuntamento',
            'post_title' =>  $appuntamento_title
        ));
    }

    if($postId == 0) {
        echo json_encode(array(
            "success" => false,
            "error" => array(
                "code" =>  400,
                "message" => "Oops, qualcosa è andato storto!"
            )));
        wp_die();
    }

    update_post_meta($postId, '_dci_appuntamento_data_ora_prenotazione',  $data);

    if(array_key_exists("email", $params) && $params['email'] != "null") {
        update_post_meta($postId, '_dci_appuntamento_email_richiedente',  $params['email']);
    }
    
/*** Stesso testo della mail ***/

	$eol = "\r\n";

	$message = '';

	$message .= 'Richiesta di prenotazione appuntamento'.$eol;
	$message .= $eol;
	if ( array_key_exists('office', $params) && $params['office'] != 'null' ) {
		$obj = json_decode(stripslashes($params['office']), true);
		$message .= 'Ufficio: '.$obj['name'].$eol;
	}
	if ( array_key_exists('place', $params) && $params['place'] != 'null' ) {
		$obj = json_decode(stripslashes($params['place']), true);
		$message .= 'Sede: '.$obj['nome'].' - '.$obj['indirizzo'].$eol;
	}
	$message .= $eol;
	if ( array_key_exists('appointment', $params) && $params['appointment'] != 'null' ) {
		$obj = json_decode(stripslashes($params['appointment']), true);
		$dataapp = substr($obj['startDate'],8,2).'/'.substr($obj['startDate'],5,2).'/'.substr($obj['startDate'],0,4);
		$orainizio = substr($obj['startDate'],11,5);
		$orafine = substr($obj['endDate'],11,5);
		#$message .= 'Appuntamento: '.$dataapp.' dalle '.$orainizio.' alle '.$orafine.$eol;
		$message .= 'Appuntamento: '.$dataapp.' alle ore '.$orainizio.$eol;
	}
	$message .= $eol;
	if ( array_key_exists('name', $params) && $params['name'] != 'null' ) {
		$message .= 'Nome: '.$params['name'].$eol;
	}
	if ( array_key_exists('surname', $params) && $params['surname'] != 'null' ) {
		$message .= 'Cognome: '.$params['surname'].$eol;
	}
	if ( array_key_exists('email', $params) && $params['email'] != 'null' ) {
		$message .= 'Email: '.$params['email'].$eol;
	}
	if ( array_key_exists('phone', $params) && $params['phone'] != 'null' ) {
		$message .= 'Telefono: '.$params['phone'].$eol;
	}
	$message .= $eol;
	if ( array_key_exists('service', $params) && $params['service'] != 'null' ) {
		$obj = json_decode(stripslashes($params['service']), true);
		$message .= 'Servizio richiesto: '.$obj['name'].$eol;
	}
	$message .= $eol;
	if ( array_key_exists('moreDetails', $params) && $params['moreDetails'] != 'null' ) {
		$message .= 'Altre informazioni fornite dall\'utente:'.$eol.$params['moreDetails'].$eol;
	}
	$message .= $eol;
	$message .= 'Data e ora della richiesta: '.date('d/m/Y H:i').$eol;
	$message .= $eol;
        
	update_post_meta($postId, '_dci_appuntamento_dettaglio_richiesta',  $message);

    if(array_key_exists("service", $params) && $params['service'] != "null") {
        $service_obj = json_decode(stripslashes($params['service']), true);
        //$service_id = $service_obj['id'];
        update_post_meta($postId, '_dci_appuntamento_servizio',$service_obj['name']);
    }

    if(array_key_exists("office", $params) && $params['office'] != "null") {
        $office_obj = json_decode(stripslashes($params['office']), true);
        //$office_id = $office_obj['id'];
        update_post_meta($postId, '_dci_appuntamento_unita_organizzativa', $office_obj['name']);
    }

    if(array_key_exists("appointment", $params) && $params['appointment'] != "null") {

        $appointment_obj = json_decode(stripslashes($params['appointment']), true);
        $startDate = $appointment_obj['startDate'];
        $endDate = $appointment_obj['endDate'];

        update_post_meta($postId, '_dci_appuntamento_data_ora_inizio_appuntamento',  $startDate);
        update_post_meta($postId, '_dci_appuntamento_data_ora_fine_appuntamento',  $endDate);
    }

    echo json_encode(array(
        "success" => true,
        "message" => 'Contenuto creato con successo: '.$postId,
        "appuntamento" => array(
            "id" => $postId),
        "title" => $appuntamento_title
    ));
    wp_die();
}
add_action("wp_ajax_save_appuntamento" , "dci_save_appuntamento_child");
add_action("wp_ajax_nopriv_save_appuntamento" , "dci_save_appuntamento_child");
