<?php
/**
 * Template scheda singola Progetto PNRR
 * - H2 nel contenuto → sezione con anchor + voce nav laterale
 * - H3 nel contenuto → accordion Bootstrap Italia
 */
global $post, $inline;
get_header();
?>
<main>
<?php while ( have_posts() ) : the_post();

    $prefix = '_pnrr_';
    $missione     = get_post_meta( $post->ID, $prefix . 'missione', true );
    $componente   = get_post_meta( $post->ID, $prefix . 'componente', true );
    $investimento = get_post_meta( $post->ID, $prefix . 'investimento', true );
    $cup          = get_post_meta( $post->ID, $prefix . 'cup', true );
    $importo      = get_post_meta( $post->ID, $prefix . 'importo', true );
    $titolare     = get_post_meta( $post->ID, $prefix . 'titolare', true );
    $stato        = get_post_meta( $post->ID, $prefix . 'stato_avanzamento', true );
    $data_agg     = get_post_meta( $post->ID, $prefix . 'data_aggiornamento', true );
    $attivita     = get_post_meta( $post->ID, $prefix . 'attivita_finanziate', true );
    $atti_url     = get_post_meta( $post->ID, $prefix . 'atti_amministrativi', true );
    $pa_url       = get_post_meta( $post->ID, $prefix . 'link_pa_digitale', true );

    $stati_label = [
        'avviato'   => 'Avviato',
        'in_corso'  => 'In corso',
        'liquidato' => 'Liquidato',
        'concluso'  => 'Concluso',
    ];

    // Trasforma il contenuto libero dell'editor (H2 → sezioni, H3 → accordion)
    $raw_content = apply_filters( 'the_content', get_the_content() );
    $parsed      = pnrr_transform_content( $raw_content );
    $dynamic_nav = $parsed['nav'];       // array [['id'=>..,'title'=>..], ...]
    $dynamic_html = $parsed['content'];  // HTML trasformato

    // Sezioni fisse da meta fields
    $fixed_sections = [];
    $fixed_sections[] = [ 'id' => 'identificazione', 'title' => 'Identificazione progetto' ];
    if ( $attivita )            $fixed_sections[] = [ 'id' => 'attivita',    'title' => 'Attività finanziate' ];
    if ( $stato )               $fixed_sections[] = [ 'id' => 'avanzamento', 'title' => 'Stato di avanzamento' ];
    if ( $atti_url || $pa_url ) $fixed_sections[] = [ 'id' => 'riferimenti', 'title' => 'Riferimenti' ];

    $all_nav = array_merge( $fixed_sections, $dynamic_nav );
?>

