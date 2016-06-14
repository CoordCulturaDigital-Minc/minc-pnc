<?php $percentual = get_post_meta(get_the_ID(), '_percentual', true); ?>
<?php $numero = get_post_meta(get_the_ID(), '_numero', true); ?>
<div class="meta clearfix">
    <?php if (get_query_var('minpnctpl') == 'metas-de-meu-interesse'): ?>
        <a class="remove_meta_interesse btn btn-red btn-small" href="<?php echo add_query_arg( 'remove_meta', get_the_ID(), site_url('metas-de-meu-interesse') ); ?>">X</a>
    <?php endif; ?>
    <a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title();?></a> 
    <?php echo (is_numeric($percentual)) ? "<span class='percentual clearfix clear'>{$percentual}% realizada</span>" : ''; ?>
</div>
