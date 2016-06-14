<?php

if (!current_user_can('edit_posts')) { // only subscribers cant
    add_action('admin_menu', 'mincpnc_remove_menus');
    add_action('admin_bar_menu', 'mincpnc_edit_adminbar',25);
    if (!defined('DOING_AJAX'))
        add_action('admin_init', 'mincpnc_redirect_to_profile');
}

function mincpnc_remove_menus() {
    remove_menu_page('index.php');
}

function mincpnc_edit_adminbar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}


add_filter('login_redirect', 'mincpnc_login_redirect', 10, 3);

function mincpnc_login_redirect($redirect_to, $current_redirect, $user) {
    
    if (is_object($user) && !is_wp_error($user)) {
        $meta = get_user_meta($user->ID, 'mincpnc_skip_instructions', true);
        if (!$meta) {
            $page_id = get_page_id_by_template('tpl-instrucoes-metas.php');
            if ($page_id)
                $redirect_to = add_query_arg( array('logged_in' => 1, 'redirect_to' => $current_redirect), get_permalink( $page_id ));
        }
    }
    return $redirect_to;

}

function mincpnc_redirect_to_profile() {
    global $pagenow;
    if ($pagenow != 'profile.php')
        wp_safe_redirect(admin_url('profile.php'));
}
