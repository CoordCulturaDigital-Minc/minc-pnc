<?php
/*
Template Name: Listagem de Temas e Tags
*/
$temas = get_terms('tema', 'orderby=term_order&order=ASC');
$tags = get_terms('tags_metas', 'orderby=name&order=ASC');

the_post();

?>

<?php get_header(); ?>

<section id="main-section" class="clearfix">
    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>
        <header>
            <h1><?php the_title(); ?></h1>
        </header>
        <div class="post-content clearfix">
            
            <?php the_content(); ?>
            
            <div id="themes">
                <h2>Temas</h2>
                <ul>
                    <?php foreach ($temas as $tema) : ?>
                        <li><a href="<?php echo get_term_link($tema); ?>"><?php echo $tema->name ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="tags">
                <h2>Tags</h2>
                <?php foreach ($tags as $tag) : ?>
                    <a class="tag" href="<?php echo get_term_link($tag); ?>"><?php echo $tag->name ?></a>
                <?php endforeach; ?>
            </div>
                
		</div>
		<!-- .post-content -->
	</article>
	<!-- .post -->
</section>
<!-- #main-section -->
<aside id="main-sidebar" class="span-6 append-1 last">
	<?php get_sidebar(); ?>
</aside>

<?php get_footer(); ?>
