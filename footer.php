    </div>
    <div id="footer">
		<footer id="main-footer" class=" container clearfix clear">
			<div class="navigation clearfix">
				<?php wp_nav_menu(array(
					'theme_location' => 'footer_menu_1',
					'container' => 'nav',
					'container_id' => 'footer-nav-1',
					'items_wrap' => '<h1>Links Rápidos</h1><ul id="%1$s" class="%2$s">%3$s</ul>'
				)) ?>

				<?php wp_nav_menu(array(
					'theme_location' => 'footer_menu_2',
					'container' => 'nav',
					'container_id' => 'footer-nav-2',
					'items_wrap' => '<h1>Sobre o PNC</h1><ul id="%1$s" class="%2$s">%3$s</ul>'
				)) ?>

				<?php wp_nav_menu(array(
					'theme_location' => 'footer_menu_3',
					'container' => 'nav',
					'container_id' => 'footer-nav-3',
					'items_wrap' => '<h1>Cultura.BR</h1><ul id="%1$s" class="%2$s">%3$s</ul>'
				)) ?>
			</div>

			<div id="credits">
				<p class="textcenter bottom">
					Ministério da Cultura utiliza WordPress. © 2012 Governo Federal
					<br/>
					Crédito ilustrações: <a href="http://www.joanalira.com.br/" title="Joana Lira" target="_blank">Joana Lira</a>
				</p>
			</div>

		</footer>
	</div>
</div>
<?php wp_footer(); ?>
<script defer="defer" async="async" src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script>
</body>
</html>
