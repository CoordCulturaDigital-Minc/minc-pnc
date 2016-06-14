<?php
/**
 * BASEADO NO PLUGIN ABAIXO
 */
/*
Plugin Name: Custom Taxonomy Order
Plugin URI: http://drewgourley.com/order-up-custom-ordering-for-wordpress/
Description: Allows for the ordering of categories and custom taxonomy terms through a simple drag-and-drop interface.
Version: 2.0
Author: Drew Gourley
Author URI: http://drewgourley.com/
License: GPLv2 or later
 */


function customtaxorder_menu() {   
	add_submenu_page('edit.php?post_type=metas', __('Ordenar Temas'), __('Ordenar Temas'), 'manage_categories', 'customtaxorder-tema', 'customtaxorder');
}
function customtaxorder_css() {
	$pos_page = isset($_GET['page']) ? $_GET['page'] : '';
	$pos_args = 'customtaxorder';
	$pos = strpos($pos_page,$pos_args);
	if ( $pos === false ) {} else {
		wp_enqueue_style('customtaxorder', get_stylesheet_directory_uri().'/includes/order-terms/css/customtaxorder.css', 'screen');
	}
}
function customtaxorder_js_libs() {
	$pos_page = isset($_GET['page']) ? $_GET['page'] : '';
	$pos_args = 'customtaxorder';
	$pos = strpos($pos_page,$pos_args);
	if ( $pos === false ) {} else {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
	}
}
add_action('admin_menu', 'customtaxorder_menu');
add_action('admin_print_styles', 'customtaxorder_css');
add_action('admin_print_scripts', 'customtaxorder_js_libs');

