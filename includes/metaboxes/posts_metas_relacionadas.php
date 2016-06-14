<?php

add_action( 'add_meta_boxes', 'posts_metas_relacionadasadd_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'posts_metas_relacionadassave_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function posts_metas_relacionadasadd_custom_box() {
    add_meta_box( 
        'metas_relacionadas',
        'Metas Relacionadas',
        'posts_metas_relacionadasinner_custom_box_callback_function',
        'post', // em que post type eles entram?
        'normal', // onde? side, normal, advanced
        'high'//,'default' // 'high', 'core', 'default' or 'low'
        //,array('variáve' => 'valor') // variaveis que serão passadas para o callback
    );
}

/* Prints the box content */
function posts_metas_relacionadasinner_custom_box_callback_function() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( 'save_metas', 'posts_metas_relacionadasnoncename' );
    
    $__metas = get_posts("numberposts=-1&post_type=metas&orderby=meta_value&order=ASC&meta_key=_numero");
    $metas_releacionadas = get_post_meta($post->ID, '_metas_relacionadas_ids');
    
    $subject = "PNC Notícias - {$post->post_title}";
    $content = "Nova notícia publicada: <a id='notice_link' href='" . get_permalink($post->ID) . "'>{$post->post_title}</a><br/><br/>Você recebeu este e-mail porque foi publicada uma notícia relacionada a metas de seu interesse. Se não quiser mais receber mensagens como esta, acesse sua conta e edite a <a href=\"" . get_permalink(get_page_id_by_template('tpl-instrucoes-metas.php')) . "\">lista de metas de seu interesse</a>.";
    
    ?>
    
    <label>Selecione as metas relacionadas</label><br /> 
    <div style="width: 100%; height: 400px; overflow-y: scroll">
        <table cellpadding="3">
            <?php foreach ($__metas as $__meta): ?>
                <?php $number = get_post_meta($__meta->ID, '_numero', true); ?>
                <tr>
                    <td valign="top">
                        <input type="checkbox" name="_metas_relacionadas_ids[]" value="<?php echo $__meta->ID; ?>" id="meta_relacionada_<?php echo $__meta->ID; ?>" <?php if (in_array($__meta->ID, $metas_releacionadas)) echo 'checked'; ?> />
                    </td>
                    <td>
                        <?php echo $number; ?> - 
                        <label for="meta_relacionada_<?php echo $__meta->ID; ?>"><?php echo $__meta->post_title; ?></label>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <hr />
    <input type="checkbox" id="atualizar_avisar" name="atualizar_avisar" /> <label for="atualizar_avisar"><b>Ao publicar esta notícia, Avisar por e-mail as pessoas que acompanham metas relacionadas a ela</b></label>
    <div id="atualizar_msg_container"  style="display:none">
        <p><b>Assunto:</b> <span id="mail_subject"><?php echo $subject; ?></span></p>
        <input type="hidden" name="subject" value="<?php echo htmlspecialchars($subject); ?>" /> 
        
        <p><b>Texto padrão:</b> <span id="notice_content"><?php echo $content; ?></span></p>
        <input type="hidden" name="msg_content" value="<?php echo htmlspecialchars($content); ?>" />
        
        <p>Opcionalmente, adicione uma mensagem no corpo do e-mail:</p>
        <textarea id="custom_msg" name="custom_msg" style="width:100%"></textarea>
    </div>
    
    <script>
    
    jQuery(document).ready(function() {
        jQuery('#atualizar_avisar').click(function() {
            if (jQuery(this).is(':checked')) {
                jQuery('#atualizar_msg_container').slideDown();
            } else {
                jQuery('#atualizar_msg_container').slideUp();
            }
        });
        
        jQuery('#title').change(function () {
            new_title = 'PNC Notícias - ' + jQuery(this).val();
            jQuery('#mail_subject').text(new_title);
            jQuery('input[name="subject"]').val(new_title);
            jQuery('#notice_link').text(new_title);
            jQuery('input[name="msg_content"]').val(jQuery('#notice_content').html());
        });
    });
        
    </script>

    <?php
}

/* When the post is saved, saves our custom data */
function posts_metas_relacionadassave_postdata( $post_id ) {
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if ( !isset($_POST['posts_metas_relacionadasnoncename']) || !wp_verify_nonce( $_POST['posts_metas_relacionadasnoncename'], 'save_metas' ) )
        return;


    // Check permissions
    if ( 'post' != $_POST['post_type'] ) 
        return;

    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
    
    $post = get_post($post_id);
    
    // por algum motivo está entrando duas vezes nesse função, uma
    // com post_type post e outra post_type revision
    if ($post->post_type != 'post') {
        return;
    }
    
    $relatedMetas = $_POST['_metas_relacionadas_ids'];
    
    delete_post_meta($post_id, '_metas_relacionadas_ids');
    if (isset($relatedMetas) && is_array($relatedMetas)) {
        foreach ($relatedMetas as $meta_id) {
            add_post_meta($post_id, '_metas_relacionadas_ids', $meta_id);
        }
        
        // envia e-mails aos usuários que acompanham as metas relacionadas a esta notícia
        if (isset($_POST['atualizar_avisar']) && $_POST['atualizar_avisar'] == 'on' && !empty($relatedMetas)) {
            send_meta_updated_notification($relatedMetas);
        }
    }
}
