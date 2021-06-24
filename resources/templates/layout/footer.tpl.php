<div id="vistor-guide-reuseable-block-footer" class="vistor-guide-reuseable-block">
	<?php 
	if (!is_front_page( )){
		$visitor_guide_reuseable_block = get_post( 135448 );
		$block_content = $visitor_guide_reuseable_block->post_content;
		echo $block_content;	
	}
	?>
</div>
    </div>
</div>
<footer class="footer">
	<div class="footer__container">
		<div class="first-footer-column">
        <a href="<?= home_url() ?>">
                <img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/whitelogo@1x.png" alt="Willamette Valley">
            </a>
		</div>
		<div class="second-footer-column">
			<h4>About Us</h4>
			<?php wp_nav_menu( array( 
				'theme_location' => 'about-us-footer-menu',
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
				<li><a href="/privacy-policy">Privacy Policy</a></li>
			</ul>
			<?php gravity_form(3, 0, 0); ?>
			<div class="social-icons">
				<a href="https://www.facebook.com/OregonWineCountry" rel="nofollow" aria-label="facebook" target="_blank"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/facebook.png"></a>
				<a href="http://instagram.com/oregonwinetrav" rel="nofollow" aria-label="instagram" target="_blank"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/instagram.png"></a>
				<a href="https://www.youtube.com/user/OregonWineCountry/" rel="nofollow" aria-label="youtube" target="_blank"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/youtube.png"></a>
				<a href="https://twitter.com/oregonwinetrav" rel="nofollow" aria-label="twitter" target="_blank"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/twitter.png"></a>
				<a href="https://www.pinterest.com/orwinecountry/" rel="nofollow" aria-label="pinterest" target="_blank"><img src="<?= get_stylesheet_directory_uri();?>/resources/assets/images/pinterest.png"></a>
			</div>
		</div>
	</div>
</footer> <!-- footer.tpl -->
<?php wp_footer(); ?>
