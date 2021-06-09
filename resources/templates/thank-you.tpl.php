<?php
/*
	* If this is a valid email form submission, show a thank you page.
	* If not, redirect to the homepage.
	*/
if( true === $_GET['signup'] ) {
	get_header(); 
	?>
	<div class="main-container">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
				/*
				 * Include the post format-specific template for the content. If you want to
				 * use this in a child theme, then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );
			// End the loop.
			endwhile;
			?>
			</main><!-- .site-main  -->
		</div><!-- .content-area end of thank-you.tpl -->
	<?php get_footer(); ?>
	</div><?php
} else {
	wp_redirect( home_url() );
	exit;
}
