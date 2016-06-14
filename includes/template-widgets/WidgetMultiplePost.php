<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WidgetMultiplePost
 *
 * @author rafael
 */
class WidgetMultiplePost extends WidgetTemplate {

    public function getPostFromPermalink($permalink) {
        global $wpdb;
        
        $post = null;
        preg_match('/.*\/(?<post_name>[^\/]+)/', $permalink, $matches);
        if (isset($matches['post_name'])) {
            $post_name = $matches['post_name'];

            $post = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE post_name = '$post_name'");
        }

        return $post;
    }

    protected function widget($config) {
        $post = $this->getPostFromPermalink($config);

        if ($post):
            $permalink = get_permalink($post->ID);
            $categories = wp_get_post_terms($post->ID, 'category');
            ?>
            <article id="">
                <p class="category">
                    <?php foreach($categories as $i => $category): if($i > 0) echo ', ';?><a href="<?php echo get_category_link($category); ?>"><?php echo $category->name; ?></a><?php endforeach; ?>
                </p>
                <h3><a href="<?php echo $permalink ?>"><?php echo $post->post_title; ?></a></h3>
                <div class="excerpt"><a href="<?php echo $permalink ?>"><?php utils::postExcerpt($post, 144); ?></a></div>
            </article>
        <?php
        endif;
    }

    protected function form($config) {
        $defaults = array(
            'type' => 'new',
            'permalink1' => '',
            'permalink2' => '',
            'permalink3' => ''
        );
        $config = wp_parse_args($config, $defaults);
        ?>
        
        <input type="radio" name="type" class="WidgetMultiplePostRadio" value="new" id="WidgetMultiplePostNew" <?php if ('new' == $config['type']) echo 'checked'; ?> /> <label style="display:inline" for="WidgetMultiplePostNew">3 Notícias mais recentes</label><br/><br/>
        
        <input type="radio" name="type" class="WidgetMultiplePostRadio" value="random" id="WidgetMultiplePostRandom" <?php if ('random' == $config['type']) echo 'checked'; ?> /> <label style="display:inline" for="WidgetMultiplePostRandom">3 Notícias aleatórias</label><br/><br/>
        
        <input type="radio" name="type" class="WidgetMultiplePostRadio" value="permalinks" id="WidgetMultiplePostPermalinks" <?php if ('permalinks' == $config['type']) echo 'checked'; ?> /> <label style="display:inline" for="WidgetMultiplePostPermalinks">Posts específicos</label><br/><br/>
        
        <div class="WidgetMultiplePostPermalinks" style="display:none">
            <small>copie a url dos posts que você deseja e cole nos espaços abaixo. (Deixe em branco se quiser menos de 3 notícias)</small><br/><br/>
            
            Post 1: <input type="text" name="permalink1" value="<?php echo $config['permalink1']; ?>" style="width: 100%"/><br/>
            Post 2: <input type="text" name="permalink2" value="<?php echo $config['permalink2']; ?>" style="width: 100%"/><br/>
            Post 3: <input type="text" name="permalink3" value="<?php echo $config['permalink3']; ?>" style="width: 100%"/><br/>
        </div>
        <?php
    }

    protected function getFormTitle() {
        return 'Exibir:';
    }

}

add_action('wp_print_footer_scripts', 'widgetMultiplePostJS');
function widgetMultiplePostJS() {
    if (current_user_can('manage_options')): 
        ?>
        <script>
        jQuery(document).ready(function() {
            jQuery('.WidgetMultiplePostRadio').click(function() {
                if (jQuery(this).val() == 'permalinks') {
                    jQuery(this).siblings('.WidgetMultiplePostPermalinks').show();
                } else {
                    jQuery(this).siblings('.WidgetMultiplePostPermalinks').hide();
                }
            });
            jQuery('.WidgetMultiplePostRadio:checked').click();
            
        });
        </script>
        <?php
    endif;
}
?>
