<?php
/* Template Name: Pagina con indice e accordion
 *
 * Renderizza contenuto direttamente (Bootstrap accordion nativo).
 * Nav laterale: da H2 se presenti, altrimenti dai titoli dei pulsanti accordion.
 * Gli accordion-item ricevono id="sanitize_title(titolo)" per il collegamento nav.
 * Clic sulla nav → scroll + apertura accordion via JS.
 */
global $post, $with_shadow;
get_header();
?>
<main>
    <?php while ( have_posts() ) : the_post();
        $with_shadow = false;
        get_template_part( "template-parts/hero/hero" );

        $raw = get_the_content();

        // 1. Prova H2 come voci di nav
        $nav_items = [];
        $nav_type  = 'h2';
        preg_match_all( '/<h2[^>]*>(.*?)<\/h2>/is', $raw, $h2m );
        foreach ( $h2m[1] as $t ) {
            $title      = strip_tags( $t );
            $nav_items[] = [ 'id' => sanitize_title( $title ), 'title' => $title ];
        }

        // 2. Se nessun H2, usa i titoli dei pulsanti accordion
        if ( empty( $nav_items ) ) {
            $nav_type = 'accordion';
            preg_match_all(
                '/<button[^>]+class="[^"]*accordion-button[^"]*"[^>]*>\s*(.*?)\s*<\/button>/is',
                $raw,
                $btn_m
            );
            foreach ( $btn_m[1] as $btn_text ) {
                $title      = trim( strip_tags( $btn_text ) );
                $nav_items[] = [ 'id' => sanitize_title( $title ), 'title' => $title ];
            }
        }

        $content_html = apply_filters( 'the_content', $raw );

        // Per H2: aggiunge id="slug" agli H2 nel contenuto renderizzato
        if ( $nav_type === 'h2' && ! empty( $nav_items ) ) {
            $content_html = preg_replace_callback(
                '/<h2([^>]*)>(.*?)<\/h2>/is',
                function ( $m ) {
                    $id = sanitize_title( strip_tags( $m[2] ) );
                    if ( strpos( $m[1], 'id=' ) !== false ) return $m[0];
                    return '<h2' . $m[1] . ' id="' . esc_attr( $id ) . '" class="title-medium-2-semi-bold mb-4 mt-5">' . $m[2] . '</h2>';
                },
                $content_html
            );
        }

        // Per accordion: aggiunge id="slug" a ogni accordion-item così la nav punta al posto giusto
        if ( $nav_type === 'accordion' && ! empty( $nav_items ) ) {
            $idx = 0;
            $nav_copy = $nav_items;
            $content_html = preg_replace_callback(
                '/<div\s+class="accordion-item">/i',
                function ( $m ) use ( &$idx, $nav_copy ) {
                    if ( isset( $nav_copy[ $idx ] ) ) {
                        $id = esc_attr( $nav_copy[ $idx ]['id'] );
                        $idx++;
                        return '<div id="' . $id . '" class="accordion-item anchor-offset">';
                    }
                    $idx++;
                    return $m[0];
                },
                $content_html
            );
        }

        $has_nav = ! empty( $nav_items );
    ?>

    <div class="container">
        <div class="row border-top border-light row-column-border <?php echo $has_nav ? 'row-column-menu-left' : ''; ?>">

            <?php if ( $has_nav ) : ?>
            <aside class="col-lg-4" aria-label="Indice della pagina">
                <div class="cmp-navscroll sticky-top" aria-labelledby="acc-title-page-nav">
                    <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="Indice della pagina" data-bs-navscroll>
                        <div class="navbar-custom">
                            <div class="menu-wrapper">
                                <div class="link-list-wrapper">
                                    <div class="accordion">
                                        <div class="accordion-item">
                                            <span class="accordion-header" id="acc-title-page-nav">
                                                <button class="accordion-button pb-10 px-3 text-uppercase" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse-page-nav"
                                                    aria-expanded="true" aria-controls="collapse-page-nav">
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
                                            <div id="collapse-page-nav" class="accordion-collapse collapse show"
                                                role="region" aria-labelledby="acc-title-page-nav">
                                                <div class="accordion-body">
                                                    <ul class="link-list" data-element="page-index">
                                                        <?php foreach ( $nav_items as $item ) : ?>
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
            <?php endif; ?>

            <section class="<?php echo $has_nav ? 'col-lg-8' : 'col-12'; ?> it-page-sections-container border-light pt-4"
                     aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                <?php echo $content_html; ?>
            </section>

        </div>
    </div>

    <?php get_template_part( "template-parts/common/valuta-servizio" ); ?>
    <?php get_template_part( "template-parts/common/assistenza-contatti" ); ?>

    <?php endwhile; ?>
</main>

<?php if ( $has_nav && $nav_type === 'accordion' ) : ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cmp-navscroll a.nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            var href = this.getAttribute('href');
            if (!href || href.charAt(0) !== '#') return;
            var target = document.getElementById(href.substring(1));
            if (!target) return;
            var btn = target.querySelector('.accordion-button');
            if (btn && btn.classList.contains('collapsed')) {
                setTimeout(function () { btn.click(); }, 80);
            }
        });
    });
});
</script>
<?php endif; ?>

<?php get_footer(); ?>
