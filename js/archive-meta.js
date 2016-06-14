jQuery(document).ready(function() {
    jQuery('#tema_meta').change(function() {
        jQuery('#form_tema_meta').submit();
    });
    jQuery('#tag_meta').change(function() {
        jQuery('#form_tag_meta').submit();
    })
    jQuery('.wp-pagenavi').addClass('clearfix');
});