<div class="container px-4 my-4" id="main-container">
    <div class="row">
        <div class="col px-lg-4">
            <?php get_template_part( "template-parts/common/breadcrumb" ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 px-lg-4 py-lg-2">
            <h1 data-element="page-name"><?php the_title(); ?></h1>
            <?php if ( $missione ) : ?>
                <p class="h5 text-primary mt-2"><?php echo esc_html( $missione ); ?></p>
            <?php endif; ?>
            <?php if ( $componente || $investimento ) : ?>
                <p class="text-muted">
                    <?php echo esc_html( implode( ' – Investimento ', array_filter( [ $componente, $investimento ] ) ) ); ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="col-lg-3 offset-lg-1">
            <?php $inline = true; get_template_part( 'template-parts/single/actions' ); ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row border-top border-light row-column-border row-column-menu-left">

        <!-- Indice laterale (auto-generato) -->
        <aside class="col-lg-4" aria-label="Indice della pagina">
            <div class="cmp-navscroll sticky-top" aria-labelledby="accordion-title-pnrr">
                <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="Indice della pagina" data-bs-navscroll>
                    <div class="navbar-custom" id="navbarNavProgressPnrr">
                        <div class="menu-wrapper">
                            <div class="link-list-wrapper">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <span class="accordion-header" id="accordion-title-pnrr">
                                            <button class="accordion-button pb-10 px-3 text-uppercase" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse-pnrr"
                                                aria-expanded="true" aria-controls="collapse-pnrr">
                                                Indice della pagina
                                                <svg class="icon icon-sm icon-primary align-top" aria-hidden="true" focusable="false">
                                                    <use xlink:href="#it-expand"></use>
                                                </svg>
                                            </button>
                                        </span>
                                        <div class="progress">
                                            <div class="progress-bar it-navscroll-progressbar" role="progressbar"
                                                aria-label="Indice della pagina" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div id="collapse-pnrr" class="accordion-collapse collapse show"
                                            role="region" aria-labelledby="accordion-title-pnrr">
                                            <div class="accordion-body">
                                                <ul class="link-list" data-element="page-index">
                                                    <?php foreach ( $all_nav as $item ) : ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#<?php echo esc_attr( $item['id'] ); ?>">
                                                            <span class="title-medium"><?php echo esc_html( $item['title'] ); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Contenuto -->
        <section class="col-lg-8 it-page-sections-container border-light" aria-label="<?php echo esc_attr( get_the_title() ); ?>">

            <!-- Sezione fissa: Identificazione (sempre presente) -->
            <article id="identificazione" class="it-page-section anchor-offset mb-5">
                <h2 class="title-medium-2-semi-bold mb-4">Identificazione progetto</h2>
                <table class="table table-bordered">
                    <tbody>
                        <?php if ( $cup ) : ?>
                        <tr>
                            <th scope="row" style="width:42%">CUP</th>
                            <td><?php echo esc_html( $cup ); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if ( $importo ) : ?>
                        <tr>
                            <th scope="row">Importo finanziato</th>
                            <td><?php echo esc_html( $importo ); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if ( $titolare ) : ?>
                        <tr>
                            <th scope="row">Titolare</th>
                            <td><?php echo esc_html( $titolare ); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th scope="row">Attuatore</th>
                            <td>Comune di Lavagna</td>
                        </tr>
                        <?php if ( $data_agg ) : ?>
                        <tr>
                            <th scope="row">Ultimo aggiornamento</th>
                            <td><?php echo esc_html( $data_agg ); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </article>

            <!-- Sezione fissa: Attività finanziate -->
            <?php if ( $attivita ) : ?>
            <article id="attivita" class="it-page-section anchor-offset mb-5">
                <h2 class="title-medium-2-semi-bold mb-3">Attività finanziate</h2>
                <div class="richtext-wrapper lora"><?php echo wp_kses_post( $attivita ); ?></div>
            </article>
            <?php endif; ?>

            <!-- Sezione fissa: Stato di avanzamento -->
            <?php if ( $stato ) : ?>
            <article id="avanzamento" class="it-page-section anchor-offset mb-5">
                <h2 class="title-medium-2-semi-bold mb-3">Stato di avanzamento</h2>
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <?php echo esc_html( $stati_label[ $stato ] ?? $stato ); ?>
                </span>
            </article>
            <?php endif; ?>

            <!-- Sezione fissa: Riferimenti -->
            <?php if ( $atti_url || $pa_url ) : ?>
            <article id="riferimenti" class="it-page-section anchor-offset mb-5">
                <h2 class="title-medium-2-semi-bold mb-3">Riferimenti</h2>
                <ul class="list-unstyled">
                    <?php if ( $pa_url ) : ?>
                    <li class="mb-2">
                        <a href="<?php echo esc_url( $pa_url ); ?>" target="_blank" rel="noopener noreferrer">
                            <svg class="icon icon-sm me-1" aria-hidden="true"><use href="#it-external-link"></use></svg>
                            Modalità di accesso (PAdigitale2026)
                            <span class="visually-hidden">(si apre in una nuova finestra)</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if ( $atti_url ) : ?>
                    <li class="mb-2">
                        <a href="<?php echo esc_url( $atti_url ); ?>" target="_blank" rel="noopener noreferrer">
                            <svg class="icon icon-sm me-1" aria-hidden="true"><use href="#it-pa"></use></svg>
                            Atti amministrativi
                            <span class="visually-hidden">(si apre in una nuova finestra)</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </article>
            <?php endif; ?>

            <!-- Contenuto libero dell'editor trasformato (H2→sezioni, H3→accordion) -->
            <?php if ( trim( $dynamic_html ) ) : ?>
                <?php echo $dynamic_html; ?>
            <?php endif; ?>

        </section>
    </div>
</div>

<?php get_template_part( "template-parts/common/valuta-servizio" ); ?>

<?php endwhile; ?>
</main>
<?php get_footer(); ?>
