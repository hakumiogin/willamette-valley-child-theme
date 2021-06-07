<?php
$is_post = get_post_type() === "post";
get_header(); 

?>
<div class="main-container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php 
            if ($is_post){
                echo "<div class='post-body'>";
            }
            ?>
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();
  
            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            the_content();
  
        // End the loop.
        endwhile;
        ?>
            <?php 
                if ($is_post){
                    echo "</div>";
                }
            ?>
        </main><!-- .site-main -->  
<?php get_footer(); ?>


</div>