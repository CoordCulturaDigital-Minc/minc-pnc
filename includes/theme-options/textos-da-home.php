<?php


function textos_home_options_menu() {

    // Por padrão criamos uma página exclusiva para as opções desse site
    // Mas se quiser você pode colocar ela embaixo de aparencia, opções, ou o q vc quiser. O modelo para todos os casos estão comentados abaixo

    $topLevelMenuLabel = 'Textos Site';
    $page_title = 'Textos Site';
    $menu_title = 'Textos Site';

    /* Top level menu */
    add_submenu_page('textos_home_options', $page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');

    /* Menu embaixo de um menu existente */
    //add_dashboard_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_posts_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_plugin_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_media_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_links_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_pages_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_comments_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_plugins_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_users_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_management_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_options_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
    //add_textos_home_page($page_title, $menu_title, 'manage_options', 'textos_home_options', 'textos_home_options_page_callback_function');
}

function textos_home_options_validate_callback_function($input) {

    // Se necessário, faça aqui alguma validação ao salvar seu formulário
    return $input;
}

function textos_home_options_page_callback_function() {

    // Crie o formulário. Abaixo você vai ver exemplos de campos de texto, textarea e checkbox. Crie quantos você quiser
    ?>
    <div class="wrap span-20">
        <h2>Textos da Home</h2>

        <form action="options.php" method="post" class="clear prepend-top">
            <?php settings_fields('textos_home_options_options'); ?>
            <?php $options = get_option('textos_home_options'); ?>

            <div class="span-20 ">
                
                <div class="span-6 last">

                    <h3>BOX - Acompanhamento das Metas do PNC</h3>
                    
                    Título: <input type="text" name="textos_home_options[acompanhamento_tit]" value="<?php echo htmlspecialchars($options['acompanhamento_tit']); ?>" />
                    
                    <?php wp_editor($options['acompanhamento'], 'acompanhamento', array('textarea_name' => 'textos_home_options[acompanhamento]') ); ?>
                    <br/>
                    <h3>BOX - Metas atualizadas recentemente</h3>
                    
                    Título: <input type="text" name="textos_home_options[atualizadas_tit]" value="<?php echo htmlspecialchars($options['atualizadas_tit']); ?>" />
                    
                    <?php wp_editor($options['atualizadas'], 'atualizadas', array('textarea_name' => 'textos_home_options[atualizadas]') ); ?>

                </div>
            </div>
            
            <br/>
            <hr />
            
            <h2>Textos da Página de Metas</h2>
            
            Título: <input type="text" name="textos_home_options[metas_tit]" value="<?php echo htmlspecialchars($options['metas_tit']); ?>" />
                    
            <?php wp_editor($options['metas_intro'], 'metas_intro', array('textarea_name' => 'textos_home_options[metas_intro]') ); ?>
            
            
            <br/>
            <hr />
            
            <h2>Textos da Página de Metas do Meu Interesse</h2>
            
            Título: <input type="text" name="textos_home_options[metas_interesse_tit]" value="<?php echo htmlspecialchars($options['metas_interesse_tit']); ?>" />
                    
            <?php wp_editor($options['metas_interesse_intro'], 'metas_interesse_intro', array('textarea_name' => 'textos_home_options[metas_interesse_intro]') ); ?>
            
            
            <p class="textright clear prepend-top">
                <input type="submit" class="button-primary" value="Salvar" />
            </p>
        </form>
    </div>

<?php } 

add_action('admin_init', 'textos_home_options_init');
add_action('admin_menu', 'textos_home_options_menu');

function textos_home_options_init() {
    register_setting('textos_home_options_options', 'textos_home_options', 'textos_home_options_validate_callback_function');
}

function textos_home_edit_link() {

    if (!current_user_can('manage_options'))
        return;
        
    $link = admin_url('?page=textos_home_options');
    echo '<a href="', $link, '">';
    html::image('icn-edit.png', 'Editar');
    echo '</a>';
    

}

