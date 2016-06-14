<?php
/*
Template Name: Cadastro
*/

wp_enqueue_script('cadastro', get_stylesheet_directory_uri() . '/js/cadastro.js', array('jquery'));
wp_localize_script('cadastro', 'pnc', array( 'ajaxurl' => admin_url('admin-ajax.php') ));

if(isset($_POST['action']) && $_POST['action'] == 'register'){
    $user_login = sanitize_user($_POST['user_email']);
    $user_email = $_POST['user_email'];
    $user_pass = $_POST['user_pass'];
    $errors = array();
    
    if (!isset($_POST['concordo']) || $_POST['concordo'] != 1) {
        $errors['termos'] = 'É preciso concordar com os termos de uso da plataforma';
    }
    
    if(username_exists($user_login)){
        $errors['user'] =  __('Já existe um usário com este nome no nosso sistema. Por favor, escolha outro nome.', 'pnc');
    }

    if(email_exists($user_email)){
        $errors['email'] =  __('Este e-mail já está registrado em nosso sistema. Por favor, cadastre-se com outro e-mail.', 'pnc');
    }
    if(!filter_var( $user_email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] =  __('O e-mail informado é inválido.', 'tnb');
    }
    
    if($_POST['user_pass'] != $_POST['user_pass_c']){
        $errors['pass_confirm'] =  'As senhas informadas não são iguais.';
    }
    
    if (!validaCPF($_POST['cpf'])) 
        $errors['valid_cpf'] =  'CPF inválido';
    
    if(strlen($user_email)==0)
        $errors['email'] =  __('O e-mail é obrigatório para o cadastro no site.', 'pnc');
        
    if(strlen($_POST['nome'])==0)
        $errors['email'] =  __('O e-mail é obrigatório para o cadastro no site.', 'pnc');

    if(strlen($user_pass)==0 )
        $errors['pass'] =  'A senha é obrigatória para o cadastro no site.';
        
    if(strlen($_POST['estado'])==0 || strlen($_POST['municipio'])==0)
        $errors['local'] =  'Por favor selecione um estado e um município';

    if(!sizeof($errors)>0){
        
        //$user_pass = wp_generate_password();

        $data['user_login'] = $user_login;
        $data['user_pass'] = $user_pass;
        $data['user_email'] =  $user_email;
        $data['display_name'] = $_POST['nome'];
        
        $data['role'] = 'subscriber' ;
        $user_id = wp_insert_user($data);
        
        if ( ! $user_id ) {
            if ( $errmsg = $user_id->get_error_message('blog_title') )
                echo $errmsg;
        }
        
        update_user_meta($user_id, 'cpf', $_POST['cpf']);
        update_user_meta($user_id, 'estado', $_POST['estado']);
        update_user_meta($user_id, 'municipio', $_POST['municipio']);
        update_user_meta($user_id, 'atuacao', $_POST['atuacao']);
        update_user_meta($user_id, 'atuacao_outra', $_POST['atuacao_outra']);
        update_user_meta($user_id, 'ocupacao', (isset($_POST['ocupacao']) ? $_POST['ocupacao'] : ''));
        update_user_meta($user_id, 'ocupacao_outra', (isset($_POST['ocupacao_outra']) ? $_POST['ocupacao_ocupacao'] : ''));
        
        
        if ($_POST['instituicao_nome'])
            update_user_meta($user_id, 'instituicao', $_POST['instituicao_nome']);
            
        if ($_POST['cnpj'])    
            update_user_meta($user_id, 'cnpj', $_POST['cnpj']);
        
        wp_new_user_notification( $user_id, $user_pass );
        
        
        do_action('minc_user_register', $user_id);
        
        
        // depois de fazer o registro, faz login
        if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
            $secure_cookie = false;
        else
            $secure_cookie = '';

        $user = wp_signon(array('user_login' => $user_login, 'user_password' => $user_pass), $secure_cookie);

        if ( !is_wp_error($user) && (!isset($reauth) || !$reauth) ) {
            $redirect = isset($_POST['redirect_to']) && !empty($_POST['redirect_to']) && $_POST['redirect_to'] != site_url('cadastro') ? $_POST['redirect_to'] : get_permalink( get_page_id_by_template('tpl-instrucoes-metas.php') );
            wp_safe_redirect( $_POST['redirect_to'] );
            exit();
        }
    } else {
        foreach ($errors as $type => $msg) {
            $msgs['error'][] = $msg;
        }
    }
}


