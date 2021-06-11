<div class="category-slider-parent  ">
    
    <?php 

    $colors = ["has-purple-background-color", "has-teal-background-color", "has-lime-background-color", "has-green-background-color"];

    $categories = get_field("category");
    //replaced by the sql below.
    // $args = array(
	// 	'posts_per_page' => 16,
	// 	'post_type'  => 'poi',
	//     'tax_query' => array(
	// 		array(
	// 			'taxonomy' => 'type',
	// 			'field'    => 'term_id',
	// 			'terms'    => $category,
	// 		),
	// 	),
	// );
    $taxonomy_name = 'type';
    $terms = [];
    $termchildren = [];
    $i = 0;
    foreach ($categories as $category){
        $termchildren[$i] = get_term_children( $category, $taxonomy_name );
        array_push($termchildren[$i], $category);
    }
    $sqlterm = "";
    foreach ($termchildren as $child){
        $termstring = implode(", ", $child);
        $sqlterm = $sqlterm ."( wp_term_relationships.term_taxonomy_id IN ($termstring) ) AND ";
    }
    $termstring = implode(", ", $terms);
    echo "<h1>$termstring</h1>";
    global $wpdb;
    $sql = "SELECT wp_posts.ID FROM wp_posts LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) WHERE $sqlterm wp_posts.post_type = 'poi' AND wp_posts.ID IN (SELECT max(wp_posts.ID) FROM wp_posts GROUP BY wp_posts.post_title)  AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'acf-disabled' OR wp_posts.post_status = 'dp-rewrite-republish' OR wp_posts.post_status = 'private') GROUP BY wp_posts.ID ORDER BY wp_posts.post_date DESC LIMIT 0, 16";
    $pageposts = $wpdb->get_results($sql);
    if ($pageposts):
        global $post;
        echo '<div class="slider category-slider">';
        $i = 0;
        foreach ($pageposts as $the_post):
            $postobject = get_post($the_post);
            
            $links = get_field("links", $postobject);
            if ($links) {
                $link = $links[0]["url"];
            } else {
                $link = "#";
            }
            echo '<div class="category-slider__item">';
            echo '<a href="'.$link.'">';
            echo '<div class="category-slider__item__image">';
            $photos = get_field("photos", $postobject);
            if ($photos) {
                $thumbnail = $photos[0]["image_url"];
                echo "<img src='$thumbnail' alt='".$photos[0]["image_alt"]."'>";
            } else {
                echo "<img src='/wp-content/uploads/2021/05/requestAVisitorGuide-150x150.jpg' alt='The Willamette Valley'>";
            }		
            echo '</div>';
            echo '<div class="category-slider__item__title '.$colors[$i].'">';
            $wordwrap = wordwrap(get_the_title($postobject->ID), 80, "\n");
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
        endforeach;
        echo '</div>';
    endif;
    wp_reset_postdata();

    ?>
</div>
    