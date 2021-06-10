<div class="category-slider-parent">
    <?php 
    $category = get_field("category");
    print_r( $category);
    $args = array(
        'cat' => $category[0],
        'posts_per_page' => 8,
        'post_type'  => 'post',
        'meta_query' => array(
            array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS'
            ),
        )
    );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() && $the_query->post_count >= 4) { ?>
        <div class="slider-left-button-parent">
            <div class="slider-left-button" id="slideshowleft">
                <svg width="18" height="44" viewBox="0 0 18 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-1.09278e-06 22L18 43.6506L18 0.349366L-1.09278e-06 22Z" fill="#B4BC33"/>
                </svg>
            </div>
        </div>
        <div class="slider-right-button-parent">
            <div class="slider-right-button" id="slideshowright">
                <svg width="18" height="47" viewBox="0 0 18 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 23.5L-2.54165e-07 46.4497L1.75216e-06 0.550327L18 23.5Z" fill="#B4BC33"/>
                </svg>
            </div>
        </div>
        <div class="category-slider" id="category-slider">
        <?php
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
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
        }
        echo '</div>';
    }
    wp_reset_postdata();

    ?>
</div>