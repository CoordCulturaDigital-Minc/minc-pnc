<?php

add_action( 'add_meta_boxes', 'metas_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'metas_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function metas_add_custom_box() {
    add_meta_box( 
        'metas',
        'Informações da meta',
        'metas_inner_custom_box_callback_function',
        'metas', // em que post type eles entram?
        'normal', // onde? side, normal, advanced
        'high'//,'default' // 'high', 'core', 'default' or 'low'
        //,array('variáve' => 'valor') // variaveis que serão passadas para o callback
    );
    
    add_meta_box( 
        'metas_atualizacao',
        'Atualização da meta',
        'metas_atualizacao_inner_custom_box_callback_function',
        'metas', // em que post type eles entram?
        'side', // onde? side, normal, advanced
        'high'//,'default' // 'high', 'core', 'default' or 'low'
        //,array('variáve' => 'valor') // variaveis que serão passadas para o callback
    );
}

/* Prints the box content */
function metas_inner_custom_box_callback_function() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( 'save_metas', 'metas_noncename' );
    
    $numero = get_post_meta($post->ID, '_numero', true);
    $objetivo = get_post_meta($post->ID, '_objetivo', true);
    $subtitulo = get_post_meta($post->ID, '_subtitulo', true);
    $situacao_atual = get_post_meta($post->ID, '_situacao_atual', true);
    $historico = get_post_meta($post->ID, '_historico', true);
    $embed_situacao_atual = get_post_meta($post->ID, '_embed_situacao_atual', true);
    $sendo_feito = get_post_meta($post->ID, '_sendo_feito', true);
    $mudancas_necessarias = get_post_meta($post->ID, '_mudancas_necessarias', true);
    $percentual = get_post_meta($post->ID, '_percentual', true);
    
    ?>
    
    <label for="numero">Número da meta</label><br />
    <select id="numero" name="numero">
        <?php
        foreach (range(1, 53) as $value) {
            $selected = '';
            
            $z_value = add_left_zero($value);
            
            if ($z_value == $numero) {
                $selected = ' selected="selected"';
            }
            
            echo "<option value='$z_value' $selected>{$value}</option>";
        }
        ?>
    </select>
    <br /><br />
    
    <label for="subtitulo">Subtítulo</label><br />
    <input type="text" id="subtitulo" name="subtitulo" value="<?php echo htmlspecialchars($subtitulo); ?>" size="80" />
    <br /><br />
    
    <label for="objetivo">Objetivo (texto laranja da publicação)</label><br />
    <input type="text" id="objetivo" name="objetivo" value="<?php echo htmlspecialchars($objetivo); ?>" size="80" />
    <br /><br />
    
    <label for="mudancas_necessarias">Como esta meta está sendo medida</label><br />
    <?php wp_editor($mudancas_necessarias, 'mudancas_necessarias'); ?>
    <br /><br />
    
    <label for="historico">Histórico da Meta</label><br />
    <?php wp_editor($historico, 'historico'); ?>
    <br /><br />
    
    <label for="situacao_atual">Situação atual</label><br />
    <?php wp_editor($situacao_atual, 'situacao_atual'); ?>
    <br /><br />
    
    <label for="embed_situacao_atual">Embed do gráfico da situação atual</label><br />
    <?php wp_editor($embed_situacao_atual, 'embed_situacao_atual'); ?>
    <br /><br />
    
    <label for="sendo_feito">O que está sendo feito para alcançar esta meta</label><br />
    <?php wp_editor($sendo_feito, 'sendo_feito'); ?>
    <br /><br />
    
    <label for="percentual">Percentual de realização da meta</label><br />
    <select id="percentual" name="percentual">
        <option value="sem_info">Sem informação</option>
        <?php
        foreach (range(1, 100) as $value) {
            $selected = '';
            
            if ($value == $percentual) {
                $selected = ' selected="selected"';
            }
            
            echo "<option value='$value' $selected>{$value}%</option>";
        }
        ?>
    </select>
    <br /><br />
    <style>
    .wp_themeSkin iframe { background-color: white; }
    </style>
    <?php
}

/* When the post is saved, saves our custom data */
function metas_save_postdata( $post_id ) {
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if ( !isset($_POST['metas_noncename']) || !wp_verify_nonce( $_POST['metas_noncename'], 'save_metas' ) )
        return;


    // Check permissions
    if ( 'metas' != $_POST['post_type'] ) 
        return;

    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
    
    update_post_meta($post_id, '_numero', trim($_POST['numero']));
    update_post_meta($post_id, '_subtitulo', trim($_POST['subtitulo']));
    update_post_meta($post_id, '_objetivo', trim($_POST['objetivo']));
    update_post_meta($post_id, '_situacao_atual', trim($_POST['situacao_atual']));
    update_post_meta($post_id, '_historico', trim($_POST['historico']));
    update_post_meta($post_id, '_embed_situacao_atual', trim($_POST['embed_situacao_atual']));
    update_post_meta($post_id, '_sendo_feito', trim($_POST['sendo_feito']));
    update_post_meta($post_id, '_mudancas_necessarias', trim($_POST['mudancas_necessarias']));
    update_post_meta($post_id, '_percentual', trim($_POST['percentual']));

}


