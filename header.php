<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width" />
        <title><?php
            /* Print the <title> tag based on what is being viewed. */
            global $page, $paged;

            wp_title( '|', true, 'right' );

            // Add the blog name.
            bloginfo( 'name' );

            // Add the blog description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                echo " | $site_description";

            // Add a page number if necessary:
            if ( $paged >= 2 || $page >= 2 )
                echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );
        ?></title>

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
        <link rel="stylesheet" type="text/css" href="http://www.cultura.gov.br/minc-internet-lf6_1ga2-theme/css/barra-brasil.css?browserId=other&themeId=mincinternetlf6_1ga2_WAR_mincinternetlf6_1ga2theme&languageId=pt_BR&b=6120&t=1365596309000" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/barra_minc.css" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <style type="text/css" media="screen">
        body { font-family:Arial,Verdana,Sans-serif; }
        </style>
        <![endif]-->
        <?php wp_head(); ?>
        
    </head>

    <body <?php body_class(); ?>>
		<div id="geral">

			<div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;"> 
				<ul id="menu-barra-temp" style="list-style:none;">
					<li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED"><a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a></li> 
					<li><a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a></li>
				</ul>
			</div>
			 
			<div id="wrapper"> <a href="#main-content" id="skip-to-content">Pular para o conteúdo</a> 
				<header id="banner" role="banner"> 
					<div id="topo"> 
						<div id="sombra-topo"> 
							<div id="barra-superior"> 
								<ul id="barra-compartilhe"> 
									<li id="rss"><a href="http://www.cultura.gov.br/rss"><img src="http://www.cultura.gov.br/minc-internet-lf6_1ga2-theme/images/minc/rss.png" title="RSS" alt="RSS"></a></li>
									<li id="facebook"><a href="https://www.facebook.com/MinisterioDaCultura" target="_blank"><img src="http://www.cultura.gov.br/minc-internet-lf6_1ga2-theme/images/minc/facebook.png" title="Facebook" alt="Facebook"></a></li> 
									<li id="twitter"><a href="https://twitter.com/culturagovbr" target="_blank"><img src="http://www.cultura.gov.br/minc-internet-lf6_1ga2-theme/images/minc/twitter.png" title="Twitter" alt="Twitter"></a></li> 
									<li id="youtube"><a href="http://www.youtube.com/ministeriodacultura/" target="_blank"><img src="http://www.cultura.gov.br/minc-internet-lf6_1ga2-theme/images/minc/youtube.png" title="Youtube" alt="Youtube"></a></li> 
									<li id="mais"><a href="http://www.flickr.com/photos/ministeriodacultura"><img src="http://www.cultura.gov.br/minc-internet-lf6_1ga2-theme/images/minc/flickr.png" title="Flickr" alt="Flickr"></a></li> 
								</ul> 
								<ul id="barra-fale"> 
									<li><a href="http://www.cultura.gov.br/fale-com-o-minc">Fale com o Ministério</a> <span class="nao-italico"> |</span><a href="http://www.cultura.gov.br/ouvidoria"> Ouvidoria</a></li> 
								</ul>
		 
								<nav class="sort-pages modify-pages" id="navigation"> 
									<h1> <span>Navegação</span> </h1> 
									<ul id="aui_3_4_0_1_543"> 
										<li id="aui_3_4_0_1_692"> <a href="http://www.cultura.gov.br/inicio" tabindex="-1" id="aui_3_4_0_1_564"><span id="aui_3_4_0_1_695">Cultura.gov</span></a> </li> 
										<li id="aui_3_4_0_1_659" class=""> <a href="http://www.cultura.gov.br/acessoainformacao" tabindex="-1" id="aui_3_4_0_1_566"><span id="aui_3_4_0_1_662"> Acesso à Informação</span></a> 
											
										</li> 
										<li id="aui_3_4_0_1_655" class=""> <a href="http://www.cultura.gov.br/o-ministerio" tabindex="-1" id="aui_3_4_0_1_596"><span> O Ministério</span></a> 
										
									</li> 
									<li id="aui_3_4_0_1_650" class=""> <a href="http://www.cultura.gov.br/apoio-a-projetos" tabindex="-1" id="aui_3_4_0_1_612"><span id="aui_3_4_0_1_653"> Apoio a Projetos</span></a> 
										
									</li> 
									<li id="aui_3_4_0_1_680" class=""> <a href="http://www.cultura.gov.br/o-dia-a-dia-da-cultura" tabindex="-1" id="aui_3_4_0_1_620"><span id="aui_3_4_0_1_679"> O dia a dia da Cultura</span></a> 
										
									</li> 
										<li id="barra-bandeiras"> <span> <a class="taglib-icon" href="http://www.cultura.gov.br/inicio?p_p_id=82&amp;p_p_lifecycle=1&amp;p_p_state=normal&amp;p_p_mode=view&amp;p_p_col_count=2&amp;_82_struts_action=%2Flanguage%2Fview&amp;_82_redirect=%2F&amp;languageId=pt_BR" id="xeen" lang="pt-BR" tabindex="-1"> <img class="icon" src="http://www.cultura.gov.br/minc-internet-lf6_1ga2-theme/images/language/pt_BR.png" alt="português (Brasil)" title="português (Brasil)"> </a> </span> </li> 
									</ul> 
								</nav> 
							</div> 
						</div> 
					</div> 
				</header>   
			</div> 
		</div>
        <header id="main-header" class="clearfix">
            
            <a href="<?php echo bloginfo('url') ?>" class="back-to-home"></a>
            
            <?php wp_nav_menu(array(
                'menu' => 'main_menu',
                'theme_location' => 'main_menu',
                'container' => 'nav',
                'container_id' => 'main-nav',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
            )) ?>

        </header>
        <div class="wrapper">
            <div class="container clearfix">
