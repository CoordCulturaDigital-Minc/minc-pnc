<?php

function get_theme_default_options() {

    // Coloquei aqui o nome e o valor padrão de cada opção que você criar

    return array(
        'wellcome_title' => 'Benvindo!',
        'wellcome_video' => 'youtube.com/video',
        'itsnoon_creative_currency' => 0
    );
}

function theme_options_menu() {

    // Por padrão criamos uma página exclusiva para as opções desse site
    // Mas se quiser você pode colocar ela embaixo de aparencia, opções, ou o q vc quiser. O modelo para todos os casos estão comentados abaixo

    $topLevelMenuLabel = 'Cadastro';
    $page_title = 'Opções';
    $menu_title = 'Opções';

    /* Top level menu */
    add_submenu_page('theme_options', $page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'theme_options', 'theme_options_page_callback_function');

    /* Menu embaixo de um menu existente */
    //add_dashboard_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_posts_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_plugin_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_media_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_links_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_pages_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_comments_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_plugins_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_users_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_management_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_options_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_theme_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
}

function theme_options_validate_callback_function($input) {

    // Se necessário, faça aqui alguma validação ao salvar seu formulário
    return $input;
}

function theme_options_page_callback_function() {

    // Crie o formulário. Abaixo você vai ver exemplos de campos de texto, textarea e checkbox. Crie quantos você quiser
    ?>
    <div class="wrap span-20">
        <h2>Opções para o Cadastro</h2>

        <form action="options.php" method="post" class="clear prepend-top">
    <?php settings_fields('theme_options_options'); ?>
    <?php $options = wp_parse_args(get_option('theme_options'), get_theme_default_options()); ?>

            <div class="span-20 ">

    <?php //////////// Edite a partir daqui //////////  ?>

                

                <div class="span-6 last">


                    <label for="areas_atuacao"><strong>Áreas de Atuação (1 por linha)</strong></label><br/>
                    <textarea id="areas_atuacao" class="text" name="theme_options[areas_atuacao]"><?php echo isset($options['areas_atuacao']) ? htmlspecialchars($options['areas_atuacao']) : ''; ?></textarea>
                    <br/><br/>
                      
                    <label for="ocupacoes"><strong>Ocupações (1 por linha)</strong></label><br/>
                    <textarea id="ocupacoes" class="text" name="theme_options[ocupacoes]"><?php echo isset($options['ocupacoes']) ? htmlspecialchars($options['ocupacoes']) : ''; ?></textarea>
                    <br/><br/>
    <?php ///// Edite daqui pra cima ////  ?>


                </div>
            </div>

            <p class="textright clear prepend-top">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'SLUG'); ?>" />
            </p>
        </form>
    </div>

<?php } 


function get_theme_option($option_name) {
    $option = wp_parse_args(
            get_option('theme_options'), get_theme_default_options()
    );
    return isset($option[$option_name]) ? $option[$option_name] : false;
}

add_action('admin_init', 'theme_options_init');
add_action('admin_menu', 'theme_options_menu');

function theme_options_init() {
    register_setting('theme_options_options', 'theme_options', 'theme_options_validate_callback_function');
}