function customtaxorder() {
	
	$settings = '';
	$parent_ID = 0;
	if ( $_GET['page'] == 'customtaxorder' ) { 
        $tax_label = 'Categories';
		$tax = 'category';
		$args = array( 'public' => true, '_builtin' => false ); 
		$output = 'objects';
		$taxonomies = get_taxonomies( $args, $output );
		
		
	} else {
		$args = array( 'public' => true, '_builtin' => false ); 
		$output = 'objects';
		$taxonomies = get_taxonomies( $args, $output );
		foreach ( $taxonomies as $taxonomy ) {
			$com_page = 'customtaxorder-'.$taxonomy->name;
			if ( $_GET['page'] == $com_page ) { 
				$tax_label = $taxonomy->label;
				$tax = $taxonomy->name;
			} else {
			}
		}
	}
	if (isset($_POST['go-sub-posts'])) { 
		$parent_ID = $_POST['sub-posts'];
	}
	elseif (isset($_POST['hidden-parent-id'])) { 
		$parent_ID = $_POST['hidden-parent-id'];
	}
	if (isset($_POST['return-sub-posts'])) { 
		$parent_term = get_term($_POST['hidden-parent-id'], $tax);
		$parent_ID = $parent_term->parent;
	}
	$message = "";
	if (isset($_POST['order-submit'])) { 
		customtaxorder_update_order();
	}
?>
<div class='wrap'>
	<?php screen_icon('customtaxorder'); ?>
	<h2><?php _e('Order ' . $tax_label, 'customtaxorder'); ?></h2>
	<form name="custom-order-form" method="post" action="">
		<?php  
		$args = array(
			'orderby' => 'term_order',
			'order' => 'ASC',
			'hide_empty' => false,
			'parent' => $parent_ID, 
		);
		$terms = get_terms( $tax, $args );
			if ( $terms ) {
		?>
		<div id="poststuff" class="metabox-holder">
			<div class="widget order-widget">
				<h3 class="widget-top"><?php _e( $tax_label, 'customtaxorder') ?> | <small><?php _e('Order the ' . $tax_label . ' by dragging and dropping them into the desired order.', 'customtaxorder') ?></small></h3>
				<div class="misc-pub-section">
					<ul id="custom-order-list">
						<?php foreach ( $terms as $term ) : ?>
						<li id="id_<?php echo $term->term_id; ?>" class="lineitem"><?php echo $term->name; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="misc-pub-section misc-pub-section-last">
					<?php if ($parent_ID != 0) { ?>
						<input type="submit" class="button" style="float:left" id="return-sub-posts" name="return-sub-posts" value="<?php _e('Return to Parent', 'customtaxorder'); ?>" />
					<?php } ?>
					<div id="publishing-action">
						<img src="<?php echo admin_url( 'images/wpspin_light.gif' ) ; ?>" id="custom-loading" style="display:none" alt="" />
						<input type="submit" name="order-submit" id="order-submit" class="button-primary" value="<?php _e('Update Order', 'customtaxorder') ?>" />
					</div>
					<div class="clear"></div>
					</div>
				<input type="hidden" id="hidden-custom-order" name="hidden-custom-order" />
				<input type="hidden" id="hidden-parent-id" name="hidden-parent-id" value="<?php echo $parent_ID; ?>" />
			</div>
			<?php $dropdown = customtaxorder_sub_query( $terms, $tax ); if( !empty($dropdown) ) { ?>
			<div class="widget order-widget">
				<h3 class="widget-top"><?php _e('Sub-' . $tax_label, 'customtaxorder'); ?> | <small><?php _e('Choose a term from the drop down to order its sub-terms.', 'customtaxorder'); ?></small></h3>
				<div class="misc-pub-section misc-pub-section-last">
					<select id="sub-posts" name="sub-posts">
						<?php echo $dropdown; ?>
					</select>
					<input type="submit" name="go-sub-posts" class="button" id="go-sub-posts" value="<?php _e('Order Sub-terms', 'customtaxorder') ?>" />
				</div>
			</div>		
			<?php } ?>
		</div>
		<?php } else { ?>
		<p><?php _e('No terms found', 'customtaxorder'); ?></p>
		<?php } ?>
	</form>
	
</div>
<?php if ( $terms ) { ?>
<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function($) {
		$("#custom-loading").hide();
		$("#order-submit").click(function() {
			orderSubmit();
		});
	});
	function customtaxorderAddLoadEvent(){
		jQuery("#custom-order-list").sortable({ 
			placeholder: "sortable-placeholder", 
			revert: false,
			tolerance: "pointer" 
		});
	};
	addLoadEvent(customtaxorderAddLoadEvent);
	function orderSubmit() {
		var newOrder = jQuery("#custom-order-list").sortable("toArray");
		jQuery("#custom-loading").show();
		jQuery("#hidden-custom-order").val(newOrder);
		return true;
	}
// ]]>
</script>
<?php }
}
function customtaxorder_update_order() {
	if (isset($_POST['hidden-custom-order']) && $_POST['hidden-custom-order'] != "") { 
        global $wpdb;
		$new_order = $_POST['hidden-custom-order'];
		$IDs = explode(",", $new_order);
		$result = count($IDs);
		for($i = 0; $i < $result; $i++) {
			$str = str_replace("id_", "", $IDs[$i]);
			$wpdb->query("UPDATE $wpdb->terms SET term_order = '$i' WHERE term_id ='$str'");
		}
		echo '<div id="message" class="updated fade"><p>'. __('Order updated successfully.', 'customtaxorder').'</p></div>';
	} else {
		echo '<div id="message" class="error fade"><p>'. __('An error occured, order has not been saved.', 'customtaxorder').'</p></div>';
	}
}
function customtaxorder_sub_query( $terms, $tax ) {
	$options = '';
	foreach ( $terms as $term ) :
		$subterms = get_term_children( $term->term_id, $tax );
		if ( $subterms ) { 
			$options .= '<option value="' . $term->term_id . '">' . $term->name . '</option>'; 
		}
	endforeach;
	return $options;
}

if (!get_option('added_term_order_column')) {
	global $wpdb;
	$init_query = $wpdb->query("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_order'");
	if ($init_query == 0) {	$wpdb->query("ALTER TABLE $wpdb->terms ADD `term_order` INT( 4 ) NULL DEFAULT '0'"); }
    update_option('added_term_order_column', true);
}
function customtaxorder_apply_order_filter($orderby, $args) {
	
	if ( isset( $args['taxonomy'] ) ) {
		$taxonomy = $args['taxonomy'];
	} else {
		$taxonomy = 'category';
	}
	if ( $args['orderby'] == 'term_order' ) {
		return 't.term_order';
	//} elseif ( $options[$taxonomy] == 1 && !isset($_GET['orderby']) ) {
	//	return 't.term_order';
	} else {
		return $orderby;
	}
}
add_filter('get_terms_orderby', 'customtaxorder_apply_order_filter', 10, 2);

?>
