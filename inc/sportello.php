<?php

add_shortcode('sportello_procedure', 'render_sportello_procedure');

function render_sportello_procedure() {
    $base = 'https://sportello.comune.lavagna.ge.it';

    $categorie = array(
        'Ambiente, paesaggio ed ecologia' => array(
            array('nome' => "Chiedere l'autorizzazione all'allaccio alla rete bianca comunale", 'url' => '/action%3Ac_e488%3Aacque.bianche'),
            array('nome' => "Chiedere l'autorizzazione allo scarico fuori fognatura", 'url' => '/action%3Ac_e488%3Afossa.imhoff'),
            array('nome' => "Chiedere l'autorizzazione in deroga ai valori limite di emissione acustica", 'url' => '/action%3As_italia%3Aderoga.limiti.immissione.acustica'),
            array('nome' => "Chiedere l'autorizzazione per l'allaccio alla fognatura comunale", 'url' => '/action%3Ac_e488%3Aallaccio.fognatura.comunale'),
            array('nome' => "Segnalare una presunta violazione di norme in materia ambientale", 'url' => '/action%3As_italia%3Aviolazione.norme.materia.ambientale'),
        ),
        'Servizi demografici' => array(
            array('nome' => "Accedere ai servizi dell'ANPR", 'url' => '/action%3As_italia%3Aaccedere.servizi.anpr'),
            array('nome' => "Adottare", 'url' => '/action%3As_italia%3Aadozione'),
            array('nome' => "Autenticare la sottoscrizione degli atti di vendita di beni mobili registrati", 'url' => '/action%3As_italia%3Aautenticazione%3Bsottoscrizioni%3Bveicoli'),
            array('nome' => "Autenticare le copie di documenti", 'url' => '/action%3As_italia%3Aautenticazione%3Bcopie'),
            array('nome' => "Autenticare le sottoscrizioni su istanze e dichiarazioni sostitutive di atto di notorietà", 'url' => '/action%3As_italia%3Aautenticazione%3Bsottoscrizioni'),
            array('nome' => "Cambiare abitazione", 'url' => '/action%3As_italia%3Acambio.abitazione.residenza%3Babitazione'),
            array('nome' => "Cambiare nome e cognome", 'url' => '/action%3As_italia%3Anome.cognome%3Bcambio.aggiunta'),
            array('nome' => "Cambiare residenza", 'url' => '/action%3As_italia%3Acambio.abitazione.residenza%3Bresidenza'),
            array('nome' => "Chiedere il contrassegno per veicoli a servizio dei disabili", 'url' => '/action%3As_italia%3Aveicoli.disabili%3Bcircolazione.sosta'),
            array('nome' => "Chiedere il divorzio o la separazione", 'url' => '/action%3As_italia%3Adivorzio.separazione'),
            array('nome' => "Chiedere il mutamento della composizione della convivenza", 'url' => '/action%3As_italia%3Aresidenza.convivenza'),
            array('nome' => "Chiedere il rilascio del passaporto", 'url' => '/action%3As_italia%3Apassaporto%3Brilascio'),
            array('nome' => "Chiedere il rilascio della carta d'identità elettronica (CIE)", 'url' => '/action%3As_italia%3Acarta.identita%3Belettronica'),
            array('nome' => "Chiedere il rilascio della tessera elettorale", 'url' => '/action%3As_italia%3Atessera.elettorale'),
            array('nome' => "Chiedere il rilascio di certificati anagrafici", 'url' => '/action%3As_italia%3Acertificati%3Banagrafici'),
            array('nome' => "Chiedere il rilascio di certificati ed estratti di atti di stato civile", 'url' => '/action%3As_italia%3Acertificati%3Bestratti.atti.stato.civile'),
            array('nome' => "Chiedere il rilascio di certificati ed estratti di leva militare", 'url' => '/action%3As_italia%3Acertificati%3Bleva.militare'),
            array('nome' => "Chiedere il rilascio di certificato di iscrizione alle liste elettorali", 'url' => '/action%3As_italia%3Acertificati%3Biscrizione.liste.elettorali'),
            array('nome' => "Chiedere il rilascio di copia integrale di atti di stato civile", 'url' => '/action%3As_italia%3Acertificati%3Bcopia.integrale.atti.stato.civile'),
            array('nome' => "Chiedere il rilascio o l'aggiornamento del libretto internazionale di famiglia", 'url' => '/action%3As_italia%3Alibretto.internazionale.famiglia'),
        ),
        'Servizi sociali' => array(
            array('nome' => "Accedere a case di riposo e residenze sanitarie assistenziali (RSA)", 'url' => '/action%3As_italia%3Aresidenza.sanitaria.assistenziale'),
            array('nome' => "Accedere ai progetti di inclusione sociale", 'url' => '/action%3Ar_liguri%3Aaccedere.progetti.inclusione.sociale'),
            array('nome' => "Accedere al centro diurno disabili (CDD)", 'url' => '/action%3As_italia%3Acentri.diurni.disabili%3Bcentro.diurno'),
            array('nome' => "Accedere al centro socio educativo (CSE)", 'url' => '/action%3As_italia%3Acentri.diurni.disabili%3Bcentro.socio.educativo'),
            array('nome' => "Accedere al fondo regionale per la non autosufficienza (FRNA)", 'url' => '/action%3Ar_liguri%3Aaccedere.fondo.regionale.non.autosufficienza'),
            array('nome' => "Accedere al fondo regionale per le gravissime disabilità", 'url' => '/action%3Ar_liguri%3Afondo.regionale.gravissime.disabilita'),
            array('nome' => "Accedere al servizio di assistenza domiciliare integrata (ADI)", 'url' => '/action%3Ar_liguri%3Aservizio.assistenza.domiciliare.integrata'),
            array('nome' => "Accedere al servizio di trasporto per anziani e disabili", 'url' => '/action%3As_italia%3Atrasporto.anziani.disabili'),
            array('nome' => "Accedere al servizio tutela minori", 'url' => '/action%3As_italia%3Aservizio.integrato.minori.famiglia'),
            array('nome' => "Accedere alla residenza sanitaria disabili (RSD)", 'url' => '/action%3As_italia%3Acentri.diurni.disabili%3Bresidenza.sanitaria.disabili'),
            array('nome' => "Avvalersi di un amministratore di sostegno", 'url' => '/action%3As_italia%3Aamministratore.sostegno%3Bchiedere'),
            array('nome' => "Chiedere il riconoscimento dell'invalidità civile", 'url' => '/action%3As_italia%3Ainvalidita.civile%3Briconoscimento'),
            array('nome' => "Chiedere l'integrazione delle rette dei servizi semi residenziali", 'url' => '/action%3As_italia%3Aintegrazione.rette.ricovero%3Bservizi.semi.residenziali'),
            array('nome' => "Chiedere l'integrazione delle rette dei servizi residenziali", 'url' => '/action%3As_italia%3Aintegrazione.rette.ricovero%3Bservizi.residenziali'),
            array('nome' => "Chiedere la concessione del bonus acqua o bonus idrico", 'url' => '/action%3As_italia%3Abonus.acqua.idrico'),
            array('nome' => "Chiedere la concessione del bonus elettrico", 'url' => '/action%3As_italia%3Abonus.energia'),
            array('nome' => "Chiedere la concessione del bonus gas", 'url' => '/action%3As_italia%3Abonus.gas'),
            array('nome' => "Chiedere la concessione del contributo regionale per la rimozione di barriere architettoniche", 'url' => '/action%3Ar_liguri%3Abarriere.architettoniche%3Bcontributo.rimozione'),
            array('nome' => "Chiedere la concessione dell'assegno di maternità dei Comuni", 'url' => '/action%3As_italia%3Aassegno.maternita'),
            array('nome' => "Chiedere la concessione di un contributo economico per un familiare non autosufficiente", 'url' => '/action%3As_italia%3Acontributi.economici.individuali'),
        ),
        'Tributi' => array(
            array('nome' => "Chiedere il discarico della cartella di pagamento relativa a un tributo", 'url' => '/action%3Ac_e488%3Apagamento.tributi%3Bdiscarico.cartella.esattoriale'),
            array('nome' => "Chiedere il rimborso per errato versamento di un tributo", 'url' => '/action%3As_italia%3Arimborso.errato.versamento'),
            array('nome' => "Chiedere il riversamento del pagamento di tributi", 'url' => '/action%3As_italia%3Ariversamento.pagamento.tributi'),
            array('nome' => "Chiedere la compensazione tra crediti e debiti tributari", 'url' => '/action%3As_italia%3Acompensazione.crediti.debiti'),
            array('nome' => "Chiedere la rateizzazione del pagamento di un tributo", 'url' => '/action%3As_italia%3Arateizzazione.pagamento.tributi'),
            array('nome' => "Correggere errori formali relativi al pagamento con modello F24", 'url' => '/action%3As_italia%3Aerrori.compilazione.modello.f24%3Bcorrezione'),
            array('nome' => "Fare un ravvedimento operoso", 'url' => '/action%3As_italia%3Aravvedimento.operoso'),
            array('nome' => "Gestire un accertamento esecutivo", 'url' => '/action%3As_italia%3Aaccertamento.tributario'),
            array('nome' => "Versare il canone unico patrimoniale e mercatale", 'url' => '/action%3As_italia%3Acanone.unico.patrimoniale'),
            array('nome' => "Versare l'imposta di soggiorno (IDS)", 'url' => '/action%3As_italia%3Aimposta.soggiorno'),
            array('nome' => "Versare l'imposta municipale propria (IMU)", 'url' => '/action%3As_italia%3Aimposta.municipale.unica'),
            array('nome' => "Versare la tassa sui rifiuti (TARI)", 'url' => '/action%3Ac_e488%3Atassa.rifiuti'),
        ),
        'Alloggi ERP e housing sociale' => array(
            array('nome' => "Risiedere in un alloggio di edilizia convenzionata", 'url' => '/action%3As_italia%3Aedilizia.convenzionata'),
        ),
        'Polizia locale' => array(
            array('nome' => "Aprire un passo carrabile", 'url' => '/action%3As_italia%3Apasso.carrabile'),
            array('nome' => "Chiedere il cambio di custodia per veicoli sottoposti a sequestro o fermo amministrativo", 'url' => '/action%3As_italia%3Afermo.amministrativo.sequestro.veicolo%3Bcambio.custodia'),
            array('nome' => "Chiedere il discarico della cartella relativa a una violazione", 'url' => '/action%3As_italia%3Adiscarico.cartella.esattoriale'),
            array('nome' => "Chiedere il dissequestro di un veicolo sprovvisto di assicurazione", 'url' => '/action%3As_italia%3Afermo.amministrativo.sequestro.veicolo%3Bdissequestro.rimessa.circolazione'),
            array('nome' => "Chiedere il rilascio di copia del rapporto di rilievo di un incidente stradale", 'url' => '/action%3As_italia%3Ainformazioni.incidenti'),
            array('nome' => "Chiedere il rimborso del pagamento di una sanzione amministrativa", 'url' => '/action%3As_italia%3Asanzioni%3Brimborso.pagamento'),
            array('nome' => "Chiedere l'annullamento in autotutela di un preavviso o verbale", 'url' => '/action%3As_italia%3Aannullamento.preavviso.verbale'),
            array('nome' => "Chiedere l'assegnazione della numerazione civica", 'url' => '/action%3As_italia%3Anumerazione.civica'),
            array('nome' => "Chiedere l'autorizzazione alla demolizione e radiazione di un veicolo sotto sequestro", 'url' => '/action%3As_italia%3Afermo.amministrativo.sequestro.veicolo%3Bdissequestro.demolizione.radiazione'),
            array('nome' => "Chiedere la modifica temporanea della viabilità", 'url' => '/action%3As_italia%3Aviabilita%3Bmodifica'),
            array('nome' => "Chiedere la rateizzazione del pagamento di una sanzione al Codice della Strada", 'url' => '/action%3As_italia%3Asanzioni%3Bamministrative.violazioni.codice.strada%3Brateizzazione'),
            array('nome' => "Chiedere la realizzazione di un'area di carico/scarico merci", 'url' => '/action%3As_italia%3Acarico.scarico.merci%3Brealizzazione.area'),
            array('nome' => "Chiedere la realizzazione e l'assegnazione di un'area di sosta per disabili", 'url' => '/action%3As_italia%3Aveicoli.disabili%3Bassegnazione.spazio.sosta'),
            array('nome' => "Chiedere la restituzione di veicoli rimossi", 'url' => '/action%3As_italia%3Arestituzione.veicoli.rimossi'),
            array('nome' => "Chiedere la restituzione di veicoli rubati", 'url' => '/action%3As_italia%3Arestituzione.veicoli.rubati'),
            array('nome' => "Chiedere la targa per un veicolo a trazione animale", 'url' => '/action%3As_italia%3Aveicoli.trazione.animale%3Btarga'),
            array('nome' => "Comunicare i dati del conducente a seguito di un accertamento di violazione", 'url' => '/action%3As_italia%3Aaccertamento.violazione%3Bcomunicazione.dati.conducente'),
            array('nome' => "Comunicare la cessione di un fabbricato", 'url' => '/action%3As_italia%3Acessione.fabbricato'),
            array('nome' => "Fare ricorso contro una sanzione amministrativa", 'url' => '/action%3As_italia%3Asanzioni.amministrative'),
            array('nome' => "Gestire un fermo amministrativo o sequestro di un veicolo", 'url' => '/action%3As_italia%3Afermo.amministrativo.sequestro.veicolo'),
        ),
        'Lavori pubblici e mobilità urbana' => array(
            array('nome' => "Chiedere la modifica temporanea della viabilità", 'url' => '/action%3As_italia%3Aviabilita%3Bmodifica'),
            array('nome' => "Chiedere la realizzazione di un'area di carico/scarico merci", 'url' => '/action%3As_italia%3Acarico.scarico.merci%3Brealizzazione.area'),
            array('nome' => "Chiedere la realizzazione e l'assegnazione di un'area di sosta per disabili", 'url' => '/action%3As_italia%3Aveicoli.disabili%3Bassegnazione.spazio.sosta'),
            array('nome' => "Comunicare il conto corrente dedicato ad appalti e commesse pubbliche", 'url' => '/action%3As_italia%3Aappalti.commesse.pubbliche%3Bconto.corrente.dedicato'),
            array('nome' => "Manomettere suolo pubblico", 'url' => '/action%3As_italia%3Aopere.depositi.cantieri.stradali'),
        ),
        'Servizi cimiteriali' => array(
            array('nome' => "Attivare una lampada o luce votiva presso il cimitero", 'url' => '/action%3As_italia%3Ailluminazione.votiva'),
            array('nome' => "Chiedere l'autorizzazione alla sepoltura per inumazione o tumulazione", 'url' => '/action%3As_italia%3Ainumazione.tumulazione'),
            array('nome' => "Disperdere le ceneri", 'url' => '/action%3Ac_e488%3Acremazione%3Bdispersione.ceneri'),
            array('nome' => "Ottenere l'affidamento delle ceneri", 'url' => '/action%3As_italia%3Acremazione%3Baffidamento.ceneri'),
            array('nome' => "Posare monumenti funebri", 'url' => '/action%3As_italia%3Aposa.monumenti.funebri'),
            array('nome' => "Trasportare cadaveri, ceneri o resti mortali all'estero", 'url' => '/action%3As_italia%3Atrasporto.ceneri.resti%3Bestero'),
            array('nome' => "Trasportare cadaveri, ceneri o resti mortali in Italia", 'url' => '/action%3As_italia%3Atrasporto.ceneri.resti%3Bterritorio.italiano'),
            array('nome' => "Tumulare ceneri o resti mortali in posto già in concessione", 'url' => '/action%3As_italia%3Atumulazione%3Bposto.gia.concessione'),
            array('nome' => "Tumulare provvisoriamente cadaveri", 'url' => '/action%3Ac_e488%3Atumulazione%3Bprovvisoria'),
        ),
        'Servizi scolastici e per l\'infanzia' => array(
            array('nome' => "Andare a scuola con lo scuolabus", 'url' => '/action%3As_italia%3Atrasporto.scolastico'),
            array('nome' => "Andare alla mensa scolastica", 'url' => '/action%3As_italia%3Aristorazione.scolastica'),
            array('nome' => "Candidarsi a premi o borse di studio", 'url' => '/action%3As_italia%3Aborse.studio.comunali'),
            array('nome' => "Partecipare a uno stage o tirocinio", 'url' => '/action%3As_italia%3Astage.tirocinio%3Binterno'),
        ),
        'Tempo libero, sport e cultura' => array(
            array('nome' => "Andare allo spazio gioco", 'url' => '/action%3As_italia%3Aspazio.gioco'),
            array('nome' => "Chiedere la concessione del patrocinio", 'url' => '/action%3As_italia%3Apatrocinio'),
            array('nome' => "Chiedere la concessione di spazi di proprietà dell'Amministrazione", 'url' => '/action%3As_italia%3Aimmobili.comunali%3Buso.spazi%3Bautorizzazione'),
            array('nome' => "Chiedere un contributo economico per iniziative di associazioni", 'url' => '/action%3As_italia%3Acontributi.economici%3Battivita.sportive.culturali'),
            array('nome' => "Iscriversi all'albo comunale delle associazioni", 'url' => '/action%3As_italia%3Aalbo.comunale.associazioni'),
            array('nome' => "Organizzare manifestazioni di sorte locale (tombole, lotterie, pesche)", 'url' => '/action%3As_italia%3Amanifestazione%3Bsorte.locale'),
            array('nome' => "Organizzare una manifestazione sportiva non competitiva su strada", 'url' => '/action%3As_italia%3Amanifestazioni.non.competitive'),
        ),
        'Patrimonio' => array(
            array('nome' => "Manifestare interesse ad acquistare o gestire immobili comunali", 'url' => '/action%3As_italia%3Aimmobili.comunali'),
        ),
        'Occupazione, concorsi e assunzioni' => array(
            array('nome' => "Chiedere il certificato di servizio prestato presso l'ente", 'url' => '/action%3As_italia%3Aservizio.prestato.presso.ente%3Battestato'),
            array('nome' => "Partecipare a un concorso pubblico", 'url' => '/action%3As_italia%3Aconcorso.pubblico'),
            array('nome' => "Partecipare a una procedura comparativa di selezione", 'url' => '/action%3As_italia%3Aprocedura.comparativa.personale%3Bpubbliche.amministrazioni'),
            array('nome' => "Partecipare a uno stage o tirocinio", 'url' => '/action%3As_italia%3Astage.tirocinio%3Binterno'),
            array('nome' => "Partecipare alla selezione per mobilità volontaria tra enti pubblici", 'url' => '/action%3As_italia%3Apassaggio.diretto.personale%3Bpubbliche.amministrazioni'),
            array('nome' => "Svolgere il servizio civile universale", 'url' => '/action%3As_italia%3Aservizio.civile'),
        ),
        'Protezione civile e volontariato' => array(
            array('nome' => "Iscriversi al gruppo comunale dei volontari di protezione civile", 'url' => '/action%3As_italia%3Avolontari.protezione.civile'),
            array('nome' => "Iscriversi all'albo comunale dei volontari", 'url' => '/action%3As_italia%3Aalbo.comunale.volontariato'),
        ),
        'Segreteria generale' => array(
            array('nome' => "Chiedere il rimborso del pagamento di diritti di segreteria o istruttoria", 'url' => '/action%3As_italia%3Arimborso%3Bdiritti.segreteria'),
            array('nome' => "Chiedere il risarcimento danni", 'url' => '/action%3As_italia%3Aincidente%3Bdenuncia%3Brisarcimento.danni'),
            array('nome' => "Consultare archivi o documenti di interesse storico", 'url' => '/action%3As_italia%3Aconsultazione.archivi.documenti.interesse.storico'),
            array('nome' => "Diventare fornitori dell'Amministrazione", 'url' => '/action%3As_italia%3Adiventare.fornitori.amministrazione'),
            array('nome' => "Emettere fatture all'Amministrazione", 'url' => '/action%3As_italia%3Aemettere.fatture.amministrazione'),
            array('nome' => "Iscriversi al registro degli avvocati patrocinatori", 'url' => '/action%3As_italia%3Aalbo.avvocato'),
            array('nome' => "Presentare una petizione", 'url' => '/action%3As_italia%3Apetizioni'),
            array('nome' => "Segnalare l'avvenuta violazione di dati personali (data breach)", 'url' => '/action%3As_italia%3Asegnalazione.violazione.dati.personali'),
        ),
        'Permessi ZTL e invalidi' => array(
            array('nome' => "Chiedere il contrassegno per veicoli a servizio dei disabili", 'url' => '/action%3As_italia%3Aveicoli.disabili%3Bcircolazione.sosta'),
            array('nome' => "Chiedere la realizzazione e l'assegnazione di un'area di sosta per disabili", 'url' => '/action%3As_italia%3Aveicoli.disabili%3Bassegnazione.spazio.sosta'),
        ),
        'Tutela degli animali' => array(
            array('nome' => "Proteggere le colonie feline", 'url' => '/action%3Ac_e488%3Acolonia.felina'),
            array('nome' => "Rinunciare alla proprietà del cane", 'url' => '/action%3Ac_e488%3Aproprieta.cane%3Brinuncia'),
            array('nome' => "Segnalare il ritrovamento di una carcassa animale", 'url' => '/action%3As_italia%3Asegnalare.carcassa.animale'),
            array('nome' => "Segnalare un presunto maltrattamento di animali", 'url' => '/action%3As_italia%3Aanimali%3Bsegnalare.presunto.maltrattamento'),
            array('nome' => "Trasferire la proprietà del cane al Comune", 'url' => '/action%3As_italia%3Arinuncia.cane'),
        ),
        'Comunicare con l\'Amministrazione' => array(
            array('nome' => "Cambiare la domiciliazione delle comunicazioni relative a un procedimento", 'url' => '/action%3As_italia%3Agenerale%3Bmodifica.domicilio'),
            array('nome' => "Chiedere il rilascio di dati", 'url' => '/action%3As_italia%3Arilascio.dati'),
            array('nome' => "Chiedere il rimborso del pagamento di diritti di segreteria o istruttoria", 'url' => '/action%3As_italia%3Arimborso%3Bdiritti.segreteria'),
            array('nome' => "Chiedere l'esercizio del potere sostitutivo", 'url' => '/action%3As_italia%3Aesercizio.potere.sostitutivo'),
            array('nome' => "Esercitare i propri diritti in materia di protezione dei dati personali", 'url' => '/action%3As_italia%3Adati.personali%3Besercizio.diritti.protezione'),
            array('nome' => "Pagare l'imposta di bollo per il rilascio del provvedimento finale", 'url' => '/action%3As_italia%3Aprocedimenti.amministrativi%3Britiro.provvedimento.finale'),
            array('nome' => "Presentare una segnalazione, un reclamo, un suggerimento o un apprezzamento", 'url' => '/action%3As_italia%3Asegnalazione.generica'),
            array('nome' => "Trasmettere una comunicazione generica alla Pubblica Amministrazione", 'url' => '/action%3As_italia%3Aprocedimenti.amministrativi%3Bcomunicare.pubblica.amministrazione%3Bcomunicazione.generica'),
            array('nome' => "Verificare il rispetto degli obblighi di accessibilità", 'url' => '/action%3As_italia%3Aobblighi.accessibilita'),
        ),
        'Urbanistica e pianificazione' => array(
            array('nome' => "Chiedere il certificato di destinazione urbanistica (CDU)", 'url' => '/action%3As_italia%3Acertificato.destinazione.urbanistica'),
            array('nome' => "Depositare un atto di aggiornamento catastale (frazionamento)", 'url' => '/action%3As_italia%3Afrazionamento.catastale'),
            array('nome' => "Fare pubblicità", 'url' => '/action%3As_italia%3Apubblicita'),
        ),
        'Demanio' => array(
            array('nome' => "Accedere all'arenile con mezzi meccanici", 'url' => '/action%3As_italia%3Ademanio.marittimo%3Baccesso.arenile.concessione'),
            array('nome' => "Chiedere una concessione demaniale marittima", 'url' => '/action%3As_italia%3Aconcessione.demaniale.marittima'),
            array('nome' => "Eseguire lavori di manutenzione in area demaniale in concessione", 'url' => '/action%3As_italia%3Ademanio.marittimo.manutenzione.area%3Bautorizzazione'),
        ),
    );

    ob_start();
    foreach ($categorie as $nome_cat => $procedure) {
        echo '<h3>' . esc_html($nome_cat) . '</h3>';
        echo '<ul>';
        foreach ($procedure as $p) {
            $href = esc_url($base . $p['url']);
            echo '<li><a href="' . $href . '" target="_blank" rel="noopener noreferrer">' . esc_html($p['nome']) . '</a></li>';
        }
        echo '</ul>';
    }
    return ob_get_clean();
}