the_post();

?>

<?php get_header(); ?>
    <section id="main-section" class="clearfix">
        <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>
            <header>
                <h1>Cadastro</h1>
            </header>
            <div class="post-content clearfix">
                <?php
                if (isset($msgs) && !empty($msgs)) {
                    print_msgs($msgs);
                }
                ?>
                
                <?php if (!is_user_logged_in()): ?>
                
                    <?php the_content(); ?>
                    
                    <form method="post" class="form-horizontal">
                        <input type="hidden" name="redirect_to" value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''; ?>" />
                        <input type="hidden" name="action" value="register" />
                        
                        <fieldset>
                            <h3 class="top"><?php _oi('Dados para login no sistema', 'Cadastro: titulo da área de email e senha'); ?></h3>
                            <div class="control-group clearfix">
                                <label class="control-label">Email*</label>
                                <div class="controls">
                                    <input required="required" id="email" type="email" name="user_email" value="<?php echo isset($_POST['user_email']) ? esc_attr($_POST['user_email']) : ''; ?>" />
                                </div>
                            </div>

                            <div class="control-group clearfix">
                                <label class="control-label">Senha*</label>
                                <div class="controls">
                                    <input required="required" id="pass" type="password" name="user_pass" />
                                </div>
                            </div>
                        
                            <div class="control-group clearfix">
                                <label class="control-label">Confirmar senha*</label>
                                <div class="controls">
                                    <input required="required" id="pass_c" type="password" name="user_pass_c" />
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <h3 class="top"><?php _oi('Sobre você', 'Cadastro: titulo da área de nome, cpf, etc'); ?></h3>
                            <div class="control-group">
                                <label class="control-label">Nome*</label>
                                <div class="controls">
                                    <input required="required" id="nome" type="text" name="nome" value="<?php echo isset($_POST['nome']) ? esc_attr($_POST['nome']) : ''; ?>" />
                                </div>
                            </div>
                        
                            <div class="control-group">
                                <label class="control-label">CPF*</label>
                                <div class="controls">
                                    <input required="required" id="cpf" type="text" name="cpf" value="<?php echo isset($_POST['cpf']) ? esc_attr($_POST['cpf']) : ''; ?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Estado*</label>
                                <div class="controls">
                                    <select required="required" name="estado" id="estado">
                                        <option value=""> Selecione </option>
                                        <?php $states = get_states(); ?>
                                        <?php foreach ($states as $s): ?>
                                            <option value="<?php echo $s->sigla; ?>"  <?php if (isset($_POST['estado']) && $_POST['estado'] == $s->sigla) echo 'selected'; ?>  >
                                                <?php echo $s->nome; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Município*</label>
                                <div class="controls">
                                    <select required="required" name="municipio" id="municipio">
                                        <option value="">Selecione</option>
                                    </select>
                                </div>
                            </div>
                        
                            <div class="control-group">
                                <label class="control-label">Área de Atuação</label>
                                <div class="controls">
                                    <select name="atuacao" id="atuacao">
                                        <option value="">Selecione</option>
                                        <?php $areas = get_theme_option('areas_atuacao'); $areas = explode("\n", $areas); ?>
                                        <?php foreach ($areas as $area): ?>
                                            <?php $san_area = esc_attr(trim($area)); ?>
                                            <option value="<?php echo $san_area; ?>" <?php if (isset($_POST['atuacao']) && $_POST['atuacao'] == $san_area) echo 'selected'; ?> ><?php echo $area; ?></option>
                                        <?php endforeach; ?>
                                        <option value="outra_area_cultura" <?php if (isset($_POST['atuacao']) && $_POST['atuacao'] == 'outra_area_cultura') echo 'selected'; ?> >Outra área de cultura</option>
                                        <option value="nao_cultura" <?php if (isset($_POST['atuacao']) && $_POST['atuacao'] == 'nao_cultura') echo 'selected'; ?> >Não ligado(a) a nenhuma área cultural</option>
                                    </select>
                                </div>
                            </div>

                            <div id="atuacao_outra_container" class="control-group">
                                <label class="control-label">Especifique</label>
                                <div class="controls">
                                    <input type="text" name="atuacao_outra" value="<?php echo isset($_POST['atuacao_outra']) ? esc_attr($_POST['atuacao_outra']) : ''; ?>" />
                                </div>
                            </div>
                        
                            <!--
                            <div class="control-group">
                                <label class="control-label">Ocupação</label>
                                <div class="controls">
                                    <select required="required" name="ocupacao" id="ocupacao">
                                        <?php $areas = get_theme_option('ocupacoes'); $areas = explode("\n", $areas); ?>
                                        <?php foreach ($areas as $area): ?>
                                            <?php $san_area = esc_attr(trim($area)); ?>
                                            <option value="<?php echo $san_area; ?>" <?php if (isset($_POST['ocupacao']) && $_POST['ocupacao'] == $san_area) echo 'selected'; ?> ><?php echo $area; ?></option>
                                        <?php endforeach; ?>
                                        <option value="outra" <?php if (isset($_POST['ocupacao']) && $_POST['ocupacao'] == 'outra') echo 'selected'; ?> >Outra</option>
                                    </select>
                                </div>
                            </div>

                            <div id="ocupacao_outra_container" class="control-group">
                                <label class="control-label">Especifique:</label>
                                <div class="controls">
                                    <input type="text" name="ocupacao_outra" value="<?php echo isset($_POST['ocupacao_outra']) ? esc_attr($_POST['ocupacao_outra']) : ''; ?>" />
                                </div>
                            </div>
                            -->
                            <small>* Campos obrigatórios</small>
                        </fieldset>
                        
                        
                        <fieldset>
                            <h3 class="top"><?php _oi('Se você representa uma entidade, insira os dados abaixo', 'Cadastro: dados da entidade'); ?></h3>

                            <div class="control-group">
                                <label class="control-label">Nome da entidade</label>
                                <div class="controls">
                                    <input id="instituicao_nome" type="text" name="instituicao_nome" value="<?php echo isset($_POST['instituicao_nome']) ? esc_attr($_POST['instituicao_nome']) : ''; ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">CNPJ</label>
                                <div class="controls">
                                    <input id="cnpj" type="text" name="cnpj" value="<?php echo isset($_POST['cnpj']) ? esc_attr($_POST['cnpj']) : ''; ?>" />
                                </div>
                            </div>
                        </fieldset>
                        
                        <p class="textcenter">
                            <label>
                                <input type="checkbox" name="concordo" value="1" />
                                Li e concordo com os <a href="<?php echo site_url('termos-de-uso'); ?>">termos de uso</a>.
                            </label>
                        </p>
                        
                        <p class="textcenter">
                            <input type="submit" value="Cadastrar" class="btn btn-red" />
                        </p>
                    
                    </form>
 
                <?php else: ?>
                
                    <p>
                    <?php _oi('Você já está cadastrado!', 'Cadastro: Mensagem que aparece nesta página quando usuário já está logado'); ?>
                    </p>
                
                <?php endif; ?>
                
			</div>
			<!-- .post-content -->
		</article>
		<!-- .post -->
	</section>
	<!-- #main-section -->
	<aside id="main-sidebar" class="span-6 append-1 last">
		<?php get_sidebar(); ?>
	</aside>
<?php get_footer(); ?>
