

<?php while ( have_posts()) : the_post(); ?>
<?php
$meta = get_metadata('post', get_the_ID());
?>
<tr>
    <?php if((isset($meta['_data_inicial'][0]) && $meta['_data_inicial'][0]) && (isset($meta['_data_final'][0]) && $meta['_data_final'][0])): ?>
        <td><?php echo date('d/m/Y', strtotime($meta['_data_inicial'][0]));?></td>
        <td><?php echo date('d/m/Y', strtotime($meta['_data_final'][0])); ?></td>
    <?php elseif(isset($meta['_data_inicial'][0]) && $meta['_data_inicial'][0]): ?>
        <td><?php echo date('d/m/Y', strtotime($meta['_data_inicial'][0])); ?></td>
        <td class="textcenter">-</td>
    <?php elseif(isset($meta['_data_final'][0]) && $meta['_data_final'][0]): ?>
        <td class="textcenter">-</td>
        <td><?php echo date('d/m/Y', strtotime($meta['_data_final'][0])); ?></td>
    <?php endif; ?>

    <td><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></td>

    <?php if(isset($meta['_onde'][0]) && $meta['_onde'][0]): ?>
        <td><?php echo $meta['_onde'][0]; ?></td>
    <?php else : ?>
        <td class="textcenter">-</td>
    <?php endif; ?>
</tr>

<?php endwhile; ?>

<?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <nav class="navigation">
        <div class="alignleft"><?php next_posts_link(__('&laquo; Previous posts', 'blog01')); ?></div>
        <div class="alignright"><?php previous_posts_link(__('Next posts &raquo;', 'blog01')); ?></div>
    </nav>
<?php endif; ?>	
