<?php

// deve sostituire il file: wp-content/themes/design-comuni-wordpress-theme-child/tempate-parts/prenotazione/content.php

$tutti_uffici = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'unita_organizzativa',
		// filtro solo le UO di tipo ufficio: altrimenti ci mette anche aree e servizi amministrativi
		'tax_query' => array(
		array(
			'taxonomy' => 'tipi_unita_organizzativa',
			'field' => 'term_id',
			'terms' => '235', // "ufficio"
		),
	),
	'include' => ( isset($_GET['uo_id']) ? array(intval($_GET['uo_id'])) : array() ) // questo devo includerlo se voglio indicare in GET una UO specifica
));
$uffici = array();
// solo se l'ufficio ha una sede ed offre effettivamente sei servizi; 
// altrimenti se non c'è almeno un servizio l'iter di prenotazione si blocca, essendo questa una informazione richiesta obbligatoria,
// e invece se non è impostata la sede, presenta nel form tutti i luoghi possibili (!)
foreach ($tutti_uffici as $ufficio) {
	if (
		( get_post_meta($ufficio->ID,'_dci_unita_organizzativa_elenco_servizi_offerti',true) != '' )
		and (
			( get_post_meta($ufficio->ID,'_dci_unita_organizzativa_sede_principale',true) != '' )
			or
			( get_post_meta($ufficio->ID,'_dci_unita_organizzativa_altre_sedi',true) != '' )
		)
	) {
	$uffici[] = $ufficio;
	}
}
    
    $months = array();
    $currentMonth = intval(date('m'));
	
	$available_months = intval( get_option( 'sts_dci_available_months', 1 ) );
	if ( $available_months < 0 ) $available_months = 0;
	if ( $available_months > 12 ) $available_months = 12;

   // for ($i=0; $i < 12; $i++) {
    for ($i=0; $i <= $available_months; $i++) { // solo per i prox mesi
        array_push($months, $currentMonth);
        if($currentMonth >= 12) $currentMonth = 0;
        $currentMonth++;
    }
?>

