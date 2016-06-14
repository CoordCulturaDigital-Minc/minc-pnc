<?php get_header(); ?>

<section id="main-section" class="clearfix">
    <header class="archive clearfix">
        <h1>Notícias</h1>

        <h2 class="top">
            <?php if ( is_day() ) : ?>
                Mostrando posts do dia "<?php echo get_the_date() ?>"
            <?php elseif ( is_month() ) : ?>
                Mostrando posts do mês "<?php echo get_the_date('F Y')?>"
            <?php elseif ( is_year() ) : ?>
                Mostrando posts do ano "<?php get_the_date('Y') ?>"
            <?php elseif ( is_category() ) : ?>
                Mostrando posts da categoria "<?php echo single_cat_title('', false) ?>"
            <?php elseif ( is_tag() ) : ?>
                Mostrando posts da tag "<?php echo single_tag_title('', false) ?>"
            <?php elseif ( is_author() ) : ?>
                <?php $queried = get_queried_object(); ?>
                Mostrando posts do autor "<?php echo $queried->display_name ?>"
            <?php else : ?>
                <!-- Arquivo do Blog -->
            <?php endif; ?>
        </h2>
    </header>

    <div class="content">

        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

            <div class="events">
                <?php html::part('loop', 'loop'); ?>
            </div>

            <?php endwhile; ?>

            <?php if ($wp_query->max_num_pages > 1) : ?>
                <nav id="posts-nav" class="clearfix">
                    <div class="alignleft"><?php previous_posts_link('<span class="btn btn-small btn-blue">&laquo; Recentes</span>'); ?></div>
                    <div class="alignright"><?php next_posts_link('<span class="btn btn-small btn-blue">Anteriores &raquo;</span>'); ?></div>
                </nav>
                <!-- #posts-nav -->
            <?php endif; ?>

        <?php else : ?>

            <p class="post"><?php _e('No results found.', 'blog01'); ?></p>

        <?php endif; ?>
    </div>
</section>
<!-- #main-section -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
