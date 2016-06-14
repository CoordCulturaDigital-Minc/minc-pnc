<?php 
/*
 * IMPORTANTE
 * substituir todos os minc pelo slug do projeto
 */


require_once dirname(__FILE__).'/includes/template-widgets/WidgetTemplate.php';


require_once dirname(__FILE__).'/includes/congelado-functions.php';
require_once dirname(__FILE__).'/includes/html.class.php';
require_once dirname(__FILE__).'/includes/utils.class.php';
require_once dirname(__FILE__).'/includes/form.class.php';

require_once dirname(__FILE__).'/includes/admin-hacks-for-subscribers.php';

require_once dirname(__FILE__).'/includes/order-terms/customtaxorder.php';


require_once(__DIR__ . '/includes/custom_profile.php');

add_action( 'after_setup_theme', 'minc_setup' );
function minc_setup() {

    load_theme_textdomain('minc', TEMPLATEPATH . '/languages' );

    // POST THUMBNAILS
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size( 200, 120, true );

 

    //REGISTRAR AQUI TODOS OS TAMANHOS UTILIZADOS NO LAYOUT
    add_image_size( 'highlight', 442, 235, true );
    //add_image_size('nome',X,Y);
    //add_image_size('nome2',X,Y);

    // AUTOMATIC FEED LINKS
    add_theme_support('automatic-feed-links');

    // CUSTOM IMAGE HEADER
    // define('HEADER_TEXTCOLOR', '000000');
    // define('HEADER_IMAGE_WIDTH', 980); 
    // define('HEADER_IMAGE_HEIGHT', 176);

    // add_theme_support(
    //     'custom-header', 
    //     array('wp-head-callback' => 'minc_custom_header', 'admin-head-callback' => 'minc_admin_custom_header')
    // );

    // register_default_headers( array(
    //     'Mundo' => array(
    //         'url' => '%s/img/headers/image001.jpg',
    //         'thumbnail_url' => '%s/img/headers/image001-thumbnail.jpg',
    //     ),
    //     'Árvores' => array(
    //         'url' => '%s/img/headers/image002.jpg',
    //         'thumbnail_url' => '%s/img/headers/image002-thumbnail.jpg',
    //         'description' => 'barco'
    //     ),
    //     'Caminho' => array(
    //         'url' => '%s/img/headers/image003.jpg',
    //         'thumbnail_url' => '%s/img/headers/image003-thumbnail.jpg',
    //     ),
    // ) );

    // CUSTOM BACKGROUND
    // add_theme_support('custom-background');
}



function new_headerurl($url){
    return get_bloginfo('url');
}
function new_headertitle($url){
    return get_bloginfo('sitetitle');
}
add_filter('login_headerurl','new_headerurl');
add_filter('login_headertitle','new_headertitle');

//header da página de login do wordpress
add_action('login_head', function() {
    wp_register_script('minc-pnc-login', get_stylesheet_directory_uri() . '/js/minc-pnc-login.js', array('jquery'));
    wp_print_scripts(array('minc-pnc-login'));
    
    ?>
    <style type="text/css">
        #login h1 a {background-image: url(<?php bloginfo('stylesheet_directory'); echo '/img/banner_pnc_peq.png'; ?> ); height: 103px; background-size: auto; background-position: center;}
    </style>
    <?php
});

// admin_bar removal
//wp_deregister_script('admin-bar');
//wp_deregister_style('admin-bar');
remove_action('wp_footer','wp_admin_bar_render',1000);
function remove_admin_bar(){
   return false;
}
add_filter( 'show_admin_bar' , 'remove_admin_bar');

