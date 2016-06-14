<?php

global $wp_query;

$currentSearch = isset($_GET['s']) ? $_GET['s'] : '';

if (is_tax('tema')) {
    $currentTema = $wp_query->query_vars['tema'];
} else {
    $currentTema = '';
}

if (is_tax('tags_metas')) {
    $currentTag = $wp_query->query_vars['tags_metas'];
} else {
    $currentTag = '';
}

$temas = get_terms('tema', 'orderby=term_order&order=ASC');
$tags = get_terms('tags_metas', 'orderby=slug&order=ASC');

$queried = get_queried_object();

?>

<div id="search-meta" class="clearfix">
    <form id="form_tema_meta" action="<?php echo site_url(); ?>" method="get" class="bottom">
        <label for="tema_meta">Temas</label>
        <select id="tema_meta" name="tema">
            <option value="">Selecione um tema</option>
            <?php foreach ($temas as $tema): ?>
                <?php $selected = ($tema->slug == $currentTema) ? ' selected="selected" ' : ''; ?>
                <option value="<?php echo $tema->slug; ?>" <?php echo $selected; ?>><?php echo $tema->name; ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    
    <div id="form_tags_meta">
        <form id="form_tag_meta" action="<?php echo site_url(); ?>" method="get" class="bottom">
            <?php // wp_tag_cloud(array('taxonomy' => 'tags_metas')); ?>
            <label for="cat">Tags</label>
            <select id="tag_meta" name="tags_metas">
                <option value="">Selecione uma tag</option>
                <?php foreach ($tags as $tag): ?>
                    <?php $selected = ($tag->slug == $currentTag) ? ' selected="selected" ' : ''; ?>
                    <option value="<?php echo $tag->slug; ?>" <?php echo $selected; ?>><?php echo $tag->name; ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <form id="form_busca" action="<?php echo get_post_type_archive_link('metas'); ?>" method="get" class="form-horizontal bottom">
        <label for="s">Palavra-chave</label>
        <input type="text" id="s" name="s" value="<?php echo $currentSearch; ?>" />
        <input type="submit" value="Buscar" />
    </form>
    
    <p class="clear textright"><small>Para indicar as metas de seu interesse e receber atualizações, <a href="<?php echo get_permalink( get_page_id_by_template('tpl-instrucoes-metas.php') ); ?>">clique aqui</a></small></p>
    
    <?php if ($currentSearch || $currentTag || $currentTema): ?>
        <p class="search-results clear">
            <?php if (is_object($queried) && isset($queried->taxonomy) && $queried->taxonomy == 'tema' ): ?>
                Visualizando metas do tema "<strong><?php echo $queried->name; ?></strong>" <!-- - <small><span class="tema-description"><?php echo $queried->description; ?></span></small> -->
            <?php elseif(is_object($queried) && isset($queried->taxonomy) && $queried->taxonomy == 'tags_metas' ): ?>
                Visualizando metas marcadas com a tag "<strong><?php echo $queried->name; ?></strong>"
            <?php elseif($currentSearch): ?>
                Visualizando resultado da busca por metas com "<strong><?php echo $currentSearch; ?></strong>"
            <?php endif; ?>
        </p>
    <?php endif; ?>
</div>
