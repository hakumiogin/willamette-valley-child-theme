	<?php 
	if (!is_front_page( )):?>
		<!-- wp:willamette-blocks/image-box {"id":140408,"url":"https://newsitedev-ama7zea-uyz4sq2cgrby4.us-3.platformsh.site/wp-content/uploads/2021/06/Rectangle-13-5-scaled.jpg","className":"is-style-full-width-center"} -->
		<div class="wp-block-willamette-blocks-image-box is-style-full-width-center"><div style="background-image:url(https://newsitedev-ama7zea-uyz4sq2cgrby4.us-3.platformsh.site/wp-content/uploads/2021/06/Rectangle-13-5-scaled.jpg);" class="wp-block-willamette-blocks-image-box__image"><div class="wp-block-willamette-blocks-image-box__content"><!-- wp:group {"backgroundColor":"teal","textColor":"white"} -->
		<div class="wp-block-group has-white-color has-teal-background-color has-text-color has-background"><div class="wp-block-group__inner-container"><!-- wp:columns -->
		<div class="wp-block-columns"><!-- wp:column {"width":"20%"} -->
		<div class="wp-block-column" style="flex-basis:20%"><!-- wp:heading -->
		<h2>request a<br>visitor guide</h2>
		<!-- /wp:heading --></div>
		<!-- /wp:column -->
		
		<!-- wp:column {"width":"65%"} -->
		<div class="wp-block-column" style="flex-basis:65%"><!-- wp:paragraph -->
		<p>Your adventure begins with the official Willamette Valley Travel Guide. Request your complimentary printed guide or download a digital guide today.</p>
		<!-- /wp:paragraph -->
		
		<!-- wp:buttons -->
		<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"purple","className":"is-style-Two-Tone"} -->
		<div class="wp-block-button is-style-Two-Tone"><a class="wp-block-button__link has-purple-background-color has-background">Get a Guide</a></div>
		<!-- /wp:button --></div>
		<!-- /wp:buttons --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns --></div></div>
		<!-- /wp:group --></div></div></div>
		<!-- /wp:willamette-blocks/image-box -->
	<?php endif;
		// $visitor_guide_reuseable_block = get_post( 135448 );
		// $block_content = $visitor_guide_reuseable_block->post_content;
		// echo $block_content;	
	?>
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
