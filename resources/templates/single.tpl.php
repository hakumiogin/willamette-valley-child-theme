<?php
$is_post = get_post_type() === "post";
get_header(); 

?>
<div class="main-container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();
        if ($is_post){
            echo "<h1>".get_the_title()."</h1>";
            $contributors = get_the_terms( $post , 'contributor');
            $contributor_html = "";
            if( is_array($contributors) ){
                $contributor_list = [];
                foreach( $contributors as $contributor ){
                    $contributor_list[] = "<span>" . $contributor->name . "</span>";
                }
                echo "<div class='contributors'>By " . implode( ", " , $contributor_list ) . "</div>";
            }
        }
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