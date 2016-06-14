<?php

// $tipos = get_the_terms($post->ID, 'tipo');
// aparentemente não tem um jeito de forçar que uma taxonomia só tenha uma entrada por post
// if ($tipos) $tipo = array_shift($tipos);

global $wpdb;
$noticias_releacionadas = $wpdb->get_col("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_metas_relacionadas_ids' AND meta_value = " . $post->ID);


$mudancas_necessarias = get_post_meta($post->ID, '_mudancas_necessarias', true);
$subtitulo = get_post_meta($post->ID, '_subtitulo', true);
$sendo_feito = get_post_meta($post->ID, '_sendo_feito', true);
$historico = get_post_meta($post->ID, '_historico', true);
$embed_situacao_atual = get_post_meta($post->ID, '_embed_situacao_atual', true);
$situacao_atual = get_post_meta($post->ID, '_situacao_atual', true);
?>

<?php require_once(TEMPLATEPATH . '/includes/busca_metas.php'); ?>

<hr/>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>	  
    <header>                       
        <h1><?php the_title();?></h1>
        <?php if ($subtitulo): ?>
            <p id="subtitulo"><?php echo $subtitulo ?></p>
        <?php endif; ?>
        <p id="objetivo"><?php echo get_post_meta($post->ID, '_objetivo', true); ?></p>

    </header>

    <div class="post-content clearfix">
        <?php the_content(); ?>

        <?php if ($mudancas_necessarias): ?>
            <hr/>
            <h4>Como esta meta está sendo medida</h4>
            <?php echo nl2br($mudancas_necessarias); ?>
        <?php endif; ?>
        
        <?php if ($historico): ?>
            <hr/>
            <h4>Histórico da meta</h4>
            <?php echo nl2br($historico); ?>
        <?php endif; ?>
        
        <?php if ($situacao_atual): ?>
            <hr/>
            <h4>Situação atual da meta</h4>
            <?php echo nl2br($situacao_atual); ?><br /><br />
            <?php if ($embed_situacao_atual): ?>
                <div id="embed_situacao_atual"><?php echo nl2br($embed_situacao_atual); ?></div>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if ($sendo_feito): ?>
            <hr/>
            <h4>O que está sendo feito para alcançar esta meta</h4>
            <p><?php echo nl2br($sendo_feito); ?></p>
        <?php endif; ?>

        
        <p class="taxonomies">
            <span>Veja todas as metas que também estão nos temas :</span> <?php the_terms(get_the_ID(), 'tema', '', ', ');?>
            <br/><br/>
            Ver mais metas marcadas com as tags: <?php the_terms(get_the_ID(), 'tags_metas', '', ', ');?>
            <br/><br/>
            <?php edit_post_link( 'Editar', '', '' ); ?>
        </p>
        
    </div>
    <!-- .post-content -->

    <footer class="clearfix">
        <div class="clearfix">
            <?php if (is_user_logged_in()): ?>

                <?php $followed = is_meta_followed_by_user(get_the_ID()); ?>

                <form class="form-horizontal alignleft" method="post" action="<?php echo site_url('metas-de-meu-interesse'); ?>">
                    <input type="hidden" name="meta_id" id="hidden_meta_id" value="<?php the_ID(); ?>" />
                    <label id="label_acompanhe" for="acompanhar_meta" class="btn btn-red">
                        <input type="checkbox" id="acompanhar_meta" name="acompanhar_meta" value="1" <?php if ($followed) echo 'checked'; ?> /> 
                        <span id="acompanhe_feedback"><?php echo $followed ? 'Você acompanha esta meta' : 'Acompanhe essa meta'; ?></span>
                    </label>
                </form>

            <?php endif; ?>
        
            <p class="textright bottom"><a href="#noticias-relacionadas"><span id="btn-acoes-relacionadas" class="btn btn-blue">Veja notícias relacionadas a esta meta</span></a></p>
            
        </div>

    </footer>

    <?php comments_template(); ?>

    
        <div class="related-news" id="noticias-relacionadas">
            <h3>Notícias relacionadas</h3>
            <?php if (!empty($noticias_releacionadas)) : ?>
            <?php foreach ($noticias_releacionadas as $noticia_id) : ?>
                <p><a href="<?php echo get_permalink($noticia_id); ?>"><?php echo get_the_title($noticia_id); ?></a></p>
            <?php endforeach; ?>  
            <?php else: ?>
            <p>Não há notícias relacionadas a esta meta</p>
            <?php endif; ?>
        </div>
    

</article>