// JS
add_action('wp_print_scripts', 'minc_addJS');
function minc_addJS() {
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); 
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-widget');
    
    wp_enqueue_script('jquery-autocomplete', get_stylesheet_directory_uri().'/js/jquery-ui-1.8.20-autocomplete.js', array('jquery-ui-widget'));
    wp_enqueue_script('congelado', get_stylesheet_directory_uri().'/js/congelado.js', 'jquery-autocomplete');

    wp_enqueue_script('minc-pnc', get_stylesheet_directory_uri().'/js/minc-pnc.js', array('jquery'));
    
    wp_localize_script('congelado', 'vars', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
    
    #wp_enqueue_style('jquery-autocomplete',get_stylesheet_directory_uri().'/css/jquery-ui-1.8.20.custom.css');
    
    if (is_admin()) {
        global $pagenow;
        #var_dump($pagenow); die;
        if ($pagenow == 'profile.php' || $pagenow == 'user-edit.php' ) {
            wp_enqueue_script('cadastro', get_stylesheet_directory_uri() . '/js/cadastro.js', array('jquery'));
            wp_localize_script('cadastro', 'pnc', array( 'ajaxurl' => admin_url('admin-ajax.php') ));
        }
    }
}

add_action('admin_print_styles', 'minc_addAdminCSS');
function minc_addAdminCSS() {
    wp_enqueue_style('minc-pnc_admin', get_stylesheet_directory_uri() . '/css/admin.css');
}

// CUSTOM MENU
add_action( 'init', 'minc_custom_menus' );
function minc_custom_menus() {
    register_nav_menus( array(
        'main_menu' => __('Menu Principal', 'minc'),
        'footer_menu_1' => __('Menu do Rodapé (1ª coluna)', 'minc'),
        'footer_menu_2' => __('Menu do Rodapé (2ª coluna)', 'minc'),
        'footer_menu_3' => __('Menu do Rodapé (3ª coluna)', 'minc'),
    ) );
}

// SIDEBARS
if(function_exists('register_sidebar')) {
    // sidebar 
    register_sidebar( array(
        'id' => 'main-sidebar',
        'name' =>  'Main Sidebar',
        'description' => __('Sidebar', 'minc'),
        'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content clearfix">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ) );
}

// EXCERPT MORE

add_filter('utils_excerpt_more_link', 'minc_utils_excerpt_more',10,2);
function minc_utils_excerpt_more($more_link, $post){
    return '...<br /><a class="more-link" href="'. get_permalink($post->ID) . '">' . __('Continue reading &raquo;', 'minc') . '</a>';
}


add_filter( 'excerpt_more', 'minc_auto_excerpt_more' );
function minc_auto_excerpt_more( $more ) {
    global $post;
    return '...<br /><a class="more-link" href="'. get_permalink($post->ID) . '">' . __('Continue reading &raquo;', 'minc') . '</a>';
}

add_filter('excerpt_length', 'minc_excerpt_length');
function minc_excerpt_length($length) {
    return 20;
}

// SETUP
if (!function_exists('minc_custom_header')) :

    function minc_custom_header() {
        ?><style type="text/css">
            #branding {
                background: url(<?php header_image(); ?>);
            }
                
            #branding, #branding a, #branding a:hover {
                color: #<?php header_textcolor(); ?> !important;
            }
            #branding a:hover {
                text-decoration: none; 
            }
            #description { 
                filter: alpha(opacity=60);
                opacity: 0.6;
            }
        
        </style><?php

    }

endif;

if (!function_exists('minc_admin_custom_header')) :

    function minc_admin_custom_header() {
        ?><style type="text/css">
        
           #headimg {
                padding:55px 10px;
                width: 960px !important;
                height: 66px !important;
                min-height: 66px !important;
            }
        
            #headimg h1 {
                font-size:36px;
                line-height:44px;
                font-weight:normal !important;
                margin: 0px;
                margin: 0 10px;            
            }
        
            #headimg h1 a {
                text-decoration: none !important;
            }
        
            #headimg #desc { 
                font-style: italic; 
                font-size: 16px; 
                margin: 0 10px;
                filter: alpha(opacity=60);
                opacity: 0.6;
            }

        </style><?php
    }

endif;

// COMMENTS
if (!function_exists('minc_comment')):

    function minc_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class("comment clearfix"); ?> id="comment-<?php comment_ID(); ?>">
            <p class="comment-meta alignright bottom">
                <small><?php comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'])) ?> <?php edit_comment_link( __('Edit', 'minc'), '| ', ''); ?></small>
            </p>    
            <p class="comment-meta bottom">
                <?php printf( '<strong>%s</strong> disse em <em>%s</em> às <em>%s</em>', get_comment_author_link(), get_comment_date(), get_comment_time()); ?>
                <?php if($comment->comment_approved == '0') : ?><br/><em>Seu comentário ainda não foi aprovado.</em><?php endif; ?>
            </p>
            <div class="content">
                <?php comment_text(); ?>
            </div>
        </li>
        <?php
    }

