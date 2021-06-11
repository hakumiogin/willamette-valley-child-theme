<div class="category-slider-parent">
    <?php 
    $category = get_field("category");
    $thumbnail = "";
    $args = array(
		'posts_per_page' => 12,
		'post_type'  => 'poi',
	    'tax_query' => array(
			array(
				'taxonomy' => 'type',
				'field'    => 'term_id',
				'terms'    => $category,
			),
		),
	
	);

    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() && $the_query->post_count >= 4) { ?>
        <div class="slider category-slider">
        <?php
            $colors = ["has-purple-background-color", "has-teal-background-color", "has-lime-background-color", "has-green-background-color"];
            $i = 0;
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                echo '<div class="category-slider__item">';
                echo '<a href="'.get_the_permalink().'">';
                echo '<div class="category-slider__item__image">';
                if (get_the_post_thumbnail("thumbnail")){
                    the_post_thumbnail();
                } else {
                    $photos = get_field("photos", get_the_iD());
                    if ($photos) {
                        $thumbnail = $photos[0]["image_url"];
                        echo "<img src='$thumbnail' alt='".$photos[0]["image_alt"]."'>";

                    } else {
                        echo "<img src='/wp-content/uploads/2021/05/requestAVisitorGuide-150x150.jpg' alt='The Willamette Valley'>";
                    }		
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
    
