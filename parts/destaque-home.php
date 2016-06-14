<?php

$post = null;

$type = isset($config['type']) ? $config['type'] : 'new';
if ($type == 'new') {
    $query = 'posts_per_page=3&ignore_sticky_posts=1';
} elseif ($type == 'random') {
    $query = 'posts_per_page=3&orderby=rand&ignore_sticky_posts=1';
} elseif ($type == 'permalinks') {
    
    $posts = array();
    
    if (isset($config['permalink1']) && !empty($config['permalink1'])) {
        $p = $self->getPostFromPermalink($config['permalink1']);
        if (is_object($p) && isset($p->ID))
            array_push($posts, $p->ID);
    }
    if (isset($config['permalink2']) && !empty($config['permalink2'])) {
        $p = $self->getPostFromPermalink($config['permalink2']);
        if (is_object($p) && isset($p->ID))
            array_push($posts, $p->ID);
    }
    if (isset($config['permalink3']) && !empty($config['permalink3'])) {
        $p = $self->getPostFromPermalink($config['permalink3']);
        if (is_object($p) && isset($p->ID))
            array_push($posts, $p->ID);
    }
    if (empty($posts))
        $posts = array(-1);
        
    $query = array('post__in' => $posts, 'ignore_sticky_posts' => 1);
}

$MultiplePosts = new WP_Query($query);


?>

<?php if ($MultiplePosts->have_posts()): ?>
    
    <section id="highlight" class="hl-carrousel">
        <nav class="nav-left"><nav class="hl-nav-left"></nav></nav>
        <div class="hl-wrapper">
        <?php while($MultiplePosts->have_posts()): $MultiplePosts->the_post(); global $post;?>

            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'highlight' ); ?>

            <article  style='background:url(<?php echo $thumb["0"]; ?>) no-repeat center center; background-size: 442px 232px;'>
                <hgroup>
                    <h1><a href="<?php  the_permalink(); ?>"><?php  the_title(); ?></a></h1>
                    <p><a href="<?php  the_permalink(); ?>"><?php  the_excerpt(); ?></a></p>
                </hgroup>
            </article>

        <?php endwhile; ?>
        </div>
        <nav class="nav-right"><nav class="hl-nav-right"></nav></nav>
    </section>
    
    <?php wp_reset_query(); ?>
<?php else: ?>
    <p>Nenhum post selecionado</p>
<?php endif; ?>
