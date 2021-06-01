<div class="category-slider">
<?php 
$args = array(
    'cat' => get_field("category")[0],
    'posts_per_page' => 4,
);

    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
			echo '<div class="category-slider__item">';
			echo '<div class="category-slider__item__image">';
			the_post_thumbnail();
			echo '</div>';
			echo '<div class="category-slider__item__title">';
			echo '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
			echo '</div></div>';
        }
    } else {
		echo "No posts";
    }
    wp_reset_postdata();
?>
</div>