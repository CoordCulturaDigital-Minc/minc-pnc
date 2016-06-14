<div>
    <form id="selecionar_metas_interesse" class="form-horizontal" method="post" action="<?php echo site_url('metas-de-meu-interesse'); ?>">
        <fieldset>
            <div id="selecionar_temas" class="control-group">
                <h3>Temas</h3>
                <?php foreach ($temas as $tema): ?>
                    <label for="temas_followed_<?php echo $tema->term_id; ?>" class="checkbox">
                        <input type="checkbox" name="temas_followed[]" id="temas_followed_<?php echo $tema->term_id; ?>" value="<?php echo $tema->term_id; ?>" <?php if (in_array($tema->term_id, $temas_followed)) echo 'checked' ?> />
                        <?php echo $tema->name; ?>
                    </label>
                <?php endforeach; ?>
            </div>
            
            <div id="selecionar_tags" class="control-group">
                <h3>Tags</h3>
                <?php foreach ($tags as $tag): ?>
                    <label for="tags_metas_followed_<?php echo $tag->term_id; ?>" class="checkbox">
                        <input type="checkbox" name="tags_metas_followed[]" id="tags_metas_followed_<?php echo $tag->term_id; ?>" value="<?php echo $tag->term_id; ?>" <?php if (in_array($tag->term_id, $tags_followed)) echo 'checked' ?> />
                        <?php echo $tag->name; ?>
                    </label>
                <?php endforeach; ?>
            </div>
            
            
            <div class="submit clear textcenter bottom">
                <?php if( isset($doinglogin) && $doinglogin === true): ?>
                    <label>
                        <input type="checkbox" name="dont_show_welcome_again" value="1"> Não me mostrar mais essa página ao fazer login
                    </label>
                <?php endif; ?>
                <input type="submit" id="save_metas_interesse" name="save_metas_interesse" value="Salvar preferências" />            
                
                <input type="hidden" name="redirect_to" value="<?php echo isset($_GET['redirect_to']) ? $_GET['redirect_to'] : ''; ?>" />
                <?php if( isset($doinglogin) && $doinglogin === true): ?>
                    <input type="submit" id="skip_metas_interesse" name="skip_metas_interesse" value="Não quero fazer isso agora" />
                <?php endif; ?>
            </div>
        </fieldset>
    </form>
</div>
