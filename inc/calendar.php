<?php

// deve sostituire il file: wp-content/themes/design-comuni-wordpress-theme-child/inc/calendar.php --- produce un json
// modello: wp-content/themes/design-comuni-wordpress-theme-main/assets/json/calendar.json
//	riceve in querystring:
//	$office = intval($_GET['office']);
//	$month = intval($_GET['month']);

$wp_root_dir = dirname( __FILE__ , 5 );

/** Make sure that the WordPress bootstrap has run before continuing. */
require $wp_root_dir . '/wp-load.php';

date_default_timezone_set('Europe/Rome'); // DO NOT REMOVE

// defaults:
$default_holidays = array( // public holidays, mm-dd
	'01-01',
	'01-06',
	'04-25',
	'05-01',
	'06-02',
	'08-15',
	'11-01',
	'12-08',
	'12-25',
	'12-26',
);
$default_nodays = array(); // altri giorni da non proporre

// configuration values:
$available_months = intval( get_option( 'sts_dci_available_months', 1 ) );
if ( $available_months < 0 ) $available_months = 0;
if ( $available_months > 12 ) $available_months = 12;

// orario massimo entro cui è possibile prenotare per il giorno seguente: (in futuro sarà possibile inserirlo in configurazione)
$closing_time = intval( get_option( 'sts_dci_closing_time', 24 ) ); // DOPO L'ASSEVERAZIONE DOVREMO METTERE LE ORE 13 ; ADESSO 24 = DISATTIVATO
if ( $closing_time < 0 ) $closing_time = 0;
if ( $closing_time > 24 ) $closing_time = 24;


// given range:
$office = intval(@$_GET['office']);
#$service = intval(@$_GET['service']); // NON VIENE PASSATO
$month = intval(@$_GET['month']);

if ($month>0) {
	if ($month==date('m')) {
		$firstdate = mktime(0,0,0,$month,date('d')+1,date('Y')); 
		$lastdate = mktime(0,0,0,$month+1,0,date('Y')); 
	} else if ($month>date('m')) {
		$firstdate = mktime(0,0,0,$month,1,date('Y')); 
		$lastdate = mktime(0,0,0,$month+1,0,date('Y')); 
	} else {
		$firstdate = mktime(0,0,0,$month,1,date('Y')+1); 
		$lastdate = mktime(0,0,0,$month+1,0,date('Y')+1); 
	}
} else {
	$firstdate = mktime(0,0,0,date('m'),date('d')+1,date('Y')); 
	#$lastdate = mktime(0,0,0,date('m')+12,0,date('Y')); 
	$lastdate = mktime(0,0,0,date('m')+1+$available_months,0,date('Y')); 
}
if ( date( 'G' ) >= $closing_time ) { // se sono oltre orario massimo, tolgo la data di domani
	$tomorrow = mktime(0,0,0,date('m'),date('d')+1,date('Y')); 
	if ( $firstdate == $tomorrow ) {
		$firstdate = mktime(0,0,0,date('m'),date('d')+2,date('Y')); 
	}
}

$firstday = date('Y-m-d',$firstdate); 
$lastday = date('Y-m-d',$lastdate);

// exclude holidays and other unallowed days
$holidays = get_option( 'sts_dci_holidays', $default_holidays );
$nodays = get_option( 'sts_dci_nodays', $default_nodays );

$forbidden_days = array();
foreach( $holidays as $day ) {
	$forbidden_days[] = date('Y').'-'.$day;
	$forbidden_days[] = (date('Y')+1).'-'.$day;
}
foreach( $nodays as $day ) {
	$forbidden_days[] = date('Y').'-'.$day;
	$forbidden_days[] = (date('Y')+1).'-'.$day;
}
$forbidden_days = array_unique( $forbidden_days );
sort( $forbidden_days ); // superfluo, ma mi piace l'ordine...

// cerco appuntamenti esistenti (draft|publish) per escluderli
$posts = get_posts([
	'post_type' => 'appuntamento',
	'post_status' => array('publish','draft'), // quelli "trash" non li considero
	'numberposts' => -1
]);
$postids = wp_list_pluck( $posts, 'ID' );
#print('Found '.count($posts).' posts:<pre>'.print_r($postids,true).'</pre>');

$appuntamenti = array();
$dtnow = date('Y-m-d\TH:i');
foreach ( $postids as $postid ) {
	#$servizio = get_post_meta( $postid, '_dci_appuntamento_servizio', true ); // non viene passato in GET.
	$ufficio = get_post_meta( $postid, '_dci_appuntamento_unita_organizzativa', true );
	$dtinizio = get_post_meta( $postid, '_dci_appuntamento_data_ora_inizio_appuntamento', true );
	$dtfine = get_post_meta( $postid, '_dci_appuntamento_data_ora_fine_appuntamento', true );
	if ( $dtinizio>=$dtnow or $dtfine>=$dtnow ) {
		$appuntamenti[] = array(
			'ID' => $postid,
			#'servizio' => $servizio, // non viene passato in GET.
			'ufficio' => $ufficio,
			'inizio' => $dtinizio,
			'fine' => $dtfine
		);
	}
}
#print('Found '.count($appuntamenti).' appuntamenti:<pre>'.print_r($appuntamenti,true).'</pre>');

// CONSTRUCT CALENDAR

$dates = array(); // array to return

if ( $office > 0 ) {
	
	$officename = get_the_title( $office );
	#$servicename = get_the_title( $service ); // NON VIENE PASSATO NELLA GET
	
	$office_wdays = get_option( 'sts_dci_office_'.intval($office).'_wdays', array() );
	$wdays = array_keys( $office_wdays );
	#print('<pre>'.print_r($office_wdays,true).'</pre>');
	$thisdate = $firstdate;
	while ($thisdate <= $lastdate) {
		$kmonth = date('n',$thisdate);
		if (!isset($dates[$kmonth])) {
			$dates[$kmonth] = array();
		}
		$thisday = date('Y-m-d',$thisdate);
		if (!in_array($thisday,$forbidden_days)) {
			$wday = date('N',$thisdate);
			if (in_array($wday,$wdays)) {
				$slots = $office_wdays[$wday];
				foreach ($slots as $k=>$slot) {
					$startslot = $slot;
					$endslot = date('H:i',strtotime('2000-01-01T'.$slot.':00')+30*60); // each slot 30 minutes
					if ( $endslot == '00:00' ) $endslot = '24:00';
					$startdate = $thisday.'T'.$startslot;
					$enddate = $thisday.'T'.$endslot;
					$allowed = true;
					foreach ( $appuntamenti as $appuntamento ) {
						/*
						print('Ufficio:'.$officename.'<pre>'.print_r($appuntamento,true).'</pre>');
						print(date('Y-m-d H:i:s', strtotime($appuntamento['inizio'])).'<br>');
						print(date('Y-m-d H:i:s', strtotime($appuntamento['fine'])).'<br>');
						*/
						if (
							(
								$officename == $appuntamento['ufficio'] /* and $servicename == $appuntamento['servizio'] */
							) and (
								/*
								( $startdate >= $appuntamento['inizio'] and $startdate < $appuntamento['fine'] ) 
								or 
								( $enddate > $appuntamento['inizio'] and $enddate <= $appuntamento['fine'] ) 
								*/
								$startdate == $appuntamento['inizio']
							)
						) {
							$allowed = false;
						}
					}
					if ( $allowed ) {
						$dates[$kmonth][] = (object) [
							'startDate' => $startdate,
							'endDate' => $enddate
						];
					}
				}
			}
		}
		$thisdate = $thisdate + 86400;
	}
}
print(json_encode($dates));
