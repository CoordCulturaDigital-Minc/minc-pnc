<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Please do not load this page directly. Thanks!'); ?>
<?php if(post_password_required()) return; ?>
<?php
// add a microid to all the comments
function comment_add_microid($classes)
{
  $c_email = get_comment_author_email();
  $c_url = get_comment_author_url();
  if (!empty($c_email) && !empty($c_url)) {
    $microid = 'microid-mailto+http:sha1:' . sha1(sha1('mailto:'.$c_email).sha1($c_url));
    $classes[] = $microid;
  }
  return $classes;  
}

add_filter('comment_class','comment_add_microid');
?>

<div id="comments"> 
    <!--show the comments-->
    <?php if ('open' == $post->comment_status) : ?>
        <h3>Comentários <small>(<?php comments_number('Nenhum Comentário', '1 Comentário', '% Comentários' );?>)</small></h3>
        
        <ul class="commentlist" id="singlecomments">
            <?php wp_list_comments('callback=minc_comment'); ?>
        </ul>
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comments-nav">
                <div class="alignleft"><?php previous_comments_link( 'Comentários Antigos' ); ?></div>
                <div class="alignright"><?php next_comments_link( 'Comentários Recentes' ); ?></div>
            </nav><!-- .navigation -->
        <?php endif; // check for comment navigation ?>
            
    <?php endif; ?>
    
    <!--show the form-->
    <?php if('open' == $post->comment_status) : ?>
    <div id="respond" class="clearfix">

        <?php if(get_option('comment_registration') && !$user_ID) : ?>
            <p><?php printf( 'Você precisa estar logado para comentar.', "<a href='" . get_option('siteurl') . "/wp-login.php?redirect_to=" . urlencode(get_permalink()) ."'>", "</a>" ); ?></p>
        
        <?php else : ?>

            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="form-comentario" class="form-horizontal clearfix">
                
                <?php comment_id_fields(); ?>

                <div class="control-group">
                    <div class="controls">
                        <h5 class="bottom">Deixe um comentário</h5>
                    </div>
                </div>
                            
                <?php if($user_ID) : ?>
                    
                    <p>Conectado como <a href="<?php print get_option('siteurl'); ?>/wp-admin/profile.php"><?php print $user_identity; ?></a>. <a href="<?php echo wp_logout_url( get_permalink( get_the_ID() )  ); ?>" title="Logout">Sair &raquo;</a></p>
                
                <?php else : ?>                

                    <div class="control-group clearfix">
                        <label class="control-label">Nome</label>
                        <div class="controls">
            				<input type="text" name="author" id="author" value="" required="required" />                            
                        </div>
                    </div>
                    
                    <div class="control-group clearfix">
                        <label class="control-label">E-mail</label>
                        <div class="controls">
            				<input type="email" name="email" id="email" value="" required="required" />                            
                        </div>
                    </div>
                    
                    <div class="control-group clearfix">
                        <label class="control-label">Site</label>
                        <div class="controls">
            				<input type="text" name="url" id="url" value="http://" />
                        </div>
                    </div>

                <?php endif; ?>
                
                <div class="control-group clearfix">
                    <label class="control-label">Comentário</label>
                    <div class="controls">
                        <textarea name="comment" id="comment" required="required"></textarea>
                    </div>
                </div>

                <div class="control-group textright">
                    <div class="controls">
                        <small><?php cancel_comment_reply_link( 'Cancelar' ); ?></small>
                        <input type="submit" name="comentar" id="comentar" value="Comentar" />
                    </div>
                </div>
                
                <?php if(get_option("comment_moderation") == "1") : ?>
                    <?php _e('All comments need to be approved', 'SLUG'); ?>
                <?php endif; ?>
            
                <?php do_action('comment_form', $post->ID); ?>

            </form>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
