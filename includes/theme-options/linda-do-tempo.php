<?php


function linhadotempo_options_menu() {

    // Por padrão criamos uma página exclusiva para as opções desse site
    // Mas se quiser você pode colocar ela embaixo de aparencia, opções, ou o q vc quiser. O modelo para todos os casos estão comentados abaixo

    $topLevelMenuLabel = 'Linha do Tempo';
    $page_title = 'Linha do Tempo';
    $menu_title = 'Linha do Tempo';

    /* Top level menu */
    add_submenu_page('linhadotempo_options', $page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');

    /* Menu embaixo de um menu existente */
    //add_dashboard_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_posts_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_plugin_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_media_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_links_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_pages_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_comments_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_plugins_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_users_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_management_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_options_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
    //add_linhadotempo_page($page_title, $menu_title, 'manage_options', 'linhadotempo_options', 'linhadotempo_options_page_callback_function');
}

function linhadotempo_options_validate_callback_function($input) {

    // Se necessário, faça aqui alguma validação ao salvar seu formulário
    return $input;
}

function linhadotempo_options_page_callback_function() {

    // Crie o formulário. Abaixo você vai ver exemplos de campos de texto, textarea e checkbox. Crie quantos você quiser
    ?>
    <div class="wrap span-20">
        <h2>Links da Linha do Tempo</h2>

        <form action="options.php" method="post" class="clear prepend-top">
    <?php settings_fields('linhadotempo_options_options'); ?>
    <?php $options = get_option('linhadotempo_options'); ?>

            <div class="span-20 ">
                
                <div class="span-6 last">

                    
                    
                    <p>Para cada item da linha, insira o link para onde ele deve apontar (link completo, com http://). Deixe em branco caso se for o caso.</p>
                    
                    
                    <table>
                    
                    
                    <tr><td colspan="2"><h3>2003-2005</h3></td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2003][]" value="<?php echo get_linhadotempo_item_link(2003, 0); ?>" /></td><td>Realização do conjunto de seminários “Cultura para Todos” em todo o país.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2003][]" value="<?php echo get_linhadotempo_item_link(2003, 1); ?>" /></td><td>Criação da Agenda 21 da Cultura para as cidades.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2003][]" value="<?php echo get_linhadotempo_item_link(2003, 2); ?>" /></td><td>Instalação e trabalho das Câmaras Setoriais.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2003][]" value="<?php echo get_linhadotempo_item_link(2003, 3); ?>" /></td><td>Realização da 1ª Conferência Nacional de Cultura precedida por conferências regionais, estaduais e municipais.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2003][]" value="<?php echo get_linhadotempo_item_link(2003, 4); ?>" /></td><td>Aprovação da Convenção sobre a Proteção e Promoção da Diversidade das Expressões Culturais.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2003][]" value="<?php echo get_linhadotempo_item_link(2003, 5); ?>" /></td><td>Aprovação da emenda constitucional que insere o PNC no art. 215. </td></tr>
                                                                                          
                    <tr><td colspan="2"><h3>2006-2008</h3></td></tr>                      
                    <tr><td><input type="text" name="linhadotempo_options[2006][]" value="<?php echo get_linhadotempo_item_link(2006, 0); ?>" /></td><td>Apresentação do Projeto de Lei do PNC ao Congresso.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2006][]" value="<?php echo get_linhadotempo_item_link(2006, 1); ?>" /></td><td>Elaboração de diretrizes gerais. </td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2006][]" value="<?php echo get_linhadotempo_item_link(2006, 2); ?>" /></td><td>Realização de pesquisas no campo da cultura (IBGE e IPEA). </td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2006][]" value="<?php echo get_linhadotempo_item_link(2006, 3); ?>" /></td><td>Criação do Conselho Nacional de Política Cultural.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2006][]" value="<?php echo get_linhadotempo_item_link(2006, 4); ?>" /></td><td>Realização de seminários em todos os estados e fórum virtual.</td></tr>
                                                                                          
                                                                                          
                    <tr><td colspan="2"><h3>2009-2010</h3></td></tr>                      
                    <tr><td><input type="text" name="linhadotempo_options[2009][]" value="<?php echo get_linhadotempo_item_link(2009, 0); ?>" /></td><td>Realização da 2ª Conferência Nacional de Cultura.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2009][]" value="<?php echo get_linhadotempo_item_link(2009, 1); ?>" /></td><td>Análise do Projeto de Lei na Comissão de Educação e Cultura e na Comissão de Constituição e Justiça do Congresso. </td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2009][]" value="<?php echo get_linhadotempo_item_link(2009, 2); ?>" /></td><td>Aprovação da Lei do PNC (Lei n° 12.343/2010).</td></tr>
                                                                                          
                    <tr><td colspan="2"><h3>2011-2012</h3></td></tr>                      
                    <tr><td><input type="text" name="linhadotempo_options[2011][]" value="<?php echo get_linhadotempo_item_link(2011, 0); ?>" /></td><td>Formulação das metas do PNC.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2011][]" value="<?php echo get_linhadotempo_item_link(2011, 1); ?>" /></td><td>Elaboração de planos de ação para as metas.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2011][]" value="<?php echo get_linhadotempo_item_link(2011, 2); ?>" /></td><td>Desenvolvimento do Sistema Nacional de Informações e Indicadores Culturais (SNIIC).</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2011][]" value="<?php echo get_linhadotempo_item_link(2011, 3); ?>" /></td><td>Início do monitoramento das metas.</td></tr>
                                                                                          
                                                                                          
                    <tr><td colspan="2"><h3>2013-2014</h3></td></tr>                      
                    <tr><td><input type="text" name="linhadotempo_options[2013][]" value="<?php echo get_linhadotempo_item_link(2013, 0); ?>" /></td><td>Acompanhamento dos planos municipais e estaduais de cultura.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2013][]" value="<?php echo get_linhadotempo_item_link(2013, 1); ?>" /></td><td>Adequação e elaboração de planos setoriais de cultura.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2013][]" value="<?php echo get_linhadotempo_item_link(2013, 2); ?>" /></td><td>Monitoramento das metas do PNC.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2013][]" value="<?php echo get_linhadotempo_item_link(2013, 3); ?>" /></td><td>Realização da 3ª Conferência Nacional de Cultura.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2013][]" value="<?php echo get_linhadotempo_item_link(2013, 4); ?>" /></td><td>Revisão do PNC. </td></tr>
                                                                                          
                                                                                          
                    <tr><td colspan="2"><h3>2014-2020</h3></td></tr>                      
                    <tr><td><input type="text" name="linhadotempo_options[2014][]" value="<?php echo get_linhadotempo_item_link(2014, 0); ?>" /></td><td>Finalização do processo de revisão do PNC e publicação das alterações.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2014][]" value="<?php echo get_linhadotempo_item_link(2014, 1); ?>" /></td><td>Elaboração dos Planos Plurianuais (PPA) com base nas metas do PNC revisado.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2014][]" value="<?php echo get_linhadotempo_item_link(2014, 2); ?>" /></td><td>Monitoramento das metas do PNC.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2014][]" value="<?php echo get_linhadotempo_item_link(2014, 3); ?>" /></td><td>Realização da 4ª Conferência Nacional de Cultura.</td></tr>
                    <tr><td><input type="text" name="linhadotempo_options[2014][]" value="<?php echo get_linhadotempo_item_link(2014, 4); ?>" /></td><td>Elaboração de novo PNC.</td></tr>
                    
                    
                    </table>

                </div>
            </div>

            <p class="textright clear prepend-top">
                <input type="submit" class="button-primary" value="Salvar" />
            </p>
        </form>
    </div>

<?php } 


function get_linhadotempo_item_link($section, $item, $text = false) {
    
    $option = get_option('linhadotempo_options');
    $link = false;
    
    if (is_array($option) && isset($option[$section])) {
    
        if (is_array($option[$section]) && isset($option[$section][$item])) {
            $link = $option[$section][$item];
        }
    
    }
    
    if ($link && $text)
        return "<a href='$link'>$text</a>";
    
    if ($text && !$link)
        return $text;
    
    if ($link && !$text)
        return $link;
        
    return '';
    
}

add_action('admin_init', 'linhadotempo_options_init');
add_action('admin_menu', 'linhadotempo_options_menu');

function linhadotempo_options_init() {
    register_setting('linhadotempo_options_options', 'linhadotempo_options', 'linhadotempo_options_validate_callback_function');
}
