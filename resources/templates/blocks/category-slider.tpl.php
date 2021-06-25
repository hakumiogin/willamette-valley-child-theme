<div class="category-slider-parent">
    <?php 
    $current_month = (int)date('m');
    $current_seasons = array();
    $all_seasons = array('summer', 'winter', 'spring', 'fall');
    if ($current_month <= 2 || $current_month >= 11){
        $current_seasons[] = 'winter';
    }
    if ($current_month >= 2 && $current_month <= 5){
        $current_seasons[] = 'spring';
    }
    if ($current_month >= 5 && $current_month <= 8){
        $current_seasons[] = 'summer';
    }
    if ($current_month >= 8 && $current_month <= 11){
        $current_seasons[] = 'fall';
    }
    $excluded_seasons = array_diff($all_seasons, $current_seasons);
    $categories = get_field("category");
    $category_query = [];
    $show = get_field("show");
    if (!$show) $show = "or";
    $category_query['relation'] = $show;
    foreach($categories as $category){
        $category_query[] = array(
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $category,
        );
    }
    $args = array(
        'posts_per_page' => 100,
        'post_type'  => 'post',
        // 'meta_query' => array(
        //     array(
        //     'key' => '_thumbnail_id',
        //     'compare' => 'EXISTS'
        //     ),
        // ),
        'tax_query' => array(
            $category_query,
            array (
                'operator' => 'NOT IN',
                'taxonomy' => 'category',
                'field' => 'term_taxonomy_id',
                'terms' => array ( 254 )
            ),
            array  (
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $excluded_seasons,
                'operator' => 'NOT IN'
            )
        )
    );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts()) { ?>
        <div class="slider category-slider">
        <?php
        $colors = ["has-purple-background-color", "has-teal-background-color", "has-lime-background-color", "has-green-background-color"];
        $i = 0;
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            echo '<div class="category-slider__item">';
            echo '<a href="'.get_the_permalink().'">';
            echo '<div class="category-slider__item__image">';
            if (has_post_thumbnail()){
                the_post_thumbnail("big-thumbnail");
            } else {
                echo "<img src='".get_stylesheet_directory_uri()."/resources/assets/images/articles-thumbnail.png' alt='The Willamette Valley'>";
            }
            echo '</div>';
            echo '<div class="category-slider__item__title '.$colors[$i].'">';
            $wordwrap = wordwrap(get_the_title(), 60, "\n");
            $wordwrapsplit = explode("\n", $wordwrap);
            $wordwrap = $wordwrapsplit[0];
            if (count($wordwrapsplit) > 1){
                $wordwrap = $wordwrap. "...";
            }
            echo '<p>'.$wordwrap.'</p>';
            echo '</div></a></div>';
            $i++;
            if ($i > count($colors) - 1){
                $i = 0;
            }
        }
        echo '</div>';
    }
    wp_reset_postdata();

    ?>
</div>