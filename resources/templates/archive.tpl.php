<?php
use function Madden\Theme\Child\template;
get_header(); 
$categories = ["mid-valley", "north-valley", "west-cascades", "south-valley"];
$regions = "";
if (isset($_GET['category'])){
    $category = $_GET["category"];
    if (in_array($category, $categories)) {
        $regions = $_GET["category"];
    }
} else {
    $category = "";
}
$show_date = false;
$args = array(
    'posts_per_page' => 12,
    'post_status' => 'publish',
    'orderby' => 'date',
);
if (isset($_GET["date"])){
    $args["order"] = $_GET["date"];
    $show_date = true;
    $date = $_GET["date"];
} else {
    $date = "ASC";
}
if (isset($_GET["post_type"])){
    $args["post_type"] = $_GET["post_type"];
}
if (isset($_GET["s"])){
    $args["s"] = $_GET["s"];
}
if (isset($_GET["category"])){
    $categories = explode(",", $_GET["category"]);
    $args['tax_query'] = array (
        array (
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $categories,
        ),
    );
}
if (isset($_GET["pg"])){
    $args['paged'] = $_GET["pg"];
} else {
    $args['paged'] = 1;
}
$the_query = new WP_Query( $args );

$colors = ["has-purple-background-color", "has-teal-background-color", "has-lime-background-color", "has-green-background-color"];

?>
<div class="main-container">
    <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">


    <div class="dropdowns">
        <div class="dropdown">
            <a id="dropdownlink" href class="dropdown__button dropdown__button__triangle">Filters</a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="regions-toggle" href>Region</a>
                <a class="date-toggle" href>Date</a>
            </div>
        </div>
        <div class="dropdown <?= $regions ? "" : "hiddenDropdown"; ?> regionsDropdown">
            <a id="dropdownlink" href class="dropdown__button dropdown__button__triangle"><?= $regions ? $regions : "regions" ?></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="north-valley" href="?<?php
                    echo http_build_query(array_merge($_GET, array("category"=>"north-valley", "pg" => 1)));
                    ?>
                ">North Valley</a>
                <a class="mid-valley" href="
                    ?<?php
                        echo http_build_query(array_merge($_GET, array("category"=>"mid-valley", "pg" => 1)));
                    ?>
                ">Mid Valley</a>
                <a class="south-valley" href="
                    ?<?php
                        echo http_build_query(array_merge($_GET, array("category"=>"south-valley", "pg" => 1)));
                    ?>
                ">South Valley</a>
                <a class="west-cascades" href="
                    ?<?php
                        echo http_build_query(array_merge($_GET, array("category"=>"west-cascades", "pg" => 1)));
                    ?>

                ">West Cascades</a>
            </div>
        </div>
        <div class="dropdown <?= $show_date ? "" : "hiddenDropdown"; ?> dateDropdown">
            <a id="dropdownlink" href class="dropdown__button dropdown__button__triangle"><?= isset($_GET["date"]) ? ($date == "ASC" ? "oldest" : "newest") : "date" ?></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="dropdown__links__oldest" href="
                    ?<?php
                        echo http_build_query(array_merge($_GET, array("date" => "desc", "pg" => 1 )));
                    ?>
                ">Newest</a>
                <a class="dropdown__links__newest" href="
                    ?<?php
                        echo http_build_query(array_merge($_GET, array("date" => "asc", "pg" => 1 )));
                    ?>
                ">Oldest</a>
            </div>
        </div>
    </div> 
    <div class="page-search">
        <form role="search" method="get" id="innerSearchForm" class="searchform" action="<?= home_url( '' ) ?>" >
            <label aria-label="submit">
               <input type="image" src="<?= get_stylesheet_directory_uri()."/resources/assets/images/mag_glass.svg" ?>" border="0" alt="Submit" />
            </label>
            <label aria-label="search">
                <input type="text" name="s" id="InnersearchInput" placeholder="search" /></label>
        </form>
    </div>
        <div class="archive-page">
        <?php
        $i = 0;
        if ( $the_query->have_posts()) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                 ?>
                <div class="archive-page__item">
                    <a href="<?= get_the_permalink() ?>">
                        <div class="archive-page__item__image">
                            <?php 
                            if (has_post_thumbnail()){
                                the_post_thumbnail("big-thumbnail");
                            } else {
                                echo "<img src='".get_stylesheet_directory_uri()."/resources/assets/images/articles-thumbnail.png' alt='The Willamette Valley'>";
                            }
                            ?>
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
    </div>
    <div class="navigation_links"><p>
        <?php if($args["paged"] > 1){
            echo "<a href='?";
            echo http_build_query(array_merge($_GET, array("pg" => ($args["paged"] - 1 ))));
            echo "' class='previous_link'>Previous Page</a>";
        }
        if ($the_query->max_num_pages > $args["paged"]){
            echo "<a href='?";
            echo http_build_query(array_merge($_GET, array("pg" => ($args["paged"] + 1 ))));
            echo "' class='next_link'>Next Page</a>";
        }
        ?>
    </p></div>

    </main><!-- .site-main archive.tpl.php -->  
</div>

<?php 
    get_footer();
?>