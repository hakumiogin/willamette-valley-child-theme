<?php
get_header(); 

?>
<div class="main-container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <div class="archive-page">
        <?php
        // Start the loop.
        $args = array(
            'posts_per_page' => 12,
            'post_type'  => 'post',
        );
        $the_query = new WP_Query( $args );
        $colors = ["has-purple-background-color", "has-teal-background-color", "has-lime-background-color", "has-green-background-color"];
        $i = 0;
        if ( $the_query->have_posts()) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                 ?>
                <div class="archive-page__item">
                    <a href="<?= get_the_permalink() ?>">
                        <div class="archive-page__item__image">
                            <?php the_post_thumbnail("big-thumbnail"); ?>
                        </div>
                        <div class="archive-page__item__title <?= $colors[$i] ?>">
                            <p><?= get_the_title() ?></p>
                        </div>
                    </a>
                </div>
                <?php 
                $i++;
                if ($i > count($colors) - 1){
                    $i = 0;
                }
            }
        }
        wp_reset_postdata(); ?>
        <div class="navigation"><p><?php posts_nav_link(); ?></p></div>
    </div>
    </main><!-- .site-main archive.tpl.php -->  
</div>

<?php 
    get_footer();
?>