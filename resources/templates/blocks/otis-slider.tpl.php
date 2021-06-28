<?php 

    $colors = ["has-purple-background-color", "has-teal-background-color", "has-lime-background-color", "has-green-background-color"];

    $categories = get_field("category");
    print_r($categories);
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
    if( is_array($categories) ){

        foreach ($categories as $category){
            $term = get_term_by('ID', $category, 'type');
            print_r($term);
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
        print_r($terms);
        if (in_array("Events", $terms)){
            $orderby = "ORDER BY wp_posts.post_date";
        } else {
            $orderby = "ORDER BY RAND()";
        }
    }
    $termstring = implode(", ", $terms);
    global $wpdb;
    $sql = "SELECT max(wp_posts.ID) AS ID FROM wp_posts LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) WHERE ( wp_term_relationships.term_taxonomy_id IN ($termstring) ) AND wp_posts.post_type = 'poi' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'acf-disabled' OR wp_posts.post_status = 'dp-rewrite-republish' OR wp_posts.post_status = 'private') GROUP BY wp_posts.post_title, wp_posts.post_date $orderby DESC LIMIT 0, 100";
    $pageposts = $wpdb->get_results($sql);
    if ($pageposts):
        $posts = [];
        foreach($pageposts as $the_post){
            $date = get_field("start_date", $the_post->ID);
            if ($date){
                $dateTime = DateTime::createFromFormat('d/m/Y', $date);
                $timestamp = $dateTime->format('U');
            } else {$timestamp = 0;}
            $posts[]  = [$the_post->ID, $timestamp];
        } ?>
    <div class="dropdowns">
        <div class="dropdown">
            <a id="dropdownlink" href="#" class="dropdown__button">Filters<span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="regions-toggle" href="#">Region</a>
                <a class="date-toggle" href="#">Date</a>
            </div>
        </div>
        <div class="dropdown <?= $regions ? "" : "hiddenDropdown"; ?> regionsDropdown">
            <a id="dropdownlink" href="#" class="dropdown__button"><?= $regions ? $regions : "regions" ?><span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="north-valley" href="articles/?category=north-valley<?= $date ? "&date=".$date : "" ?>">North Valley</a>
                <a class="mid-valley" href="articles/?category=mid-valley<?= $date ? "&date=".$date : "" ?>">Mid Valley</a>
                <a class="south-valley" href="articles/?category=south-valley<?= $date ? "&date=".$date : "" ?>">South Valley</a>
                <a class="west-cascades" href="articles/?category=west-cascades<?= $date ? "&date=".$date : "" ?>">West Cascades</a>
            </div>
        </div>
        <div class="dropdown <?= $show_date ? "" : "hiddenDropdown"; ?> dateDropdown">
            <a id="dropdownlink" href="#" class="dropdown__button"><?= isset($_GET["date"]) ? ($date == "ASC" ? "oldest" : "newest") : "date" ?><span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="dropdown__links__oldest" href="articles/?date=DESC<?= $category ? "&category=".$category : "" ?>">Newest</a>
                <a class="dropdown__links__newest" href="articles/?date=ASC<?= $category ? "&category=".$category : "" ?>">Oldest</a>
            </div>
        </div>
    </div> 
    <div class="category-slider-parent  ">

<?php
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
            $date = get_field("start_date", $postobject);
            if ($date){
                $dateTime = DateTime::createFromFormat('d/m/Y', $date);
                if (new DateTime() > $dateTime){
                    continue;
                }
                $formatted_date = $dateTime->format('F j Y');
                echo '<div class="category-slider__item">';
                echo '<a href="'.$link.'" target="_blank">';    
                echo '<div class="category-slider__item__date '.$colors[$i].'">'.$formatted_date.'</div>';
            } else {
                echo '<div class="category-slider__item">';
                echo '<a href="'.$link.'" target="_blank">';    
            }

            echo '<div class="category-slider__item__image">';
            $photos = get_field("photos", $postobject);

            if ($photos) {
                $thumbnail = $photos[0]["image_url"];
                echo "<img src='$thumbnail' alt='".$photos[0]["image_alt"]."'>";
            } else {
                echo "<img src='".get_stylesheet_directory_uri()."/resources/assets/images/events-thumbnail.png' alt='The Willamette Valley'>";
            }
            echo '<div class="category-slider__item__external-warning"></div>';
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
    