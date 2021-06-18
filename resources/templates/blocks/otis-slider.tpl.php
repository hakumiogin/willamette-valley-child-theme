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
    foreach ($categories as $category){
        $termchildren = get_term_children( $category, $taxonomy_name );
        if (!in_array($category, $terms)){
            $terms[] = $category;
        }
        foreach ($termchildren as $child){
            if (!in_array($child, $terms)){
                $terms[] = $child;
            }
        }
    }
    $termstring = implode(", ", $terms);
    global $wpdb;
    $sql = "SELECT max(wp_posts.ID) AS ID FROM wp_posts LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) WHERE ( wp_term_relationships.term_taxonomy_id IN ($termstring) ) AND wp_posts.post_type = 'poi' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'acf-disabled' OR wp_posts.post_status = 'dp-rewrite-republish' OR wp_posts.post_status = 'private') GROUP BY wp_posts.post_title, wp_posts.post_date ORDER BY wp_posts.post_date DESC LIMIT 0, 60";
    $pageposts = $wpdb->get_results($sql);
    if ($pageposts):
        $posts = [];
        foreach($pageposts as $the_post){
            $date = get_field("start_date", $the_post->ID);
            if ($date){
                $dateTime = DateTime::createFromFormat('m/d/Y', $date);
                $timestamp = $dateTime->format('U');
            } else {$timestamp = 0;}
            $posts[]  = [$the_post->ID, $timestamp];
        }
        usort($posts, "sort_times");
        echo '<div class="slider category-slider">';
        $i = 0;
        foreach ($posts as $the_post):
            $post_id = $the_post[0];

            $postobject = get_post($post_id);
            $links = get_field("links", $postobject);
            if ($links) {
                $link = $links[0]["url"];
            } else {
                $link = "#";
            }
            echo '<div class="category-slider__item">';
            echo '<a href="'.$link.'">';

            $date = get_field("start_date", $postobject);
            if ($date){
                $dateTime = DateTime::createFromFormat('m/d/Y', $date);
                $formatted_date = $dateTime->format('F j');
                echo '<div class="category-slider__item__date '.$colors[$i].'">'.$formatted_date.'</div>';
            }
            echo '<div class="category-slider__item__image">';
            $photos = get_field("photos", $postobject);

            if ($photos) {
                $thumbnail = $photos[0]["image_url"];
                echo "<img src='$thumbnail' alt='".$photos[0]["image_alt"]."'>";
            } else {
                echo "<img src='".get_stylesheet_directory_uri()."/resources/assets/images/events-thumbnail.png' alt='The Willamette Valley'>";
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
    