function metas_atualizacao_inner_custom_box_callback_function() {
    global $post;
    
    $ultima = get_post_meta($post->ID, '_ultima_atualizacao', true);
    $numero = get_post_meta($post->ID, '_numero', true);
    
    if (!$ultima)
        $ultima = $post->post_date;
    
    $ultima = date('d/m/Y H:i', strtotime($ultima));
    
    ?>
    
    <b>Última atualização desta meta:</b><br/>
    <span id="atualizar_data"><?php echo $ultima; ?></span>
    <br/><br/>
    <input type="checkbox" id="atualizar_avisar" value="1" /> <label for="atualizar_avisar">Avisar por e-mail as pessoas que acompanham esta meta</label>
    <div id="atualizar_msg_container"  style="display:none">
        <p>
            <b>Assunto:</b> <span id="atualizar_subject">PNC - Atualização na meta <?php echo $numero; ?></span> 
        </p>
        
        <p>
            <b>Texto padrão:</b> <span id="atualizar_content">Informamos que a meta <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $numero; ?> - <?php echo $post->post_title; ?></a> foi atualizada. Acesse o <a href="<?php echo site_url(); ?>">site do PNC</a> para acompanhar a evolução da meta. <br/><br/>Você recebeu este e-mail porque esta é uma meta de seu interesse. Se não quiser mais receber mensagens como esta, acesse sua conta e edite a <a href="<?php echo get_permalink(get_page_id_by_template('tpl-instrucoes-metas.php')); ?>">lista de metas de seu interesse</a>.</span>
        </p>
        <p>Opcionalmente, adicione uma mensagem no início do corpo do e-mail:</p>
        <textarea id="atualizar_custom_msg" style="width:100%"></textarea>
    </div>
    
    <p>
    <input type="button" class="button-primary" id="atualizar_meta" value="Marcar atualização na meta!" />
    <img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" id="atualizar_ajax_feedback" style="display:none;" />
    </p>
    
    
    <script>
    
    jQuery(document).ready(function() {
        
        jQuery('#atualizar_avisar').click(function() {
            if (jQuery(this).is(':checked'))
                jQuery('#atualizar_msg_container').slideDown();
            else
                jQuery('#atualizar_msg_container').slideUp();
        });
        
        jQuery('#atualizar_meta').click(function() {
            
            var thisButton = this;
            jQuery('#atualizar_ajax_feedback').show();
            jQuery(this).attr('disabled', 'disabled');
            
            jQuery.post(ajaxurl, { action: 'atualiza_meta', post_id: jQuery('#post_ID').val(), avisa: jQuery('#atualizar_avisar').is(':checked'), subject: jQuery('#atualizar_subject').text(), msg_content: jQuery('#atualizar_content').html(), custom_msg: jQuery('#atualizar_custom_msg').val() }, function(response) {
            
                // verifica resposta
                if (response.error) {
                    alert('Erro ao atualizar');
                    return false;
                }
                
                // Limpa o form
                jQuery('#atualizar_custom_msg').val('');
                
                if (jQuery('#atualizar_avisar').is(':checked')) {
                    jQuery('#atualizar_avisar').click();
                    jQuery('#atualizar_msg_container').slideUp();
                }
                
                // esconde feedback
                jQuery('#atualizar_ajax_feedback').hide();
                jQuery(thisButton).removeAttr('disabled');
                
                //Atualiza a data
                jQuery('#atualizar_data').html(response.nova_data);
                
                // destaca a data modificada
                jQuery('#atualizar_data').animate({backgroundColor: "#EAF3FA"}, 500).animate({backgroundColor: "#FFF"}, 1000);
            });
        });
    });
    </script>
    
    <?php
}

add_action('wp_ajax_atualiza_meta', 'atualizar_meta_ajax_callback');

function atualizar_meta_ajax_callback() {
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    
    $metaId = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);

    send_meta_updated_notification($metaId);    
    
    $data = date('Y-m-d H:i:s');
    
    update_post_meta($metaId, '_ultima_atualizacao', $data);
    
    $total_atualizacoes = get_post_meta($metaId, '_total_atualizacoes', true);
    
    $total_atualizacoes = is_numeric($total_atualizacoes) ? intval($total_atualizacoes) : 0;
    $total_atualizacoes++;
    update_post_meta($metaId, '_total_atualizacoes', $total_atualizacoes);
    
    $response = array('nova_data' => date('d/m/Y H:i', strtotime($data)), 'error' => false);
    
    echo json_encode($response);
    
    die;
}

add_action('admin_print_footer_scripts','my_admin_print_footer_scripts',99);
function my_admin_print_footer_scripts()
{
    ?><script type="text/javascript">/* <![CDATA[ */
        jQuery(function($)
        {
            var i=1;
            $('textarea.customEditor').each(function(e)
            {
                var id = $(this).attr('id');
 
                if (!id)
                {
                    id = 'customEditor-' + i++;
                    $(this).attr('id',id);
                }
 
                tinyMCE.execCommand('mceAddControl', false, id);
                 
            });
        });
    /* ]]> */</script><?php
}
