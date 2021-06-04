<div class="vistor-guide-reuseable-block">
	<?php 
	if (!is_front_page( )){
		$visitor_guide_reuseable_block = get_post( 135448 );
		$block_content = $visitor_guide_reuseable_block->post_content;
		echo $block_content;	
	}
	?>
</div>
    </div><!-- .content-area end of single.tpl -->
</div>
<footer class="footer">
	<div class="footer__container">
		<div class="first-footer-column">
			<img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/whitelogo@1x.png">
		</div>
		<div class="second-footer-column">
			<h4>About Us</h4>
			<?php wp_nav_menu( array( 
				'theme_location' => 'abbout-us-footer-menu',
			) ); ?>
		</div>
		<div class="third-footer-column">
			<h4>Willamette Valley Regions</h4>
			<?php wp_nav_menu( array( 
				'theme_location' => 'regions-footer-menu',
			) ); ?>
		</div>
		<div class="fourth-footer-column">
			<h4>Explore</h4>
			<?php wp_nav_menu( array( 
				'theme_location' => 'explore-footer-menu',
			) ); ?>
		</div>
		<div class="fifth-footer-column">
			<ul>
				<li><a href="#">Site Map</a></li>
				<li><a href="#">Privacy Policy</a></li>
			</ul>
			<input type="text" name="email" placeholder="Email Sign Up">
			<div class="social-icons">
				<a href="#" aria-label="facebook"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/facebook.png"></a>
				<a href="#" aria-label="instagram"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/instagram.png"></a>
				<a href="#" aria-label="youtube"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/youtube.png"></a>
				<a href="#" aria-label="twitter"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/twitter.png"></a>
				<a href="#" aria-label="pinterest"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/pinterest.png"></a>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
