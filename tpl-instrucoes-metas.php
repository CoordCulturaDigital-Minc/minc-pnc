<?php
/*
Template Name: Instruções para Metas de interesse
*/


the_post();

$doing_login = is_user_logged_in() && isset($_GET['logged_in']) && isset($_GET['redirect_to']);
if ($doing_login)
    $cur_user = wp_get_current_user();
?>

<?php get_header(); ?>

<section id="main-section" class="clearfix">
    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>
        <header>
            <?php if ($doing_login): ?>
                <h1>Bem-vindo <?php echo $cur_user->display_name; ?></h1>
            <?php else: ?>
                <h1><?php the_title(); ?></h1>
            <?php endif; ?>
        </header>
        <div class="post-content clearfix">
            
            <?php the_content(); ?>
            
            <?php if (is_user_logged_in()): ?>
                
                <?php mincpnc_formulario_selecao_metas_interesse($doing_login); ?>
            
            <?php else: ?>
            
                <p>É preciso <a href="<?php echo site_url('cadastro'); ?>">ser cadastrado</a> e fazer o <a href="<?php echo wp_login_url(); ?>?redirect_to=<?php echo $_SERVER['REQUEST_URI']; ?>" >login</a> para poder criar uma lista de interesse.</p>
            
            <?php endif; ?>
                
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
