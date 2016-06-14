<?php

global $post;

get_header();

$textosHome = get_option('textos_home_options'); 
?>

<section id="main-section" class="archive-metas clearfix">
    <header class="archive">
        <h1><?php echo isset($textosHome['metas_tit']) ? $textosHome['metas_tit'] : ''; ?></h1>
        <p>
            <?php echo isset($textosHome['metas_intro']) ? apply_filters('the_content', $textosHome['metas_intro']) : ''; ?>
            <?php textos_home_edit_link(); ?>
        </p>
    </header>
    <div class="content meta-list">

        <?php require_once(TEMPLATEPATH . '/includes/busca_metas.php'); ?>
    
         <?php
        if (have_posts()):
            while (have_posts()):
                the_post();
                html::part('loop-metas');

            endwhile; 
        ?>
        
            <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>
        
        <?php else : ?>
            <p>Nenhuma meta encontrada</p>
        <?php endif; ?>
        
    </div>
</section>
<!-- #main-section -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
