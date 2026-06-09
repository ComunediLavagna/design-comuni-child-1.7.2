<?php
/* Template Name: Attuazione Misure PNRR
 *
 * H2 nel contenuto editor → nav laterale + sezione con anchor
 * H3 nel contenuto editor → accordion Bootstrap Italia
 *   Se H3 contiene codice missione M1–M6 → accordion popolato automaticamente dai CPT
 */
global $post, $with_shadow;
get_header();
?>
<main>
    <?php while ( have_posts() ) : the_post();
        $with_shadow = false;
        get_template_part( "template-parts/hero/hero" );

        $raw     = apply_filters( 'the_content', get_the_content() );
        $parsed  = pnrr_transform_content( $raw );
    ?>

    <div class="container">
        <div class="row border-top border-light row-column-border row-column-menu-left">

            <!-- Nav laterale: generata automaticamente dagli H2 -->
            <aside class="col-lg-4">
                <div class="cmp-navscroll sticky-top" aria-labelledby="acc-title-pnrr-nav">
                    <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="Indice della pagina" data-bs-navscroll>
                        <div class="navbar-custom">
                            <div class="menu-wrapper">
                                <div class="link-list-wrapper">
                                    <div class="accordion">
                                        <div class="accordion-item">
                                            <span class="accordion-header" id="acc-title-pnrr-nav">
                                                <button class="accordion-button pb-10 px-3 text-uppercase" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse-pnrr-nav"
                                                    aria-expanded="true" aria-controls="collapse-pnrr-nav">
                                                    Indice della pagina
                                                    <svg class="icon icon-sm icon-primary align-top">
                                                        <use xlink:href="#it-expand"></use>
                                                    </svg>
                                                </button>
                                            </span>
                                            <div class="progress">
                                                <div class="progress-bar it-navscroll-progressbar" role="progressbar"
                                                    aria-label="Indice della pagina" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div id="collapse-pnrr-nav" class="accordion-collapse collapse show"
                                                role="region" aria-labelledby="acc-title-pnrr-nav">
                                                <div class="accordion-body">
                                                    <ul class="link-list" data-element="page-index">
                                                        <?php foreach ( $parsed['nav'] as $item ) : ?>
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

            <!-- Contenuto trasformato -->
            <section class="col-lg-8 it-page-sections-container border-light pt-4">
                <?php echo $parsed['content']; ?>
            </section>

        </div>
    </div>

    <?php get_template_part( "template-parts/common/valuta-servizio" ); ?>
    <?php get_template_part( "template-parts/common/assistenza-contatti" ); ?>

    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
