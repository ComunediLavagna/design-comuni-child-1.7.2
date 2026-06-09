# Design Comuni Italia — Child Theme Comune di Lavagna

Child theme WordPress del sito istituzionale **[comune.lavagna.ge.it](https://www.comune.lavagna.ge.it)**, basato sul tema parent [Design Comuni Italia](https://github.com/italia/design-comuni-wordpress-theme) del Dipartimento per la Trasformazione Digitale.

---

## Requisiti

| Componente | Versione |
|---|---|
| WordPress | 6.x |
| Tema parent | Design Comuni Italia **v1.12.7** |
| PHP | 8.2+ |
| Framework CSS | Bootstrap Italia (incluso nel parent) |

---

## Installazione

1. Installare il tema parent `design-comuni-italia` v1.12.7
2. Copiare la cartella `design-comuni-child-lavagna` in `wp-content/themes/`
3. Attivare il tema child dal pannello WordPress → Aspetto → Temi

---

## Struttura

```
design-comuni-child-lavagna/
├── assets/
│   ├── css/          # Font, stili custom
│   └── js/           # TinyMCE accordion plugin, booking, utils
├── inc/
│   ├── breadcrumb.php          # Breadcrumb personalizzato
│   ├── cpt_attuazione_pnrr.php # Custom Post Type PNRR + metabox CMB2
│   └── utils.php               # Funzioni di utilità
├── page-templates/             # Template di pagina custom
│   ├── pagina-accordion.php    # Generico con nav laterale e accordion
│   ├── attuazione-misure-pnrr.php
│   ├── personale-politico.php
│   ├── personale-amministrativo.php
│   └── ...
├── template-parts/             # Partial templates
├── single-attuazione_pnrr.php  # Singolo progetto PNRR
├── functions.php               # Funzioni child theme + widget Nowtice
├── style.css                   # Dichiarazione child theme + CSS custom
└── footer.php                  # Footer con search modal e logo EU/PNRR
```

---

## Funzionalità principali

### Widget allerta meteo Nowtice
Integrazione con la piattaforma [Nowtice PublicAlerts](https://publicalerts.nowtice.it) (Regola S.r.l.) per la visualizzazione automatica di avvisi di Protezione Civile nella sezione "Avvisi in Home" della homepage.

- **WidgetID**: 1038
- **Tenant**: 324 (Comune di Lavagna)
- Filtra solo allerte di categoria "Protezione Civile"
- Cache WordPress Transients: 30 minuti
- Colori automatici: giallo / arancione / rosso in base a `LevelColor` e `LevelDescription`

### Template pagina accordion
`page-templates/pagina-accordion.php` — template generico con:
- Indice laterale sticky auto-generato dai titoli H2
- Supporto accordion Bootstrap Italia
- Usato per: TARI, Protezione Civile, pagine strutturate

### Custom Post Type PNRR
CPT `attuazione_pnrr` con metabox CMB2: missione, componente, CUP, importo, titolare, stato avanzamento, link atti amministrativi.

### Plugin TinyMCE Accordion
Pulsante "Accordion" nella toolbar del Classic Editor che inserisce automaticamente la struttura HTML Bootstrap Italia con attributi ARIA corretti.

---

## Ambiente di sviluppo locale

Il sito è replicabile in locale tramite [LocalWP](https://localwp.com):

1. Creare un nuovo sito in LocalWP (`comune.lavagna.ge.local`)
2. Installare il tema parent v1.12.7
3. Installare questo child theme
4. Importare il contenuto tramite WordPress Importer (XML)

---

*Comune di Lavagna — Settore III, Ufficio CED*
*Riferimento: m.traversone@comune.lavagna.ge.it*
