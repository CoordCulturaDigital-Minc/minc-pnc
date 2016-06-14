jQuery(document).ready(function() {

    var municipio_ajax_first_call = true;
    
    jQuery('#estado').change(function() {
        
        if (jQuery(this).val() != '') {
            jQuery('#municipio').html('<option value="">Carregando...</option>');
            
            jQuery.ajax({
                url: pnc.ajaxurl, 
                type: 'post',
                data: {action: 'pnc_get_cities_options', uf: jQuery('#estado').val(), selected: jQuery('#municipio').val()},
                success: function(data) {
                    jQuery('#municipio').html(data);
                } 
            });
        }
        
        
    })
    
    if (jQuery('#disable_first_municipio_ajax_call').size() == 0)
        jQuery('#estado').change();
    
    jQuery('select#atuacao').change(function() {
    
        if (jQuery(this).val() == 'outra_area_cultura' || jQuery(this).val() == 'nao_cultura') {
            jQuery('#atuacao_outra_container').show();
        } else {
            jQuery('#atuacao_outra_container').hide();
        }
    
    }).change();
    
    jQuery('select#ocupacao').change(function() {
    
        if (jQuery(this).val() == 'outra') {
            jQuery('#ocupacao_outra_container').show();
        } else {
            jQuery('#ocupacao_outra_container').hide();
        }
    
    }).change();


});
