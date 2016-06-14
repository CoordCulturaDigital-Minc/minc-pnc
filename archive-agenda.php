<?php
global $paged;
$showingPast = ($paged > 0 || (isset($_GET['eventos']) && $_GET['eventos'] == 'passados'));
?>

<?php get_header(); ?>

<section id="main-section" class="clearfix">
    <header class="clearfix">
        <?php if ($showingPast): ?>
            <h1 class="alignleft top">Eventos Passados</h1>
            <a class="btn btn-blue alignright" href="<?php echo add_query_arg('eventos', ''); ?>">Ver próximos eventos &raquo;</a>
        <?php else: ?>
            <h1 class="alignleft top">Próximos eventos</h1>
            <a class="btn btn-blue alignright" href="<?php echo add_query_arg('eventos', 'passados'); ?>">Ver eventos passados &raquo;</a>
        <?php endif; ?>
    </header>

    <div class="content">
        <?php if ( have_posts()) : ?>
            <table class="events">
                <tr>
                    <th>Data de Início</th>
                    <th>Data de Fim</th>
                    <th>Evento</th>
                    <th>Local</th>
                </tr>
                <?php html::part('loop', 'agenda'); ?>
            </table>
        <?php else : ?>
            <p class="post"><?php _e('No results found.', 'blog01'); ?></p>
        <?php endif; ?>
    </div>
</section>
<!-- #main-section -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
