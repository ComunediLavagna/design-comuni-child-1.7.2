<?php
/*
 * Template Name: PNRR - Singolo Progetto
 *
 * Template per le singole pagine progetto PNRR, con indice laterale navigabile.
 * L'indice viene costruito automaticamente dai titoli H2 presenti nel contenuto.
 *
 * @package comune-v2
 */

function pnrr_slug( $text ) {
    $text = html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
    $text = mb_strtolower( $text, 'UTF-8' );
    $text = preg_replace( '/[àáâãäå]/u', 'a', $text );
    $text = preg_replace( '/[èéêë]/u',   'e', $text );
    $text = preg_replace( '/[ìíîï]/u',   'i', $text );
    $text = preg_replace( '/[òóôõö]/u',  'o', $text );
    $text = preg_replace( '/[ùúûü]/u',   'u', $text );
    $text = preg_replace( '/[^a-z0-9]+/', '-', $text );
    return trim( $text, '-' );
}

get_header();
?>
<main>
    <?php while ( have_posts() ) : the_post();

        // Legge il contenuto, estrae i titoli H2 e aggiunge gli id mancanti
        $raw_content = apply_filters( 'the_content', get_the_content() );

        $sezioni = array();
        $content  = preg_replace_callback(
            '/<h2([^>]*)>(.*?)<\/h2>/is',
            function ( $m ) use ( &$sezioni ) {
                $attrs = $m[1];
                $testo = wp_strip_all_tags( $m[2] );
                if ( empty( trim( $testo ) ) ) return $m[0];

                // Usa id già presente oppure ne genera uno
                if ( preg_match( '/id=["\']([^"\']+)["\']/', $attrs, $id_match ) ) {
                    $id = $id_match[1];
                } else {
                    $id    = pnrr_slug( $testo );
                    $attrs .= ' id="' . esc_attr( $id ) . '"';
                }

                $sezioni[] = array( 'id' => $id, 'testo' => $testo );
                return '<h2' . $attrs . '>' . $m[2] . '</h2>';
            },
            $raw_content
        );
    ?>

    <div class="container" id="main-container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <?php get_template_part("template-parts/common/breadcrumb"); ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="cmp-heading pb-3 pb-lg-4">
                    <h1 class="title-xxxlarge" data-element="page-name">
                        <?php the_title(); ?>
                    </h1>
                    <?php if ( has_excerpt() ) : ?>
                    <p class="subtitle-small mb-3">
                        <?php echo get_the_excerpt(); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <hr class="d-none d-lg-block mt-2"/>
        </div>
    </div>

    <div class="container">
        <div class="row row-column-menu-left mt-4 mt-lg-80 pb-lg-80 pb-40">

            <!-- Sidebar navscroll -->
            <div class="col-12 col-lg-3 mb-4 border-col">
                <div class="cmp-navscroll sticky-top" aria-labelledby="pnrr-index-title">
                    <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="Indice della pagina" data-bs-navscroll>
                        <div class="navbar-custom" id="navbarNavProgress">
                            <div class="menu-wrapper">
                                <div class="link-list-wrapper">
                                    <div class="accordion">
                                        <div class="accordion-item">
                                            <span class="accordion-header" id="pnrr-index-title">
                                                <button class="accordion-button pb-10 px-3 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#pnrr-index-collapse" aria-expanded="true" aria-controls="pnrr-index-collapse">
                                                    Indice della pagina
                                                    <svg class="icon icon-xs right">
                                                        <use href="#it-expand"></use>
                                                    </svg>
                                                </button>
                                            </span>
                                            <div class="progress">
                                                <div class="progress-bar it-navscroll-progressbar" role="progressbar" aria-label="Indice della pagina" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div id="pnrr-index-collapse" class="accordion-collapse collapse show" role="region" aria-labelledby="pnrr-index-title">
                                                <div class="accordion-body">
                                                    <ul class="link-list" data-element="page-index">
                                                        <?php foreach ( $sezioni as $s ) : ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#<?php echo esc_attr( $s['id'] ); ?>">
                                                                <span class="title-medium"><?php echo esc_html( $s['testo'] ); ?></span>
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
            </div>

            <!-- Contenuto principale -->
            <div class="col-12 col-lg-8 offset-lg-1">
                <div class="it-page-sections-container richtext-wrapper lora">
                    <?php echo $content; ?>
                </div>
            </div>

        </div>
    </div>

    <?php get_template_part("template-parts/common/valuta-servizio"); ?>
    <?php get_template_part("template-parts/common/assistenza-contatti"); ?>

    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