endif; 




function validaCPF($cpf) {
    // Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

    // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
    {
        return false;
    } else {   // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}

/**
 * Adiciona uma classe a mais na tag atual das metas
 * para poder destacar ela no wp_tag_cloud
 */
add_filter('wp_tag_cloud', 'minc_highlight_current_tag');
function minc_highlight_current_tag($cloud) {
    if (is_tax('tags_metas')) {
        $tags = get_terms('tags_metas');
 
        foreach ($tags as $tag) {
            if (is_tax('tags_metas', $tag->term_id)) {
                $cloud = str_replace("tag-link-{$tag->term_id}", "current-term tag-link-{$tag->term_id}", $cloud);
            }
        }
    }

    return $cloud;
}

function print_msgs($msg, $extra_class='', $id=''){
    if(!is_array($msg))
        return false;

    foreach($msg as $type=>$msgs){
        if (!$msgs) continue;
        echo "<div class='$type $extra_class' id='$id'><ul>";
            if(!is_array($msgs)){
                echo "<li>$msgs</li>";
            }else{
                foreach ($msgs as $m){
                    echo "<li>$m</li>";
                }
             }
        echo "</ul></div>";
    }

}

// garante o funcionamento do site, em especial da página de cadastro
// caso o plugin frontend-messages não esteja instalado ou habilitado
if (!function_exists('_oi')) {
    function _oi($str) {
        echo $str;
    }

    function __i($str) {
        return $str;
    }
}

function get_page_id_by_template($template = '') {
    $page_id = false;
    if (!empty($template)) {
        global $wpdb;
        $page_id = $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_page_template' AND meta_value = %s LIMIT 1", $template) );
    }
    return $page_id;
}


function mincpnc_formulario_selecao_metas_interesse($doinglogin = false) {
    
    if (!is_user_logged_in())
        return;
    
    $cur_user = wp_get_current_user();
    
    $tags_followed = get_user_meta($cur_user->ID, 'tags_metas_followed');
    $temas_followed = get_user_meta($cur_user->ID, 'temas_followed');
    
    $temas = get_terms('tema', 'orderby=id&order=ASC');
    $tags = get_terms('tags_metas', 'orderby=id&order=ASC');
    
    require_once('includes/seleciona_metas_de_interesse.php');
    
}

function mincpnc_does_currentuser_follows_anything() {

    if (is_user_logged_in()) {
        $cur_user = wp_get_current_user();
        $tags_followed = get_user_meta($cur_user->ID, 'tags_metas_followed');
        $temas_followed = get_user_meta($cur_user->ID, 'temas_followed');
        
        if (is_array($temas_followed) && sizeof($temas_followed) > 0)
            return true;
            
        if (is_array($tags_followed) && sizeof($tags_followed) > 0)
            return true;
            
        global $wpdb;
        
        $following = $wpdb->get_col("SELECT DISTINCT post_id FROM $wpdb->postmeta WHERE meta_key = 'add_to_user_list' AND meta_value = {$cur_user->ID}");
        
        if (is_array($following) && sizeof($following) > 0)
            return true;
        
    }
    
    return false;

}

function mincpnc_acompanhe_as_metas_link() {
    
    $link = get_post_type_archive_link('metas');
    $linkInteresses = site_url('metas-de-meu-interesse');
    
    if (mincpnc_does_currentuser_follows_anything()) 
        return $linkInteresses;
        
    return $link;
    
}
mincpnc_acompanhe_as_metas_link();
//rewrite rules for metas-de-meu-interesse

add_filter('query_vars', 'mincpnc_custom_query_vars');
add_filter('rewrite_rules_array', 'mincpnc_custom_url_rewrites', 10, 1);
add_action('template_redirect', 'mincpnc_template_redirect_intercept');

function mincpnc_custom_query_vars($public_query_vars) {
    $public_query_vars[] = "minpnctpl";

    return $public_query_vars;
}

// REDIRECIONAMENTOS
function mincpnc_custom_url_rewrites($rules) {
    $new_rules = array(
        "metas-de-meu-interesse/?$" => "index.php?minpnctpl=metas-de-meu-interesse",
    );

    return $new_rules + $rules;
}

function mincpnc_template_redirect_intercept() {
    global $wp_query;

    if ( $wp_query->get('minpnctpl') && $wp_query->get('minpnctpl') == 'metas-de-meu-interesse' ) {
        if (is_user_logged_in()) {

            $wp_query->is_home = false;
            if (file_exists(TEMPLATEPATH . '/metas-de-meu-interesse.php')) 
            require(TEMPLATEPATH . '/metas-de-meu-interesse.php');
            die;
            
        } else {
            $wp_query->is_404 = true;
        }
    }
}


add_action('pre_get_posts', 'minc_metas_interesse_query');

function minc_metas_interesse_query($wp_query) {
    
    if (is_admin()) return;
    
    if ( is_user_logged_in() && $wp_query->get('minpnctpl') && $wp_query->get('minpnctpl') === 'metas-de-meu-interesse' ) {
        
        $cur_user = wp_get_current_user();
        
        if (!isset($wp_query->query_vars['meta_query']) || !is_array($wp_query->query_vars['meta_query'])) {
            $wp_query->query_vars['meta_query'] = array();
        }
        
        if (!isset($wp_query->query_vars['tax_query']) || !is_array($wp_query->query_vars['tax_query'])) {
            $wp_query->query_vars['tax_query'] = array('relation' => 'OR');
        }
        
        #$wp_query->query_vars['posts_per_page'] = -1;
        $wp_query->query_vars['post_type'] = 'metas';
        $wp_query->query_vars['is_post_type_archive'] = true;
        $wp_query->query_vars['is_home'] = false;
        
        $tags_followed = get_user_meta($cur_user->ID, 'tags_metas_followed');
        $temas_followed = get_user_meta($cur_user->ID, 'temas_followed');
        
        
        $has_preferences = false;
        #var_dump($temas_followed, $tags_followed);
        
        if (is_array($tags_followed) && sizeof($tags_followed) > 0) {
            array_push($wp_query->query_vars['tax_query'],
                array(
                    'taxonomy' => 'tags_metas',
                    'field' => 'term_id',
                    'terms' => $tags_followed,
                    'operator' => 'IN'
                )
            );
            $has_preferences = true;
        }
        
        if (is_array($temas_followed) && sizeof($temas_followed) > 0) {
            array_push($wp_query->query_vars['tax_query'],
                array(
                    'taxonomy' => 'tema',
                    'field' => 'term_id',
                    'terms' => $temas_followed,
                    'operator' => 'IN'
                )
            );
            $has_preferences = true;
        }
        global $wpdb;
        
        $hide = $wpdb->get_col("SELECT DISTINCT post_id FROM $wpdb->postmeta WHERE meta_key = 'remove_from_user_list' AND meta_value = {$cur_user->ID}");
        if (is_array($hide) && sizeof($hide) > 0)
            $wp_query->query_vars['post__not_in'] = $hide;
        
        if ($has_preferences) {
            add_filter('posts_where', 'mincpnc_add_post_in_class',10, 2);
        } else {
            $include = $wpdb->get_col("SELECT DISTINCT post_id FROM $wpdb->postmeta WHERE meta_key = 'add_to_user_list' AND meta_value = {$cur_user->ID}");
            if (is_array($include) && sizeof($include) > 0) {
                $wp_query->query_vars['post__in'] = $include;
                $has_preferences = true;
            }
            
        }
          
        function mincpnc_add_post_in_class($where, $query) {
            
            if (!$query->is_main_query() || !is_user_logged_in())
                return $where;
            
            $cur_user = wp_get_current_user();
            global $wpdb;
            
            $include = $wpdb->get_col("SELECT DISTINCT post_id FROM $wpdb->postmeta WHERE meta_key = 'add_to_user_list' AND meta_value = {$cur_user->ID}");
            
            if (is_array($include) && sizeof($include) > 0) {
                $post__in = implode(',', array_map( 'absint', $include ));
                $where .= " OR {$wpdb->posts}.ID IN ($post__in) AND $wpdb->postmeta.meta_key = '_numero'";
            }
            
            return $where;
                    
        }
        
        if (!$has_preferences)
            $wp_query->query_vars['post__in'] = array(-1);
        
        //var_dump($wp_query);
        $wp_query->query_vars['orderby'] = 'meta_value';
        $wp_query->query_vars['order'] = 'ASC';
        $wp_query->query_vars['meta_key'] = '_numero';
        $wp_query->query_vars['posts_per_page'] = '-1';
        
    }
}
/* Checa se uma meta é seguida por um usuário
 * considerando tanto tags, temas como as seleções individuais
 * Se nenhum ID de usuário é passado, consideramos o usuário atual
 */
function is_meta_followed_by_user($meta_id, $user_id = null) {
    
    if (is_null($user_id)) {
        $cur_user = wp_get_current_user();
        $user_id = $cur_user->ID;
    }
    
    $followed = false;
    
    $tags_followed = get_user_meta($user_id, 'tags_metas_followed');
    $temas_followed = get_user_meta($user_id, 'temas_followed');
    
    if ($temas_followed)
        $followed = is_object_in_term( $meta_id, 'tema', $temas_followed );
     
    if (!$followed && $tags_followed)
        $followed = is_object_in_term( $meta_id, 'tags_metas', $tags_followed );
    
    global $wpdb;
    
    if ($followed) {
        $followed = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'remove_from_user_list' AND meta_value = $user_id AND post_id = $meta_id") ? false : true;
    } else {
        $followed = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'add_to_user_list' AND meta_value = $user_id AND post_id = $meta_id") ? true : false;
    }
    
    return $followed;

}

/**
 * Retorna a lista de ids de usuários que seguem uma meta.
 * Verifica se o usuário segue a meta diretamente ou se segue
 * ela por meio de uma tag ou tema.
 * 
 * @param int $metaId id da meta
 * @return array lista dos ids dos usuários que seguem a meta
 */
function meta_followers($metaId) {
    $metaFollowers = array();

    // lista de usuários que seguem a meta diretamente
    $directFollowers = get_post_meta($metaId, 'add_to_user_list');
    
    // lista de usuários que excluiram a meta mesmo seguindo uma tag ou tema dela
    $directExcluded = get_post_meta($metaId, 'remove_from_user_list');

    // lista de usuários que seguem a meta pela tag
    $tags = get_the_terms($metaId, 'tags_metas');
    $tagFollowers = $tags ? term_followers('tags_metas', $tags) : array();
    
    // lista de usuários que seguem a meta pelo tema
    $temas = get_the_terms($metaId, 'tema');
    $themeFollowers = $temas ? term_followers('tema', $temas) : array();
    
    $metaFollowers = array_unique(array_merge($directFollowers, $tagFollowers, $themeFollowers));
    $metaFollowers = array_diff($metaFollowers, $directExcluded);
    
    return $metaFollowers;
}

/**
 * Retorna a lista de usuários que acompanha
 * um determinado grupo das taxonomias 'tags_metas'
 * ou 'tema'.
 * 
 * @param string $taxonomy 'tags_metas' ou 'tema'
 * @param array $tags uma lista de objetos da taxonomia
 * @return array lista de ids dos usuários que acompanham os itens da taxonomia
 */
function term_followers($taxonomy, array $terms) {
    global $wpdb;
    
    $termFollowers = array();
    
    if ($taxonomy == 'tags_metas') {
        $metaKey = 'tags_metas_followed';
    } else if ($taxonomy == 'tema') {
        $metaKey = 'temas_followed';
    }

    foreach ($terms as $term) {
        $userIds = $wpdb->get_col(
            $wpdb->prepare("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = %s AND meta_value = %d", $metaKey, $term->term_id)
        );
    
        $termFollowers = array_merge($termFollowers, $userIds);
    }
    
    return array_unique($termFollowers);
}

// define o email do admin do wordpress como remetente padrão
// para os emails enviados a partir do site
add_filter('wp_mail_from', function($from_name) {
    return get_option('admin_email');
});

// define o título do site como o nome padrão para o remetente
// para os emails enviados a partir do site
add_filter('wp_mail_from_name', function($from_email) {
    return get_option('blogname');
});

/**
 * Envia o e-mail para os usuários que acompanham
 * uma meta ou mais metas atualizadas ou que tiveram
 * uma notícia relacionada atualizada.
 *
 * @param int|array $metas id da meta ou metas
 * @return null
 */
function send_meta_updated_notification($metas) {
    if (is_numeric($metas)) {
        $metas = array($metas);
    }

    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $content = stripslashes($_POST['msg_content']);
    $custom_content = stripslashes(filter_input(INPUT_POST, 'custom_msg', FILTER_SANITIZE_STRING));

    $metaFollowers = array();
    
    foreach ($metas as $metaId) {
        $metaFollowers = array_merge($metaFollowers, meta_followers($metaId));
    }
    
    $metaFollowers = array_unique($metaFollowers);

    foreach ($metaFollowers as $userId) {
        $userInfo = get_userdata($userId);
        add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
        wp_mail($userInfo->user_email, $subject, nl2br($custom_content) . "<br /><br />" . $content);
    }
}

function add_meta_to_user($meta_id, $user = false) {

    if (false === $user)
        $user = wp_get_current_user();
    
    if (!$user)
        return false;
    
    global $wpdb;
    
    $already_followed = is_meta_followed_by_user($meta_id, $user->ID);
    
    if (!$already_followed) {
        if ($wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'remove_from_user_list' AND meta_value = $user->ID AND post_id = $meta_id"))
            delete_post_meta($meta_id, 'remove_from_user_list', $user->ID);
        else
            add_post_meta($meta_id, 'add_to_user_list', $user->ID);
    }
    
}


function remove_meta_from_user($meta_id, $user = false) {
    
    if (false === $user)
        $user = wp_get_current_user();
    
    if (!$user)
        return false;
    
    global $wpdb;
            
    $already_followed = is_meta_followed_by_user($meta_id, $user->ID);
    
    if ($already_followed)
        if ($wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'add_to_user_list' AND meta_value = $user->ID AND post_id = $meta_id"))
            delete_post_meta($meta_id, 'add_to_user_list', $user->ID);
        else
            add_post_meta($meta_id, 'remove_from_user_list', $user->ID);
    
}

add_action('wp_ajax_follow_unfollow_meta', 'mincpnc_ajax_follow_unfollow_meta');

function mincpnc_ajax_follow_unfollow_meta() {
    
    if (is_numeric($_POST['meta_id'])) {
        
        $meta_id = $_POST['meta_id'];
        
        if (isset($_POST['acompanhar_meta']) && $_POST['acompanhar_meta'] == 1) {
            add_meta_to_user($meta_id);
            die('Você acompanha esta meta');
        } else {
            remove_meta_from_user($meta_id);
            die('Acompanhe esta meta');
        }
        

    }
    
    die('erro ao salvar opção') ;

}


function add_left_zero($number) {

    if (!is_numeric($number))
        return false;
    
    $int = intval($number);
    
    if ($int < 10) 
        return "0" . (string) $int;
    else
        return $int;

}

function remove_left_zero($number) {

    if (!is_numeric($number))
        return false;
    
    $int = intval($number);

    return (string) $int;

}

/**
 * Envia um e-mail para o administrador do site com
 * a mensagem enviada por um usuário através do formulário
 * de contato (tpl-contato.php)
 * 
 * @return bool
 */
function minc_send_contact_form() {
    $to = get_option('admin_email');
    $subject = 'PNC - Nova mensagem enviada pelo formulário de contato';
    
    if (isset($_POST['usuario_conectado_login'])) {
        $name = filter_input(INPUT_POST, 'usuario_conectado_login', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'usuario_conectado_email', FILTER_SANITIZE_EMAIL);
    } else {
        $name = filter_input(INPUT_POST, 'user_nome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
    }
    
    $message = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);
    
    $content = "<strong>Nome:</strong> $name<br /><br />";
    $content .= "<strong>E-mail:</strong> $email<br /><br />";
    $content .= "<strong>Mensagem:</strong> " . nl2br($message);
    
    add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
    
    return wp_mail($to, $subject, $content);
}

add_filter( 'wp_image_editors', 'change_graphic_lib' );
function change_graphic_lib($array) {
  return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}
