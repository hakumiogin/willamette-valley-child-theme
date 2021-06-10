<?php
get_header(); 

?>
<div class="main-container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();
            echo '<div class="category-slider__item">';
            echo '<div class="category-slider__item__image">';
            if (get_the_post_thumbnail("thumbnail")){
                the_post_thumbnail();
            } else {
                echo "<img src='/wp-content/uploads/2021/05/requestAVisitorGuide-150x150.jpg' alt='The Willamette Valley'>";
            }
            echo '</div>';
            echo '<div class="category-slider__item__title">';
            echo '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
            echo '</div></div>';

            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            the_content();
        // End the loop.
        endwhile;
        
        ?>
        </main><!-- .site-main single.tpl.php -->  

</div>

<?php 
    get_footer();
?>