<div class="it-page-sections-container">

    <!-- Step 1 -->
    <section class="firstStep page-step active it-page-section" data-steps="1">
        <div class="cmp-card mb-40" id="office">
            <div class="card has-bkg-grey shadow-sm p-big">
                <div class="card-header border-0 p-0 mb-lg-30">
                    <div class="d-flex">
                        <h2 class="title-xxlarge mb-0">Ufficio*</h2>
                    </div>
                    <p class="subtitle-small mb-0">
                        Scegli l’ufficio a cui vuoi richiedere l’appuntamento
                    </p>
                </div>
                <div class="card-body p-0">
                    <div class="select-wrapper p-0 select-partials">
                        <label for="office-choice" class="visually-hidden">
                            Tipo di ufficio
                        </label>
                        <select id="office-choice" class="" autocomplete="off">
                            <option selected="selected" value="">
                                Seleziona opzione
                            </option>
                            <?php foreach ($uffici as $ufficio) {
				echo '<option value="'.$ufficio->ID.'">'.$ufficio->post_title.'</option>';
                            } ?>
                        </select>
                    </div>
                    <fieldset id="place-cards-wrapper"></fieldset>
                </div>
            </div>
        </div>
    </section>

    <!-- Step 2 -->
    <section class="d-none page-step it-page-section" data-steps="2">
        <div class="cmp-card mb-40" id="appointment-available" >
            <div class="card has-bkg-grey shadow-sm p-big">
                <div class="card-header border-0 p-0 mb-lg-30">
                    <div class="d-flex">
                    <h2 class="title-xxlarge mb-2">
                        Appuntamenti disponibili*
                    </h2>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="select-wrapper p-0 mt-1 select-partials">
                        <label for="appointment" class="visually-hidden">
                            Seleziona un mese
                        </label>
                        <select id="appointment" class="" autocomplete="off">
                            <option selected="selected" value="">
                                Seleziona un mese
                            </option>
                            <?php foreach ($months as $month) {
                                echo '<option value="'.$month.'">'.date_i18n('F', mktime(0, 0, 0, $month, 10)).'</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="cmp-card-radio-list mt-4">
                        <div class="card p-3">
                            <div class="card-body p-0">
                                <div class="form-check m-0" >
                                    <fieldset id="radio-appointment" style="overflow: hidden;">
                                        Nessun appuntamento disponibile.
                                    </fieldset>
				    <button id="radio-appointment-toggler" class="btn btn-outline-primary" style="float: right; background-color: #F0F8FF;">VEDI ALTRI</button>
					<script>
					<!--
					$('#radio-appointment-toggler').hide();
					$('#radio-appointment-toggler').on('click', function() {
						$('#radio-appointment').css('height','auto'); 
						$('#radio-appointment-toggler').hide();
					});
					-->
					</script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cmp-card mb-40" id="office-2">
            <div class="card has-bkg-grey shadow-sm p-big" >
                <div class="card-header border-0 p-0 mb-lg-30">
                    <div class="d-flex">
                        <h2 class="title-xxlarge mb-0">Ufficio</h2>
                    </div>
                </div>
                <div class="card-body m-0 p-0" id="selected-office-card"></div>
               <div class="card-body m-0 p-0"><p style="margin: -1.5em 1.5em 0; font-style: italic;">Presso</p></div>
               <div class="card-body p-0" id="selected-place-card"></div>
            </div>
        </div>
    </section>

    <!-- Step 3 -->
    <section class="d-none page-step it-page-section" data-steps="3">
        <div class="cmp-card mb-40" id="reason">
            <div class="card has-bkg-grey shadow-sm p-big">
                <div class="card-header border-0 p-0 mb-lg-30 mb-3">
                    <div class="d-flex">
                        <h2 class="title-xxlarge mb-0" >Motivo*</h2>
                    </div>
                    <p class="subtitle-small mb-0">
                        Scegli il servizio richiesto
                    </p>
                </div>
                <div class="card-body p-0">
                    <div class="select-wrapper p-0 select-partials">
                        <label for="motivo-appuntamento" class="visually-hidden">
                            Motivo dell&#x27;appuntamento
                        </label>
                        <select id="motivo-appuntamento" class="" autocomplete="off"></select>
                    </div>
                </div>
            </div>
        </div>

        <div class="cmp-card mb-40" id="details">
            <div class="card has-bkg-grey shadow-sm p-big">
                <div class="card-header border-0 p-0 mb-lg-30 m-0">
                    <div class="d-flex">
                        <h2 class="title-xxlarge mb-0" >
                            Dettagli*
                        </h2>
                    </div>
                    <p class="subtitle-small mb-0 mb-3">
                        Aggiungi ulteriori dettagli sul motivo dell'appuntamento
                    </p>
                </div>
                <div class="card-body p-0">
                    <div class="cmp-text-area p-0">
                        <div class="form-group">
                            <label for="form-details" class="visually-hidden">
                                Aggiungi ulteriori dettagli
                            </label>
                            <textarea
                                class="text-area"
                                id="form-details"
                                rows="2"
				autocomplete="off"
                            ></textarea>
                            <span class="label">
                                Inserire massimo 200 caratteri
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Step 4 -->
    <section class="d-none page-step it-page-section" data-steps="4">
        <?php /*
	<p class="subtitle-small pb-40 mb-0 d-lg-none">
            Hai un’identità digitale SPID o CIE?
            <a class="title-small-semi-bold t-primary underline"
                href="./iscrizione-graduatoria-accedere-servizio.html"
            >
                Accedi
            </a>
        </p>
	*/ ?>
        <div class="cmp-card" id="applicant">
            <div class="card has-bkg-grey shadow-sm p-big">
                <div class="card-header border-0 p-0 mb-lg-30 m-0">
                    <div class="d-flex">
                        <h2 class="title-xxlarge mb-3" >
                            Richiedente
                        </h2>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="form-wrapper bg-white p-4">
                        <div class="form-group cmp-input mb-0">
                            <label class="cmp-input__label" for="name">
                                Nome*
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
				autocomplete="given-name"
                                required
                            />
                            <div class="d-flex">
                                <span class="form-text cmp-input__text">
                                    Inserisci il tuo nome
                                </span>
                            </div>
                        </div>

                        <div class="form-group cmp-input mb-0">
                            <label class="cmp-input__label" for="surname">
                                Cognome*
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="surname"
                                name="surname"
				autocomplete="family-name"
                                required
                            />
                            <div class="d-flex">
                                <span class="form-text cmp-input__text">
                                    Inserisci il tuo cognome
                                </span>
                            </div>
                        </div>

                        <div class="form-group cmp-input mb-0">
                            <label class="cmp-input__label" for="email">
                                Email*
                            </label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
				autocomplete="email"
                                required
                            />
                            <div class="d-flex">
                                <span class="form-text cmp-input__text">
                                    Inserisci la tua email
                                </span>
                            </div>

                        <div class="form-group cmp-input mb-0">
                            <label class="cmp-input__label" for="phone">
                                Telefono*
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="phone"
                                name="phone"
				autocomplete="phone"
                                required
                            />
                            <div class="d-flex">
                                <span class="form-text cmp-input__text">
                                    Inserisci il tuo numero di telefono
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Step 5 -->
    <section class="d-none page-step it-page-section" data-steps="5">
        <div class="mt-2">
            <h2 class="visually-hidden">Dettagli dell'appuntamento</h2>
            <div class="cmp-card mb-4">
                <div class="card has-bkg-grey shadow-sm mb-0">
                    <div class="card-header border-0 p-0 mb-lg-30">
                        <div class="d-flex">
                            <h3 class="subtitle-large mb-0">Riepilogo</h3>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="cmp-info-summary bg-white mb-3 mb-lg-4 p-3 p-lg-4">
                            <div class="card">
                                <div class="card-header border-bottom border-light p-0 mb-0 d-flex justify-content-between d-flex justify-content-end">
                                    <h4 class="title-large-semi-bold mb-3">
                                        Ufficio
                                    </h4>
                                    <a
                                        href="#"
                                        class="text-decoration-none"
                                        title="Modifica Ufficio"
                                        aria-label="Modifica Ufficio"
                                    >
                                        <span class="text-button-sm-semi t-primary">
                                            Modifica
                                        </span>
                                    </a>
                                </div>

                                <div class="card-body p-0">
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">
                                        Tipologia ufficio
                                    </div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-office"></p>
                                    </div>
                                    </div>
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">
                                        Municipalità
                                    </div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-place"></p>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer p-0"></div>
                            </div>
                        </div>
                        <div class="cmp-info-summary bg-white mb-3 mb-lg-4 p-3 p-lg-4">
                            <div class="card">
                                <div class="card-header border-bottom border-light p-0 mb-0 d-flex justify-content-between d-flex justify-content-end">
                                    <h4 class="title-large-semi-bold mb-3">
                                        Data e orario
                                    </h4>
                                    <a
                                        href="#"
                                        class="text-decoration-none"
                                        title="Modifica Data e orario"
                                        aria-label="Modifica Data e orario"
                                    >
                                        <span class="text-button-sm-semi t-primary">
                                            Modifica
                                        </span>
                                    </a>
                                </div>

                                <div class="card-body p-0">
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">Data</div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-date"></p>
                                    </div>
                                    </div>
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">Ora</div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-hour"></p>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer p-0"></div>
                            </div>
                        </div>
                        <div class="cmp-info-summary bg-white mb-3 mb-lg-4 p-3 p-lg-4">
                            <div class="card">
                                <div class="card-header border-bottom border-light p-0 mb-0 d-flex justify-content-between d-flex justify-content-end">
                                    <h4 class="title-large-semi-bold mb-3">
                                        Dettagli appuntamento
                                    </h4>
                                    <a
                                        href="#"
                                        class="text-decoration-none"
                                        title="Modifica Dettagli appuntamento"
                                        aria-label="Modifica Dettagli appuntamento"
                                    >
                                        <span class="text-button-sm-semi t-primary">
                                            Modifica
                                        </span>
                                    </a
                                    >
                                </div>

                                <div class="card-body p-0">
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">Motivo</div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-service"></p>
                                    </div>
                                    </div>
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">Dettagli</div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-details"></p>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer p-0"></div>
                            </div>
                        </div>
                        <div class="cmp-info-summary bg-white p-3 p-lg-4 mb-0">
                            <div class="card">
                                <div class="card-header border-bottom border-light p-0 mb-0 d-flex justify-content-between d-flex justify-content-end">
                                    <h4 class="title-large-semi-bold mb-3">
                                        Richiedente
                                    </h4>
                                    <a
                                        href="#"
                                        class="text-decoration-none"
                                        title="Modifica Richiedente"
                                        aria-label="Modifica Richiedente"
                                    >
                                        <span class="text-button-sm-semi t-primary">
                                            Modifica
                                        </span>
                                    </a>
                                </div>

                                <div class="card-body p-0">
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">Nome</div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-name"></p>
                                    </div>
                                    </div>
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">Cognome</div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-surname"></p>
                                    </div>
                                    </div>
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">Email</div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-email"></p>
                                    </div>
                                    <div class="single-line-info border-light">
                                    <div class="text-paragraph-small">Telefono</div>
                                    <div class="border-light">
                                        <p class="data-text" id="review-phone"></p>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer p-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
