<?php get_header(); ?>

<section id="main-section" class="clearfix">
    <div class="content">		
	    <?php if ( have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
				<header>
					<h1 class="top"><?php the_title();?></h1>
		        </header>
			    <div class="post-content">			    
					<?php if (has_post_thumbnail()) : ?> 
						<?php the_post_thumbnail('medium'); ?>				 
					<?php endif; ?>
					<?php the_content(); ?>
					<?php the_event_box(); ?>
		        </div>
			    <!-- .post-content -->
			    <footer class="post-footer clearfix">
					<?php get_template_part('interaction'); ?>
			    </footer>
			    <!-- comentários -->
			</article>
			<!-- .post -->
		<?php else : ?>		
		    <p class="post"><?php _e('No results found.', 'blog01'); ?></p>
	    <?php endif; ?>
    </div>
    <!-- .content -->
	<nav class="clearfix textcenter">
		<a class="btn btn-blue" href="<?php bloginfo('url'); ?>/agenda?eventos">Ver próximos eventos</a>
        <a class="btn btn-blue" href="<?php bloginfo('url'); ?>/agenda?eventos=passados">Ver eventos passados</a>
	</nav>				
    
</section>
<!-- #main-section -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
