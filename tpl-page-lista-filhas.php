<?php
/*
Template Name: Página com listagem das filhas
*/
?>
<?php get_header(); ?>
	
<section id="main-section" class="col-8">			
	<?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
			
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
                
                <?php $children = get_children('orderby=menu_order&order=ASC&post_parent='.$post->ID); ?>
                <a name="index"></a>
                <?php foreach ($children as $child): ?>
                    <h5 style="text-transform: none;"><a href="#<?php echo $child->post_name; ?>"><?php echo $child->post_title; ?></a></h5>
                <?php endforeach; ?>
                <hr />
                
                <?php global $post; $old_post = $post; // precisamos disso para q todos os filtros do the_content funcionem?>
                <?php foreach ($children as $child): ?>
                    <h5><a name="<?php echo $child->post_name; ?>"></a><?php echo $child->post_title; ?></h5>
                    <?php $post = $child; ?>
                    <?php echo apply_filters('the_content', $child->post_content); ?>
                    <a href="#index">[topo]</a>
                    <hr />
                <?php endforeach; ?>
                <?php $post = $old_post; ?>
                				
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
