(function($) {

    $(window).load(function() {
        
        var mainNavWidth = $('#menu-menu-principal').innerWidth();
        var mainNavItems = $('#main-nav>ul>li').length;
        var ulWidth = 0;

        $('#main-nav>ul>li').each(function() {
             ulWidth += $(this).width();
        })

        var distributeSpace = mainNavWidth - ulWidth - (mainNavItems*2.01);
        $('#main-nav>ul>li').each(function() {
            $(this).css({
                paddingLeft: distributeSpace/(mainNavItems*2.01),
                paddingRight: distributeSpace/(mainNavItems*2.01)
            })
        })
        
    });
    
    $(document).ready(function() {

        $('.remove_meta_interesse').click(function() {
            if ( confirm('Tem certeza que deseja remover esta meta da sua lista?') )
                return true;
            return false;
        });
        
        $('#acompanhar_meta').click(function() {
            $('body').css('cursor', 'wait');
            var acompanhar = $(this).is(':checked') ? 1 : 0;
            $.post(
                vars.ajaxurl,
                {
                    action: 'follow_unfollow_meta',
                    meta_id: $('#hidden_meta_id').val(),
                    acompanhar_meta: acompanhar
                    
                },
                function(response) {
                    $('body').css('cursor', 'default');
                    $('#acompanhe_feedback').html(response);
                }
            );
                
        });
        
        // não exibe a seta no widget de listagem de links se o link tiver uma imagem
        $('.widget_links li').each(function(index) {
            if ($(this).find('img').length) {
                $(this).css('background', 'transparent');
                $(this).css('padding-left', '32px');
            }
        });

    })

})(jQuery)
