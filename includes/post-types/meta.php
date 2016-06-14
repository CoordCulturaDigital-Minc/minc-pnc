<?php
class Metas {
    const NAME = 'Metas';
    const MENU_NAME = 'Meta';

    static function init(){
        // o slug do post type
        
        
        add_action( 'init', array(__CLASS__, 'register') ,0);
        
        //add_action( 'save_post', array(__CLASS__, 'metabox_video_save_postdata') );
        // descomente se precisar de taxonomias e configure as taxonomias na funcao register_taxonomies
        add_action( 'init', array(__CLASS__, 'register_taxonomies') ,0);
    }
    
    static function register(){
        register_post_type('metas', array(
                
                'labels' => array(
                                    'name' => _x(self::NAME, 'post type general name'),
                                    'singular_name' => _x('Meta', 'post type singular name'),
                                    'add_new' => _x('Adicionar Nova', 'image'),
                                    'add_new_item' => __('Adicionar nova Meta'),
                                    'edit_item' => __('Editar Meta'),
                                    'new_item' => __('Nova Meta'),
                                    'view_item' => __('Ver Meta'),
                                    'search_items' => __('Search Metas'),
                                    'not_found' =>  __('Nenhuma Meta Encontrada'),
                                    'not_found_in_trash' => __('Nenhuma Meta na Lixeira'),
                                    'parent_item_colon' => ''
                                 ),
                 'public' => true,
                 'rewrite' => array('slug' => 'metas'),
                 'capability_type' => 'post',
                 'hierarchical' => false,
                 'map_meta_cap' => true,
                 'menu_position' => 6,
                 'has_archive' => true,
                 'supports' => array(
                     	'title',
                     	'editor',
                     	'comments',
                 ),
            )
        );
    }
    
    static function register_taxonomies(){
        $labels = array(
            'name' => _x( 'Tag', 'taxonomy general name' ),
            'singular_name' => _x( 'Tags', 'taxonomy singular name' ),
            'search_items' =>  __( 'Buscar Tags' ),
            'all_items' => __( 'Todas Tags' ),
            'parent_item' => __( 'Parent Taxonomia' ),
            'parent_item_colon' => __( 'Parent Taxonomia:' ),
            'edit_item' => __( 'Editar Tag' ), 
            'update_item' => __( 'Atualizar Tag' ),
            'add_new_item' => __( 'Adicionar Nova Tag' ),
            'new_item_name' => __( 'Nome da Novo Tag' ),
        );  

        register_taxonomy('tags_metas', array('metas'), array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => true,
            )
        );
        
        $labels = array(
            'name' => _x( 'Tema', 'taxonomy general name' ),
            'singular_name' => _x( 'Tema', 'taxonomy singular name' ),
            'search_items' =>  __( 'Buscar Temas' ),
            'all_items' => __( 'Todos Temas' ),
            'parent_item' => __( 'Parent Taxonomia' ),
            'parent_item_colon' => __( 'Parent Taxonomia:' ),
            'edit_item' => __( 'Editar Tema' ), 
            'update_item' => __( 'Atualizar Tema' ),
            'add_new_item' => __( 'Adicionar Novo Tema' ),
            'new_item_name' => __( 'Nome do Novo Tema' ),
        ); 	

