<?php get_header(); ?>
	
<section id="main-section" class="col-8">			
	<?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
			
		<?php $metas_releacionadas = get_post_meta($post->ID, '_metas_relacionadas_ids');; ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>	  
			<header>                       
				
                <?php if ($post->post_parent > 0): ?>
                    <?php $ancestors = get_post_ancestors($post->ID); ?>
                    <?php $ancestors = array_reverse($ancestors); ?>
                    <p class="bottom top">
                        <small>
                            <?php foreach ($ancestors as $ancestor): ?>
                                <a href="<?php echo get_permalink($ancestor); ?>"><?php echo get_the_title($ancestor); ?></a> : 
                            <?php endforeach; ?>
                        </small>
                    </p>
                <?php endif; ?>
                <h1><?php the_title();?></h1>
			</header>
			<div class="post-content clearfix">
				<?php edit_post_link('Editar', '', '' ); ?>
                <?php the_content(); ?>				
			</div>
    
		</article>
		<!-- .post -->
    			
		

	<?php endwhile; else : ?>
	   <p><?php _e('No results found.', 'SLUG'); ?></p>              
	<?php endif; ?>
</section>
<!-- #main-section -->	          

<?php get_sidebar(); ?>
		
    
<?php get_footer(); ?>
