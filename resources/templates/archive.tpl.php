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
if (isset($_GET["date"])){
    $date = $_GET["date"];
    $show_date = true;
} else {
    $date = "ASC";
}
?>
<div class="main-container">
    <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">


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
            <a id="dropdownlink" href="#" class="dropdown__button"><?= isset($_GET["date"]) ? ($date == "DESC" ? "oldest" : "newest") : "date" ?><span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="dropdown__links__oldest" href="articles/?date=ASC<?= $category ? "&category=".$category : "" ?>">Newest</a>
                <a class="dropdown__links__newest" href="articles/?date=DESC<?= $category ? "&category=".$category : "" ?>">Oldest</a>
            </div>
        </div>
    </div> 
    <div class="page-search">
        <form role="search" method="get" id="searchForm" class="searchform" action="<?= home_url( '/' ) ?>" >
            <label aria-label="submit">
               <input type="image" src="<?= get_stylesheet_directory_uri()."/resources/assets/images/mag_glass.svg" ?>" border="0" alt="Submit" />
            </label>
            <label aria-label="search">
                <input type="text" name="s" id="searchInput" placeholder="search" /></label>
        </form>
    </div>
        <div class="archive-page">
        <?php
        if ($category){
            $args = array(
                'posts_per_page' => 12,
                'post_type'  => 'post',
                'orderby' => 'date',
                'order'   => $date,
                'tax_query' => array (
                    array (
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $category,
                    ),
                )
            );    
        } else {
            $args = array(
                'posts_per_page' => 12,
                'post_type'  => 'post',
                'orderby' => 'date',
                'order'   => $date,
            );    
        }
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
                            <?php 
                            if (has_post_thumbnail()){
                                the_post_thumbnail("big-thumbnail");
                            } else {
                                echo "<img src='/wp-content/uploads/2021/05/requestAVisitorGuide-150x150.jpg' alt='The Willamette Valley'>";
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
        <div class="navigation"><p><?php posts_nav_link(); ?></p></div>
    </div>
    </main><!-- .site-main archive.tpl.php -->  
</div>

<?php 
    get_footer();
?>