        register_taxonomy('tema',array('metas'), array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => true,
            )
        );
        
        $labels = array(
            'name' => _x( 'Ações', 'taxonomy general name' ),
            'singular_name' => _x( 'Ação', 'taxonomy singular name' ),
            'search_items' =>  __( 'Buscar Ações' ),
            'all_items' => __( 'Todas as ações' ),
            'parent_item' => __( 'Ação mãe' ),
            'parent_item_colon' => __( 'Parent Taxonomia:' ),
            'edit_item' => __( 'Editar Ação' ), 
            'update_item' => __( 'Atualizar Ação' ),
            'add_new_item' => __( 'Adicionar Nova Ação' ),
            'new_item_name' => __( 'Nome da nova ação' ),
        ); 	

        register_taxonomy('acao', array('metas'), array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => false,
            )
        );
        
        $labels = array(
            'name' => _x( 'Tipos', 'taxonomy general name' ),
            'singular_name' => _x( 'Tipo', 'taxonomy singular name' ),
            'search_items' =>  __( 'Buscar tipo' ),
            'all_items' => __( 'Todos os tipos' ),
            'parent_item' => __( 'Tipo pai' ),
            'parent_item_colon' => __( 'Parent Taxonomia:' ),
            'edit_item' => __( 'Editar tipo' ), 
            'update_item' => __( 'Atualizar tipo' ),
            'add_new_item' => __( 'Adicionar novo tipo' ),
            'new_item_name' => __( 'Nome do novo tipo' ),
        );  

        register_taxonomy('tipo', array('metas'), array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => false,
            )
        );
        
    }
}

add_action('wp_print_scripts', 'minc_metas_js');

function minc_metas_js() {

    wp_enqueue_script('archive-meta', get_stylesheet_directory_uri() . '/js/archive-meta.js', array('jquery'));

}


Metas::init();

add_filter('the_title', 'mincpnc_filter_meta_title', 10, 2);

function mincpnc_filter_meta_title($title, $id) {
    if (is_admin())
        return $title;
        
    $num = remove_left_zero( get_post_meta($id, '_numero', true) );
    if ($num) {
        $title = '<span class="number"><span>Meta</span>' . $num . '</span>' . '<span class="title">' . $title . '</span>';
    }
    
    return $title;
}


add_action('pre_get_posts', 'minc_metas_change_default_order');

function minc_metas_change_default_order($wp_query) {
    
    if ( !$wp_query->is_main_query() || ! ( is_post_type_archive('metas') || is_tax('tags_metas') || is_tax('tema') ) ) return;
    
    $wp_query->query_vars['orderby'] = 'meta_value';
    $wp_query->query_vars['order'] = 'ASC';
    $wp_query->query_vars['meta_key'] = '_numero';
        
}



add_filter('manage_posts_columns', 'minc_metas_columns');  
add_action('manage_metas_posts_custom_column', 'minc_metas_columns_content', 10, 2);  

function minc_metas_columns($defaults) {  
    global $post_type;
    
    if ($post_type != 'metas')
        return $defaults;
    
    #unset($defaults['date']);
    
    $new = array();
    $insert = true;
    
    foreach ($defaults as $key => $de) {
        
        $new[$key] = $de;
        
        if ($insert)
            $new['numero'] = '#';
        
        $insert = false;
        
    }
    
    #$defaults['date'] = __('Date');  
    $new['posts_relacionados'] = "Notícias";
    $new['atualizacoes'] = "Última atualização / total de atualizações";
    unset($new['date']); 
    return $new;  
}


function minc_metas_columns_content($column_name, $post_ID) {
    if ($column_name == 'numero') {  
        
        $numero = get_post_meta($post_ID, '_numero', true);
        echo $numero;
        
    }  elseif ($column_name == 'posts_relacionados') {
        global $wpdb;
        $numero = $wpdb->get_var("SELECT COUNT(post_id) FROM $wpdb->postmeta WHERE meta_key = '_metas_relacionadas_ids' AND meta_value = $post_ID");
        echo '<a href="'.get_permalink($post_ID).'">';
        echo $numero;
        echo '</a>';
    } elseif ($column_name == 'atualizacoes') {
        $ultima = get_post_meta($post_ID, '_ultima_atualizacao', true);
        $total_atualizacoes = get_post_meta($post_ID, '_total_atualizacoes', true);
        if ($ultima) $ultima = date('d/m/Y', strtotime($ultima));
        echo $ultima;
        if ($total_atualizacoes) echo ' / ', $total_atualizacoes;
    }
} 
