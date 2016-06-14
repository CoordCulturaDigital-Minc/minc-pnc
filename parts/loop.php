<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>	  
	<header>                       
		<h1 class="bottom"><a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h1>					
		<p class="bottom top">
            <small>
        		Postado por <?php the_author_posts_link(); ?> em
        		<time class="post-time" datetime="<?php the_time('Y-m-d'); ?>" pubdate><?php the_time( get_option('date_format') ); ?></time> | <a class="comments-number" href="<?php comments_link(); ?>"title="comentários"><?php comments_number('0 comentários','1 comentário','% comentários');?></a>
        		<?php edit_post_link('Editar', '| ', '' ); ?>
            </small>
		</p>
	</header>
	<div class="post-content clearfix">    
		<?php if ( has_post_thumbnail() ) : ?> 
			<div class="post-thumbnail alignleft">
			  <?php the_post_thumbnail(); ?>				 
			</div>
			<div class="post-excerpt alignleft">
				<?php the_excerpt(); ?>
			</div>
		<?php else : ?> 
			<?php the_excerpt(); ?>
		<?php endif; ?>
	</div>
</article>
