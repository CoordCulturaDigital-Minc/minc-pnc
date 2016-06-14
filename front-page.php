<?php

$metas_atualizadas = get_posts(array('numberposts' => 6, 'post_type' => 'metas', 'orderby' => 'meta_value', 'meta_key' => '_ultima_atualizacao', 'order' => 'DESC'));
$temas = get_terms('tema', 'orderby=term_order&order=ASC');

get_header();

?>

<section id="main-section" class="clearfix">
    <?php echo new WidgetMultiplePost('multiple-post-1', 'destaque-home') ?>
    <section id="news">
        <?php echo new WidgetUniquePost('unique-post-2', 'destaque-secundario-home') ?>
        <?php echo new WidgetUniquePost('unique-post-3', 'destaque-secundario-home') ?>
        <?php echo new WidgetUniquePost('unique-post-4', 'destaque-secundario-home') ?>
        <p class="more-news bottom textright"><a href="<?php bloginfo('url') ?>/blog">Mais notícias</a></p>
    </section>

    <section id="metas" class="clearfix">
        <header>
            <?php $textosHome = get_option('textos_home_options'); ?>
            <h1><?php echo isset($textosHome['acompanhamento_tit']) ? $textosHome['acompanhamento_tit'] : ''; ?></h1>
            <p>
            <?php echo isset($textosHome['acompanhamento']) ? apply_filters('the_content', $textosHome['acompanhamento']) : ''; ?>
            <?php textos_home_edit_link(); ?>
            </p>
            <nav class="clearfix">
				<div>
	                <a href="<?php echo mincpnc_does_currentuser_follows_anything() ? site_url('metas-de-meu-interesse') : get_permalink( get_page_id_by_template('tpl-instrucoes-metas.php') ); ?>" class="btn btn-blue">Metas de meu interesse</a>
	                <a href="<?php echo get_post_type_archive_link('metas'); ?>" class="btn btn-blue">Todas as metas</a>
	                <?php
                    $linkTemasTags = get_page_id_by_template('tpl-temas-e-tags.php');
                    
                    if (!$linkTemasTags) {
                        $linkTemasTags = '';
                        if (current_user_can('manage_options')) {
                            $linkTemasTags = 'javascript:alert(\'Administrador do site, crie uma página utilizando o modelo Lista de Temas e Tags para que este link funcione\')';
                        }
                    } else {
                        $linkTemasTags = get_permalink($linkTemasTags);
                    }
                    ?>
                    <a href="<?php echo $linkTemasTags; ?>" class="btn btn-blue">Metas por temas</a>					
				</div>
            </nav>
        </header>
    </section>

    <section id="metas-update" class="clearfix">
        <header>
            <h1><?php echo isset($textosHome['atualizadas_tit']) ? $textosHome['atualizadas_tit'] : ''; ?></h1>
            <p>
            <?php echo isset($textosHome['atualizadas']) ? apply_filters('the_content', $textosHome['atualizadas']) : ''; ?>
            <?php textos_home_edit_link(); ?>
            </p>
        </header>
        <ul>
            <?php foreach ($metas_atualizadas as $meta) : ?>
                <li><span>Meta <?php echo get_post_meta($meta->ID, '_numero', true); ?>:</span> <a href="<?php echo get_permalink($meta->ID); ?>"><?php echo $meta->post_title; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>
</section>

<?php get_sidebar() ?>

<?php get_footer() ?>
