<?php

/*** to be loaded into functions.php ***/

/*** INVIA MAIL QUANDO SALVA APPUNTAMENTO ***/

// copiata da (main theme) inc/funzionalita_trasversali.php, function dci_save_appuntamento

add_action("wp_ajax_save_appuntamento" , "dci_send_appuntamento");
add_action("wp_ajax_nopriv_save_appuntamento" , "dci_send_appuntamento");

function dci_send_appuntamento(){
	
	$eol = "\r\n";
	
	$params = json_decode(json_encode($_POST), true);

	date_default_timezone_set('Europe/Rome');
	
	$email = '';
	if ( array_key_exists("email", $params) && $params['email'] != 'null' ) {
		$email = trim($params['email']);
	}
	
	$subject = 'Prenotazione appuntamento dal sito';
	$message = '';
	$headers = '';
	$attachments = array();

	$admin_mails = array( 'appuntamenti@comune.lavagna.ge.it' ); // generica, poi aggiungo quelle dei punti di contatto
	
	$message .= 'Richiesta di prenotazione appuntamento'.$eol;
	$message .= $eol;
	if ( array_key_exists('office', $params) && $params['office'] != 'null' ) {
		$obj = json_decode(stripslashes($params['office']), true);
		$message .= 'Ufficio: '.$obj['name'].$eol;
		
		if ( intval($obj['id']) == 369 ) {
			$admin_mails[] = 'appuntamenti.ediliziaprivata@comune.lavagna.ge.it';
		}
		
		// get extra mails from office:
		// punti di contatto dell'ufficio:
		$pdcList = get_post_meta( intval($obj['id']), '_dci_unita_organizzativa_contatti' ); // array of values
		if ( ( $pdcList !== false ) && ( count( $pdcList ) > 0 ) ) {
			foreach ( $pdcList as $pdcArr ) {
				if ( ( $pdcArr !== false ) && ( count( $pdcArr ) > 0 ) ) {
					foreach ( $pdcArr as $pdc ) {
						$vociList = get_post_meta( intval($pdc), '_dci_punto_contatto_voci' ); // array of values
						foreach ( $vociList as $vociArr ) {
							if ( ( $vociArr !== false ) && ( count( $vociArr ) > 0 ) ) {
								foreach ( $vociArr as $voce ) {
									if ( $voce['_dci_punto_contatto_tipo_punto_contatto'] == 'email' ) {
										$voceEmail = trim($voce['_dci_punto_contatto_valore']);
											if ( ( $voceEmail != '' ) && ( !in_array( $voceEmail, $admin_mails ) ) ) {
												$admin_mails[] = $voceEmail;
											}
										}
								}
							}
						}
					}
				}
			}
		}
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
	
	if (strlen($message)>0) {
		
		$message_to_user = $message;
		$message_to_user .= $eol;
		#$message_to_user .= 'Questa è solo la prenotazione della vostra richiesta. L\'appuntamento vi verrè definitivamente confermato dai nostri uffici tramite le informazioni contatto che avete indicato.'.$eol;
		
		// mail to user:
		if ( is_email($email) ) { // send to user
			wp_mail( $email, $subject, $message_to_user, $headers, $attachments );
			wp_mail( 'lavagna@exec.it', $subject.' [copia per '.$email.']', $message_to_admin, $headers, $attachments );
		}
		
		// mail to admin:
		if ( is_email($email) ) {
			$headers .= 'Reply-To: '.$email.$eol;
		}
		$message_to_admin = $message;
		$message_to_admin .= $eol;
		#$message_to_admin .= 'La prenotazione deve essere confermata ai contatti sopra indicati (email e/o eventuale recapito telefonico)'.$eol;
		
		foreach ( $admin_mails as $extra_mail ) {
			wp_mail( $extra_mail, $subject, $message_to_admin, $headers, $attachments );
			wp_mail( 'lavagna@exec.it', $subject.' [copia per '.$extra_mail.']', $message_to_admin, $headers, $attachments );
		}
	}
}
