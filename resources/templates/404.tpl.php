<?php
get_header(); 

?>
<div class="main-container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <h1><?php _e( "Whoopsie-daisy!") ?></h1>
            <p>
            <?php _e( "The page you are looking for is not on our site." ); ?>
            </p>
            <p>
	    		<strong><?php _e( "It looks like you were looking for:" ); ?> <span id="no-link-404">https://<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?></span></strong>
    		</p>
            <p>
                You can use the navigation up top to continue your Willamette Valley journey, or we have a few suggestions as well:
            </p>
            <ul>
                <li>Learn about our <a href="https://master-7rqtwti-uyz4sq2cgrby4.us-3.platformsh.site/wineries/">great wineries</a></li>
                <li>Find some <a href="https://master-7rqtwti-uyz4sq2cgrby4.us-3.platformsh.site/things-to-do/">fun things to do</a></li>
                <li>Look at all the <a href="/articles">fun articles</a> that still have</li>
            </ul>


        </main><!-- .site-main 404.tpl.php -->  

</div>

<?php 
get_footer();
?>