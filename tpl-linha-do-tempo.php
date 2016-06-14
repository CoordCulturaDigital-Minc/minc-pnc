<?php
/*
Template Name: Linha do Tempo
*/
?>

<?php get_header() ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
    
    <section id="main-section" class="linha-do-tempo clearfix">
        <header class="clearfix">
            <?php html::image("ilustra-1.png", "", array("class" => "alignleft")) ?>
            <h1><?php the_title() ?></h1>
        </header>
        <div class="post-content">
            <div class="box box-1 box-year" data-box-id="1">
                <h1 class="year">2003-2005</h1>
                <h1 class="title">Articulação política e participação social</h1>
            </div>
            <div class="box-connector-1"></div>
            <div class="box box-2 box-year" data-box-id="2">
                <h1 class="year">2006-2008</h1>
                <h1 class="title">Informações, diretrizes gerais e debate público</h1>
            </div>
            <div class="box-connector-2"></div>
            <div class="box box-3 box-year" data-box-id="3">
                <h1 class="year">2009-2010</h1>
                <h1 class="title">Aprovação no Congresso</h1>
            </div>
            <div class="box-connector-3"></div>
            <div class="box box-4 box-year" data-box-id="4">
                <h1 class="year">2011-2012</h1>
                <h1 class="title">Metas, monitoramento e SNIIC</h1>
            </div>
            <div class="box-connector-4"></div>
            <div class="box box-5 box-year" data-box-id="5">
                <h1 class="year">2013-2014</h1>
                <h1 class="title">Planos territoriais, setoriais e revisão do PNC</h1>
            </div>
            <div class="box-connector-4"></div>
            <div class="box box-6 box-year" data-box-id="6">
                <h1 class="year">2014-2020</h1>
                <h1 class="title">Monitoramento e novo PNC</h1>
            </div>
            
            <div class="box box-1 box-content" data-box-content-id="1">
                <ul>
                    <li><?php echo get_linhadotempo_item_link('2003', 0, 'Realização do conjunto de seminários “Cultura para Todos” em todo o país'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2003', 1, 'Criação da Agenda 21 da Cultura para as cidades.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2003', 2, 'Instalação e trabalho das Câmaras Setoriais.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2003', 3, 'Realização da 1ª Conferência Nacional de Cultura precedida por conferências regionais, estaduais e municipais.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2003', 4, 'Aprovação da Convenção sobre a Proteção e Promoção da Diversidade das Expressões Culturais.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2003', 5, 'Aprovação da emenda constitucional que insere o PNC no art. 215.'); ?></li>
                </ul>
            </div>
            <div class="box box-2 box-content">
                <ul>
                    <li><?php echo get_linhadotempo_item_link('2006', 0, 'Apresentação do Projeto de Lei do PNC ao Congresso.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2006', 1, 'Elaboração de diretrizes gerais. '); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2006', 2, 'Realização de pesquisas no campo da cultura (IBGE e IPEA). '); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2006', 3, 'Criação do Conselho Nacional de Política Cultural.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2006', 4, 'Realização de seminários em todos os estados e fórum virtual.'); ?></li>
                </ul>
            </div>
            <div class="box box-3 box-content">
                <ul>
                    <li><?php echo get_linhadotempo_item_link('2009', 0, 'Realização da 2ª Conferência Nacional de Cultura.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2009', 1, 'Análise do Projeto de Lei na Comissão de Educação e Cultura e na Comissão de Constituição e Justiça do Congresso. '); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2009', 2, 'Aprovação da Lei do PNC (Lei n° 12.343/2010).'); ?></li>
                </ul>
            </div>
            <div class="box box-4 box-content">
                <ul>
                    <li><?php echo get_linhadotempo_item_link('2011', 0, 'Formulação das metas do PNC.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2011', 1, 'Elaboração de planos de ação para as metas.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2011', 2, 'Desenvolvimento do Sistema Nacional de Informações e Indicadores Culturais (SNIIC).'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2011', 3, 'Início do monitoramento das metas.'); ?></li>
                </ul>
            </div>
            <div class="box box-5 box-content">
                <ul>
                    <li><?php echo get_linhadotempo_item_link('2013', 0, 'Acompanhamento dos planos municipais e estaduais de cultura.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2013', 1, 'Adequação e elaboração de planos setoriais de cultura.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2013', 2, 'Monitoramento das metas do PNC.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2013', 3, 'Realização da 3ª Conferência Nacional de Cultura.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2013', 4, 'Revisão do PNC. '); ?></li>
                </ul>
            </div>
            <div class="box box-6 box-content">
                <ul>
                    <li><?php echo get_linhadotempo_item_link('2014', 0, 'Finalização do processo de revisão do PNC e publicação das alterações.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2014', 1, 'Elaboração dos Planos Plurianuais (PPA) com base nas metas do PNC revisado.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2014', 2, 'Monitoramento das metas do PNC.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2014', 3, 'Realização da 4ª Conferência Nacional de Cultura.'); ?></li>
                    <li><?php echo get_linhadotempo_item_link('2014', 4, 'Elaboração de novo PNC.'); ?></li>
                </ul>
            </div>
            
            <div class="box-connector box-connector-content-1"></div>
            <div class="box-connector box-connector-content-2"></div>
            <div class="box-connector box-connector-content-3"></div>
            <div class="box-connector box-connector-content-4"></div>
            <div class="box-connector box-connector-content-5"></div>
            <div class="box-connector box-connector-content-6"></div>
            
        </div>
        
        <p class="textcenter">
            <?php html::image('ilustra-2.png','') ?>
        </p>
        
    </section>
    
<?php endwhile; endif; ?>

<?php get_sidebar() ?>

<script type="text/javascript" charset="utf-8">
    
jQuery(document).ready(function() {
    
    
    jQuery('.box-year').each(function(){
        jQuery(this).hover(
            function() {
                if ( !jQuery('.box-content.box-'+jQuery(this).data('box-id')).is(':visible') ) {
                    jQuery('.box-content').hide();
                    jQuery('.box-connector').hide();
                    jQuery('.box-content.box-'+jQuery(this).data('box-id')).fadeIn('fast');
                    jQuery('.box-connector-content-'+jQuery(this).data('box-id')).fadeIn('fast');
                }
            }
            
        )
    })
    
    jQuery('.box-content').each(function() {
        jQuery(this).hover(
            function() {
                jQuery(this).show();
                
            }
        )
    })
    
    
})
    
</script>

<?php get_footer() ?>
