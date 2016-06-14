<?php

$post = null;

if (isset($config['permalink']) && !empty($config['permalink'])) {
    $post = $self->getPostFromPermalink($config);
}

?>

<?php if (is_object($post)): ?>
    <article>
        <h1><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h1>
        <p><a href="<?php echo get_permalink($post->ID); ?>"><?php echo utils::getPostExcerpt($post, 100); ?></a></p>
    </article>
<?php else: ?>
    <p>Nenhum post selecionado</p>
<?php endif; ?>
