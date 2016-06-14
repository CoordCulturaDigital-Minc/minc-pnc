<?php 

$metas_relacionadas = get_post_meta($post->ID, '_metas_relacionadas_ids'); 

$metas_relacionadas_ordered = array();

if (!empty($metas_relacionadas)) {
    foreach ($metas_relacionadas as $m)
        $metas_relacionadas_ordered[$m] = get_post_meta($m, '_numero', true);
}
asort($metas_relacionadas_ordered);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>	  
	<header>                       
		<h1><?php the_title();?></h1>
        <p><?php the_excerpt(); ?></p>
	</header>
	<div class="post-content clearfix">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<nav class="page-link">' . 'Páginas', 'after' => '</nav>' ) ); ?>		
		<p class="taxonomies">
			<span>Categorias:</span> <?php the_category(', ');?><br />
			<?php the_tags('<span>Tags:</span> ', ', '); ?>
		</p>
        
        <p class="bottom top">
            <small>
                Postado por <?php the_author_posts_link(); ?> em
                <time class="post-time" datetime="<?php the_time('Y-m-d'); ?>" pubdate><?php the_time( get_option('date_format') ); ?></time> | <a class="comments-number" href="<?php comments_link(); ?>"title="comentários"><?php comments_number('0 comentários','1 comentário','% comentários');?></a>
                <?php edit_post_link('Editar', '| ', '' ); ?>
            </small>
        </p>

	</div>
    
    <?php if (!empty($metas_relacionadas_ordered)) : ?>
        <div class="meta-list">
            <h3 class="top">Metas relacionadas</h3>
            <hr/>
            <?php foreach ($metas_relacionadas_ordered as $meta_id => $meta_number) : ?>
                <div class="meta clearfix"><a href="<?php echo get_permalink($meta_id); ?>"><?php echo get_the_title($meta_id); ?></a></div>
            <?php endforeach; ?>  
        </div>
    <?php endif; ?>
    
    
	<!-- .post-content -->
	<?php comments_template(); ?>
	<!-- comentários -->
</article>
<!-- .post -->
    			
