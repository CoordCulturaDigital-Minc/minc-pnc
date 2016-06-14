<?php

/* Campos adicionais do usuário */

add_action('edit_user_profile', 'minc_edit_user_details');
add_action('show_user_profile', 'minc_edit_user_details');

function minc_edit_user_details($user) {

    ?>
    <table class="form-table">

    <tr>
    
        <th>
        <label>CPF</label>
        </th>
        <td>
        <input id="cpf" type="text" name="cpf" value="<?php echo esc_attr(get_user_meta($user->ID, 'cpf', true)); ?>" /><br />
        </td>
    </tr>
    
    <tr>
    
        <th><label>Estado</label></th>
        <td>
            <select  tabindex='16'  name="estado" id="estado"  >
                <option value=""> Selecione </option>
                
                <?php $states = get_states(); ?>
                <?php foreach ($states as $s): ?>
                
                    <option value="<?php echo $s->sigla; ?>"  <?php if(get_user_meta($user->ID, 'estado', true) == $s->sigla) echo 'selected'; ?>  >
                        <?php echo $s->nome; ?>
                    </option>
                
                <?php endforeach; ?>
                
            </select>
        </td>
    
    </tr>
    
    <tr>
    
        <th><label>Município</label></th>
        <td>
            <input type="hidden" id="disable_first_municipio_ajax_call" value="1" />
            <select name="municipio" id="municipio">
                <?php echo minc_get_cities_options(get_user_meta($user->ID, 'estado', true), get_user_meta($user->ID, 'municipio', true)); ?>
            </select>
        </td>
    
    </tr>
    
    <tr>
    
        <th><label>Área de Atuação</label></th>
        
        <td>
            <select name="atuacao"  id="atuacao">
                <option value="">Selecione</option>
                <?php $areas = get_theme_option('areas_atuacao'); $areas = explode("\n", $areas); ?>
                
                <?php foreach ($areas as $area): ?>
                    
                    <?php $san_area = esc_attr(trim($area)); ?>
                        
                    <option value="<?php echo $san_area; ?>" <?php if (get_user_meta($user->ID, 'atuacao', true) == $san_area) echo 'selected'; ?> ><?php echo $area; ?></option>
                
                <?php endforeach; ?>
                
                <option value="outra_area_cultura" <?php if (get_user_meta($user->ID, 'atuacao', true) == 'outra_area_cultura') echo 'selected'; ?> >Outra área de cultura</option>
                <option value="nao_cultura" <?php if (get_user_meta($user->ID, 'atuacao', true) == 'nao_cultura') echo 'selected'; ?> >Não ligado(a) a nenhuma área cultural</option>
                
                
                
            </select>
            
            <div id="outra_atuacao_container">
                <p>
                    Especifique: <br /> <input type="text" name="atuacao_outra" value="<?php echo esc_attr(get_user_meta($user->ID, 'atuacao_outra', true)); ?>" />
                </p>
            </div>
        </td>
    
    </tr>
    
    <tr>
    
        <th><label>Ocupação</label></th>
        
        <td>
            <select name="ocupacao">
                <option value="">Selecione</option>
                <?php $areas = get_theme_option('ocupacoes'); $areas = explode("\n", $areas); ?>
                
                <?php foreach ($areas as $area): ?>
                    
                    <?php $san_area = esc_attr(trim($area)); ?>
                        
                    <option value="<?php echo $san_area; ?>" <?php if (get_user_meta($user->ID, 'ocupacao', true) == $san_area) echo 'selected'; ?> ><?php echo $area; ?></option>
                
                <?php endforeach; ?>
                
                <option value="outra" <?php if (get_user_meta($user->ID, 'ocupacao', true) == 'outra') echo 'selected'; ?> >Outra</option>
                
            </select>
            
            <div id="outra_ocupacao_container">
                <p>
                    Especifique: <br /> <input type="text" name="ocupacao_outra" value="<?php echo esc_attr(get_user_meta($user->ID, 'ocupacao_outra', true)); ?>" />
                </p>
            </div>
            
        </td>
    
    </tr>
    
    <?php if (current_user_can('edit_users')): ?>
    
        <?php /* Essas opções só existem para um grupo de usuários que foram importados diretamente a partir de uma base existente
              /* não se aplicam a novos cadastros */
        ?>
    
        <tr>
        
            <th><label>Campos dos usuários pré-cadastrados</label></th>
            
            <td>
                
                Categoria: <br /> <input type="text" name="categoria" value="<?php echo esc_attr(get_user_meta($user->ID, 'categoria', true)); ?>" />
                <br /><br />
                Sub-Categoria: <br /> <input type="text" name="sub_categoria" value="<?php echo esc_attr(get_user_meta($user->ID, 'sub_categoria', true)); ?>" />
                
            </td>
        
        </tr>
        
    <?php endif; ?>
    
    <tr>
    
        <th><label>Entidade que representa</label></th>
        
        <td>
            <label>Nome da entidade</label><br />
            <input id="instituicao_nome" type="text" name="instituicao_nome" value="<?php echo esc_attr(get_user_meta($user->ID, 'instituicao', true)); ?>" /><br />            
            <label>CNPJ</label><br />
            <input id="cnpj" type="text" name="cnpj" value="<?php echo esc_attr(get_user_meta($user->ID, 'cnpj', true)); ?>" />
        </td>
    
    </tr>
    
    </table>
    
    <?php
    
}

