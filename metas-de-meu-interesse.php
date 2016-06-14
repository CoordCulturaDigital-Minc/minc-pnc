<?php

$cur_user = wp_get_current_user();

if (isset($_POST['dont_show_welcome_again']) && $_POST['dont_show_welcome_again'] == 1) {
    update_user_meta($cur_user->ID, 'mincpnc_skip_instructions', true);
}

if (isset($_POST['skip_metas_interesse'])) {

    wp_safe_redirect( $_POST['redirect_to'] );

}

if (isset($_POST['save_metas_interesse'])) {

    delete_user_meta($cur_user->ID, 'temas_followed');
    delete_user_meta($cur_user->ID, 'tags_metas_followed');
    
    if (isset($_POST['temas_followed']) && is_array($_POST['temas_followed'])) {
        foreach ($_POST['temas_followed'] as $tema)
            if (!empty($tema)) add_user_meta($cur_user->ID, 'temas_followed', $tema);
    }
    if (isset($_POST['tags_metas_followed']) && is_array($_POST['tags_metas_followed'])) {
        foreach ($_POST['tags_metas_followed'] as $tag)
            if (!empty($tag)) add_user_meta($cur_user->ID, 'tags_metas_followed', $tag);  
    }
    
    
    //recarrega lista
    wp_safe_redirect( site_url('metas-de-meu-interesse') );

}

if (isset($_GET['remove_meta']) && is_numeric($_GET['remove_meta'])) {
    
    $meta_id = $_GET['remove_meta'];
    remove_meta_from_user($meta_id);
    
    //recarrega lista
    wp_safe_redirect( site_url('metas-de-meu-interesse') );
    
}

get_header();

$textosHome = get_option('textos_home_options');

?>
<section id="main-section" class="metas-de-meu-interesse span-15 prepend-1 append-1">
    <header>
        <h1><?php echo isset($textosHome['metas_interesse_tit']) ? $textosHome['metas_interesse_tit'] : ''; ?></h1>
        <p>
            <?php echo isset($textosHome['metas_interesse_intro']) ? apply_filters('the_content', $textosHome['metas_interesse_intro']) : ''; ?>
            <?php textos_home_edit_link(); ?>
        </p>
    </header>

    <?php mincpnc_formulario_selecao_metas_interesse(); ?>
    
    <?php if (have_posts()): ?>
        <div class="meta-list">
            <?php while (have_posts()):
                    the_post();
                    html::part('loop-metas');
                endwhile; 
            ?>
        </div>
        
    <?php else : ?>
        <p class="warning">
            <small>Você ainda não selecionou nenhuma meta para acompanhar. Faça um filtro de acordo com os campos acima, ou selecione metas individualmente. Para mais informações, <a href="<?php echo get_permalink( get_page_id_by_template('tpl-instrucoes-metas.php') ); ?>">esta página</a> vai te ajudar neste processo.</small>
        </p>
    <?php endif; ?>
</section>
<!-- #main-section -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
