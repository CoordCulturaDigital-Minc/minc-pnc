<?php
/*
Plugin Name: Botão Acompanhe as metas
*/

class WidgetAcompanheAsMetas extends WP_Widget {
    function WidgetAcompanheAsMetas() {
        $widget_ops = array('classname' => 'Acompanhe', 'description' => 'Adiciona o botão "Acompanhe as metas" e login/cadastro' );
        parent::WP_Widget('Acompanhe', 'Botão Acompanhe as Metas', $widget_ops);

    }
 
    function widget($args, $instance) {
        extract($args);
        ?>
        <div class="follow">
            <a href="<?php echo mincpnc_acompanhe_as_metas_link(); ?>"><?php html::image("acompanhe-as-metas.png", "Acompanhe as Metas") ?></a>
        </div>
        <div id="loginbox">
            <?php if (!is_user_logged_in()): ?>
                <a href="<?php echo wp_login_url(); ?>?redirect_to=<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-small btn-red">LOGIN</a>
                <a href="<?php echo home_url('cadastro'); ?>" class="btn btn-small btn-red">CADASTRO</a>
            <?php else: ?>
                <a href="<?php echo admin_url('profile.php'); ?>" class="btn btn-small btn-red">EDITAR PERFIL</a>
                <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-small btn-red">SAIR</a>
            <?php endif; ?>	
        </div>
        <?php
    }
 
 
}

function registerWidgetAcompanheAsMetas() {
    register_widget("WidgetAcompanheAsMetas");
}

add_action('widgets_init', 'registerWidgetAcompanheAsMetas');
    
?>
