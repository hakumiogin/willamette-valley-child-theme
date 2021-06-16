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

        <div class="archive-page">
        <?php
        $colors = ["has-purple-background-color", "has-teal-background-color", "has-lime-background-color", "has-green-background-color"];
        $i = 0;
        if (have_posts()) {
            while (have_posts() ) {
                the_post();
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