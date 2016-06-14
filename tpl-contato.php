<?php
/*
Template Name: Formulário de Contato
*/


the_post();

//TODO: Enviar formulario

if (isset($_POST['send-contato']) && $_POST['send-contato']) {
    minc_send_contact_form();    
    
    $msgs = array();

    $msgs['success'] = array();
    $msgs['success'][] = 'Mensagem enviada!';

}
?>

<?php get_header(); ?>
    <section id="main-section" class="clearfix">
        <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>
            <header>
                <h1><?php the_title(); ?></h1>
            </header>
            <div class="post-content clearfix">
                
                <?php
                if (isset($msgs) && !empty($msgs)) {
                    print_msgs($msgs);
                }
                ?>
                    <?php if(get_the_content()) : ?>
                        <?php the_content(); ?>
                        <hr />
                    <?php endif; ?>
                    <form method="post" class="form-horizontal">
                        <fieldset>
                            <?php if (is_user_logged_in()): ?>
                                <?php $cur_user = wp_get_current_user(); ?>
                                <input type="hidden" name="usuario_conectado_login" value="<?php echo $cur_user->user_login; ?>" />
                                <input type="hidden" name="usuario_conectado_email" value="<?php echo $cur_user->user_email; ?>" />
                                
                                <p>Conectado como <a href="<?php print get_option('siteurl'); ?>/wp-admin/profile.php"><?php print $cur_user->display_name; ?></a>. <a href="<?php print get_option('siteurl'); ?>/wp-login.php?action=logout" title="Logout">Sair &raquo;</a></p>
                                
                            <?php else: ?>

                                <div class="control-group clearfix">
                                    <label class="control-label">Nome</label>
                                    <div class="controls">
                                        <input required="required" id="nome" type="text" name="user_nome" />
                                    </div>
                                </div>
                                
                                <div class="control-group clearfix">
                                    <label class="control-label">Email</label>
                                    <div class="controls">
                                        <input required="required" id="email" type="email" name="user_email" value="" />
                                    </div>
                                </div>


                            <?php endif; ?>
                            
                            
                        
                            <div class="control-group clearfix">
                                <label class="control-label">Mensagem</label>
                                <div class="controls">
                                    <textarea name="mensagem"></textarea>
                                </div>
                            </div>
                        </fieldset>

                        <p class="textcenter">
                            <input type="submit" name="send-contato" value="Enviar" class="btn btn-red" />
                        </p>
                    
                    </form>
 
                
                
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