add_action('edit_user_profile_update', 'minc_save_user_details');
/**
 * Save creators custom fields add via 
 * administrative profile edit page.
 * 
 * @param int $user_id
 * @return null
 */
function minc_save_user_details($user_id) {
    
    
    
    update_user_meta($user_id, 'cpf', $_POST['cpf']);
    update_user_meta($user_id, 'estado', $_POST['estado']);
    update_user_meta($user_id, 'municipio', $_POST['municipio']);
    update_user_meta($user_id, 'atuacao', $_POST['atuacao']);
    update_user_meta($user_id, 'atuacao_outra', $_POST['atuacao_outra']);
    update_user_meta($user_id, 'ocupacao', $_POST['ocupacao']);
    update_user_meta($user_id, 'ocupacao_outra', $_POST['ocupacao_outra']);
    update_user_meta($user_id, 'instituicao', $_POST['instituicao_nome']);
    update_user_meta($user_id, 'cnpj', $_POST['cnpj']);
    
    if (current_user_can('edit_users')) {
        update_user_meta($user_id, 'categoria', $_POST['categoria']);
        update_user_meta($user_id, 'sub_categoria', $_POST['sub_categoria']);
    }
    
    

}

function minc_get_cities_options($uf, $selected = '') {
    global $wpdb;

var_dump($selected);

    $uf_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM uf WHERE sigla LIKE %s", $uf));

    if (!$uf_id) {
        return "<option value=''>Selecione um estado...</option>";
    }

    $cidades = $wpdb->get_results($wpdb->prepare("SELECT * FROM municipio WHERE ufid = %d order by nome", $uf_id));
    
    $o = '';
    
    
    if (is_array($cidades) && count($cidades) > 0) {

        foreach ($cidades as $cidade) {
            $sel = $cidade->nome == $selected ? 'selected' : '';
            $o .= "<option value='{$cidade->nome}' $sel>{$cidade->nome}</option>";
        }

    }
    
    return $o;
    
}

function minc_print_cities_options() {

    echo minc_get_cities_options($_POST['uf'], $_POST['selected']);
    die;
}
add_action('wp_ajax_nopriv_pnc_get_cities_options', 'minc_print_cities_options');
add_action('wp_ajax_pnc_get_cities_options', 'minc_print_cities_options');

function get_states() {
    global $wpdb;
    return $wpdb->get_results("SELECT * from uf ORDER BY sigla");
}
